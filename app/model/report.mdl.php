<?php

  class Report extends Model {
    protected $table  = 'entity_report_basic';
    protected $pkey   = 'idreport_basic';

    protected $ASOC_Exp = Array(
                                881,
                                883,
                                882,
                                879,
                                878,
                                880,
                                876,
                                877,
                                959,
                            );


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
          $Report->ASOC_EXP = false;
          $Report->ASOC_EXP = in_array($id, $this->ASOC_Exp);
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
                    `' . $this->table . '`.`gs`,
                    `' . $this->table . '`.`stato_di_avanzamento`,
                    `' . $this->table . '`.`lat_`,
                    `' . $this->table . '`.`lon_`,
                    UNIX_TIMESTAMP(`' . $this->table . '`.`modified_at`) AS mod_date,
                    UNIX_TIMESTAMP(`' . $this->table . '`.`created_at`) AS create_date,
                    `' . $this->table . '`.`autore`, 
                    `auth`.`username`,
                    `auth`.`idauth` AS profile,
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
                // Check ASOC Exp
                $list[$i]->ASOC_EXP = in_array($report->id, $this->ASOC_Exp);
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
      $sql = '  SELECT idreport_basic, titolo, username, email, erb.created_at, erb.modified_at, status, status_tab_3 FROM `' . $this->table . '` AS erb 
                INNER JOIN auth ON auth.idauth = created_by 
                WHERE status = 3 OR status = 7 OR (status = 5 AND reviewed_by = :user_1) OR (created_by = :user_2)                 
                ORDER BY erb.modified_at DESC';


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

    public function projectReports(){
        $sql = "SELECT 
                    GROUP_CONCAT(
                        CONCAT(`entity_report_basic`.`idreport_basic`, ':::', `entity_report_basic`.`modified_at`) 
                        SEPARATOR ',') AS `reports`,
                    `entity_report_basic`.`oc_project_code` AS `oc_project_code`
                FROM
                    `entity_report_basic`    
                WHERE 
                    `entity_report_basic`.`status` >= 7
                GROUP BY `entity_report_basic`.`oc_project_code`";
        $stmt = $this->database->prepare($sql);
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

    /** Report List built for API
      * Data Model Mock:
      *     "uid": 1,
            "titolo": "EFFICIENTAMENTO ENERGETICO DEL NUOVO OSPEDALE DI PORDENONE",
            "dataInserimento": 20150313,
            "codGiudizioSintetico": 6,
            "ocCodTemaSintetico": "04",
            "ocFinanzTotPubNetto": 7583475,
            "ocCodProgrammaOperativo": "2007EM002FA002",
            "ocCodCicloProgrammazione": 1,
            "lat": 45.9680876,
            "long": 12.6528061
     * */

    public function getReportList(){
        $sql = 'SELECT 
                    `'. $this->table.'`.`idreport_basic` AS `id`,
                    `'. $this->table.'`.`titolo`,
                    UNIX_TIMESTAMP(`'. $this->table.'`.`created_at`) AS `uts_created_at`,
                    `'. $this->table.'`.`giudizio_sintetico`,
                    `'. $this->table.'`.`api_data`,
                    `'. $this->table.'`.`lat_`,
                    `'. $this->table.'`.`lon_`
                 FROM `'. $this->table.'` 
                 WHERE `' . $this->table . '`.`status` = 7
                 ORDER BY `' . $this->table . '`.`created_at` DESC';

        $stmt = $this->database->prepare($sql);
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

    /* get only existing Giudizi Sintetici for Report Finder API */
    public function getGS(){
        $sql = 'SELECT DISTINCT(giudizio_sintetico) FROM ' . $this->table . ' WHERE status = 7';
        $stmt = $this->database->prepare($sql);
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

    /** STAT COUNTERS AND SUCH, USED ON PROFILE PAGES **/
    public function reportCount(){
        $sql = 'SELECT COUNT(*) AS counter FROM ' . $this->table . ' WHERE status = 7';
        $stmt = $this->database->prepare($sql);
        $query = $stmt->execute();

        if(!$query){
            $this->Errors->set(501);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return $this->Errors;
        } else {
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            return $data->counter;
        }
    }


    /** OC API Queries
    Codice Locale Progetto (oc_project_code)
    URL CLP Opencoesione
    URL Report
    ID Report
    Tipo Utenza (ASOC, ASOC EXP, Uni, Civil Society)
    Team ID ASOC (se presente aggiungere)
    Data monitoraggio (YYYYMMDD) (created_at)
    Giudizio Sintetico (codice numerico)
    Stato Avanzamento (codice numerico)
     */
    public function ocProjectReports(){
        $sql = 'SELECT 
                    idreport_basic AS id_report_monithon, 
                    oc_project_code AS codice_locale_progetto,
                    id_open_coesione AS url_opencoesione,
                    DATE_FORMAT(created_at, "%Y%m%d") AS data_report_monithon,
                    gs AS giudizio_di_efficacia,
                    stato_di_avanzamento AS stato_di_avanzamento_al_monitoraggio,
                    created_by AS author, 
                    a.role,
                    ea.remote_id AS asoc_team_id
                FROM entity_report_basic AS erb
                INNER JOIN (SELECT idauth, role FROM auth) AS a ON a.idauth = erb.created_by
                LEFT JOIN (SELECT auth, remote_id FROM entity_asoc WHERE auth != 349) AS ea ON ea.auth = erb.created_by
                WHERE 
                    status >= 7 AND
                    erb.oc_project_code IS NOT NULL                      
                ORDER BY id_report_monithon';
        $stmt = $this->database->prepare($sql);
        $query = $stmt->execute();
        if(!$query){
            $this->Errors->set(501);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return false;
        } else {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
  }
