<?php

  class Report extends Model {
    protected $table  = 'entity_report_basic';
    protected $pkey   = 'idreport_basic';


    public function getReport($id){
      $Report = $this->find($id);
      if($Report){

          // Get Files
          $Files = new Repo();
          $Report->files = $Files->getFiles(T_REP_BASIC, $id, 2);
          foreach($Report->files as $i => $file){
            $Report->files[$i]->info = $Files->getInfo(ROOT.DS.'public'.DS.'resources'.DS.$file->file_path);
          }

          // Get Links
          $LoadLinks = new Meta('link_repository');
          $LoadLink = new Link();
          $Report->links = $LoadLinks->getRepoReference('link_repository', T_REP_BASIC, $id);

          // Get Videos
          $LoadVideos = new Meta('video_repository');
          $LoadVideo  = new Video();
          $Vids = $LoadVideos->getRepoReference('video_repository', T_REP_BASIC, $id);
          foreach($Vids as $i => $v){
              if(strpos($v->URL, 'youtube')){
                  $v_pieces = explode('?v=', $v->URL);
                  $v_id = array_pop($v_pieces);
                  $Vids[$i]->embed = 'https://www.youtube.com/embed/' .trim($v_id);
              }
              else if(strpos($v->URL, 'youtu.be')){
                  $v_pieces = explode('/', $v->URL);
                  $v_id = array_pop($v_pieces);
                  $Vids[$i]->embed = 'https://www.youtube.com/embed/' . trim($v_id);
              }
              else if(strpos($v->URL, 'vimeo')){
                  $v_pieces = explode('/', $v->URL);
                  $v_id = array_pop($v_pieces);
                  $Vids[$i]->embed = 'https://player.vimeo.com/video/' . trim($v_id);
              }
              else {
                  $Vids[$i]->embed = $v->URL;
              }
          }
          $Report->videos = $Vids;

          return $Report;
      }
      else {
          return false;
      }
    }

    public function getReports($start = null, $limit = null){
        $sql = 'SELECT 
                    `' . $this->table . '`.`idreport_basic` AS id,
                    `' . $this->table . '`.`titolo`,
                    `' . $this->table . '`.`descrizione`,
                    `' . $this->table . '`.`giudizio_sintetico`,
                    `' . $this->table . '`.`lat_`,
                    `' . $this->table . '`.`lon_`,
                    UNIX_TIMESTAMP(`' . $this->table . '`.`modified_at`) AS mod_date,
                    UNIX_TIMESTAMP(`' . $this->table . '`.`created_at`) AS create_date,
                    `' . $this->table . '`.`autore`, 
                    `auth`.`username`,
                    `auth`.`role`
                 FROM  `' . $this->table . '` 
                 INNER JOIN `auth` ON `auth`.`idauth` = `' . $this->table . '`.`created_by` 
                 WHERE `' . $this->table . '`.`status` = 7
                 ORDER BY `' . $this->table . '`.`created_at` DESC';
        if(!is_null($start) && !is_null($limit)){
            $sql .= ' LIMIT ' . $start . ', ' . $limit;
        }

        $stmt = $this->database->prepare($sql);
        $query = $stmt->execute();
        if(!$query){
            $this->Errors->set(501);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return $this->Errors;
        } else {
            $list = $stmt->fetchAll(PDO::FETCH_OBJ);
            $Files = new Repo();
            foreach($list as $i => $report){
                // Get Files
                $list[$i]->files = $Files->getFiles(T_REP_BASIC, $report->id, 2);
                foreach($list[$i]->files as $l => $file){
                    $file->info = $Files->getInfo(ROOT.DS.'public'.DS.'resources'.DS.$file->file_path);
                    $info = explode('/', $file->info);
                    if ($info[0] == 'image') {
                        $list[$i]->images[] = $file;
                    }
                }
            }
            return $list;
        }
        
    }
    public function counter($status = null){
        $sql = 'SELECT COUNT(idreport_basic) AS counter FROM ' . $this->table;
        if(!is_null($status)){
            $sql .= ' WHERE status = ' . $status;
        }
        $stmt = $this->database->prepare($sql);
        $query = $stmt->execute();
        if(!$query){
            $this->Errors->set(501);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return $this->Errors;
        } else {
            $counter = $stmt->fetch(PDO::FETCH_OBJ);
            return $counter->counter;
        }
    }

    public function reviewableReports($id_user){
      $sql = '  SELECT * FROM `' . $this->table . '` 
                INNER JOIN auth ON auth.idauth = created_by 
                WHERE status = 3 OR status = 7 OR (status = 5 AND reviewed_by = :user_1) OR (created_by = :user_2)                 
                ORDER BY ' . $this->table . '.modified_at DESC';
      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':user_1', $id_user, PDO::PARAM_INT);
      $stmt->bindParam(':user_2', $id_user, PDO::PARAM_INT);

      $query = $stmt->execute();
      if(!$query){
        $this->Errors->set(501);
        if(SYSTEM_STATUS == 'development'){
          dbga($stmt->errorInfo());
        }
        return $this->Errors;
      } else {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
      }
    }


    public function checkProject($url){
        $str_code_1 = '%' . $url . '%';

        $sql = 'SELECT 
                    idreport_basic, 
                    titolo, 
                    UNIX_TIMESTAMP(created_at) AS creation_ts,
                    DATE_FORMAT(created_at, "%d/%m/%Y") AS creation_date
                FROM 
                    entity_report_basic 
                WHERE 
                    id_open_coesione LIKE \''.$str_code_1.'\'
                    AND 
                    status = 7 
                ORDER BY creation_ts DESC';

        $stmt = $this->database->prepare($sql);
        //$stmt->bindParam(':url_1', $str_code_1);

        $query = $stmt->execute();
        if(!$query){

            return false;
        } else {
            $reports = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $reports;
        }
    }

    /** Method is used by API - leveraged by Monithon Map Wizard Map (Sheldon Studio) */
    public function getReportsByProject($project){

        $sql = "SELECT idreport_basic, created_at FROM entity_report_basic WHERE status >= 7 AND oc_project_code = :project ORDER BY created_at DESC";
        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':project', $project, PDO::PARAM_STR);
        $query = $stmt->execute();
        if(!$query){
            $this->Errors->set(501);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return $this->Errors;
        } else {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

  }
