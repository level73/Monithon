<?php

  class Report extends Model {
    protected $table  = 'entity_report_basic';
    protected $pkey   = 'idreport_basic';


    public function getReport($id){
      $Report = $this->find($id);
      if($Report){
          $Files = new Repo();
          $Videos = new Video();
          $Links = new Link();

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
              $Vids[$i]->embed = 'https://www.youtube.com/embed/' . $v_id;
            }
          }
          $Report->videos = $Vids;

          return $Report;
      }
      else {
          return false;
      }
    }

    public function reviewableReports($id_user){
      $sql = '  SELECT * FROM `' . $this->table . '` 
                INNER JOIN auth ON auth.idauth = created_by 
                WHERE status = 3 OR (status = 5 AND reviewed_by = :user_1) OR (created_by = :user_2)                 
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

  }
