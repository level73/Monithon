<?php

/** Controller for Reports
  * This sends out all data to the views that are used to
  * view the Reports
  **/

  class ReportCtrl extends Ctrl {
    protected $Auth;
    protected $User;
    public    $Errors;

    public function __construct($model, $controller, $action){
      parent::__construct($model, $controller, $action);
      $this->Errors = new Errors;
      $this->Auth = new Auth;

      $logged = false;
      if($this->Auth->isLoggedIn()){
        $this->User = $this->Auth->getProfile();
        $this->set('user', $this->User);
        $logged = true;
      }
      $this->set('logged', $logged);
    }

    /** Report List **/
    public function index($id = null){
      if(!$this->Auth->isLoggedIn()){
        $logged = false;
      }
      else {
        $logged = true;
        $this->set('logged', $logged);




      }


    }

    /** View Report - public **/
    public function view($id){

      $this->set('title', 'Report');
      $Errors = new Errors();
      $User = new User();

      $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

      $this->set('street_map', true);
      $this->set('js', array('section/report.js'));

      $Report = $this->Report->getReport($id);

      if(!$Report){
          header('Location: /report/not_found');
      } else if($Report->status != 7){
        header('Location: /report/unpublished');
      }
      else {
          $this->set('report', $Report);

          $oc = json_decode($Report->api_data);
          $this->set('oc', $oc);

          $Author = $User->fullProfile(($Report->created_by));
          $this->set('author', $Author);

          $Soggetti = array();
          foreach ($oc->soggetti as $soggetto) {
              foreach ($soggetto->ruoli as $ruolo) {
                  $Soggetti[$ruolo][] = $soggetto;
              }
          }
          $this->set('soggetti', $Soggetti);

          $Efficacia = array();
          $Efficacia['Realizzazione ha mostrato problemi di natura amministrativa'] = $Report->problemi_amministrativi;
          $Efficacia['Realizzazione ha mostrato problemi di natura tecnica'] = $Report->problemi_tecnici;
          $Efficacia['Il risultato del progetto non è soddisfacente'] = $Report->risultato_insoddisfacente;
          $Efficacia['Intervento complessivamente ben realizzato ma non rispondente ai bisogni degli utenti finali (non efficace)'] = $Report->non_efficace;
          $Efficacia['Intervento utile ma non sufficiente per rispondere al fabbisogno (“ne serve di più”, es. più investimenti nello stesso progetto o in progetti simili)'] = $Report->non_sufficiente;
          $Efficacia['Intervento di per sè utile ma sono necessari altri interventi complementari'] = $Report->necessita_interventi_extra;
          $this->set('efficacia', $Efficacia);

          $Valutazione = '';
          switch ($Report->valutazione_risultati) {
              case 1:
                  $Valutazione = "Intervento dannoso - Era meglio non farlo perché ha provocato conseguenze negative";
                  break;
              case 2:
                  $Valutazione = "Intervento inutile - Non ha cambiato la situazione, soldi sprecati";
                  break;
              case 3:
                  $Valutazione = "Intervento utile ma presenta problemi - Ha avuto alcuni risultati positivi ed è tutto sommato utile, anche se presenta anche aspetti negativi";
                  break;
              case 4:
                  $Valutazione = "Intervento molto utile ed efficace - Gli aspetti positivi prevalgono ed è giudicato complessivamente efficace dal punto di vista dell'utente finale";
                  break;
              case 5:
                  $Valutazione = "Non è stato possibile valutare l’efficacia dell’intervento - Es. il progetto non ha ancora prodotto risultati valutabili";
                  break;
          }
          $this->set('valutazione', $Valutazione);

          $Raccolta = array();
          $Raccolta["Raccolta di informazioni via web"] = $Report->raccolta_info_web;
          $Raccolta["Visita diretta documentata da foto e video"] = $Report->visita_diretta;
          $Raccolta["Intervista con l'Autorità di Gestione del Programma"] = $Report->intervista_autorita_gestione;
          $Raccolta["Intervista con i soggetti che hanno programmato l'intervento (soggetto programmatore)"] = $Report->intervista_soggetto_programmatore;
          $Raccolta["Intervista con gli utenti/beneficiari dell'intervento"] = $Report->intervista_utenti_beneficiari;
          $Raccolta["Intervista con altre tipologie di persone"] = $Report->intervista_altri_utenti;
          $Raccolta["Intervista con i soggetti che hanno o stanno attuando l'intervento (attuatore o realizzatore)"] = $Report->raccolta_info_attuatore;
          $Raccolta["Intervista con i referenti politici"] = $Report->referenti_politici;
          $Raccolta = array_filter($Raccolta);
          $this->set('raccolta', $Raccolta);

          $Images = array();
          $Resources = array();
          if (!empty($Report->files)) {
              foreach ($Report->files as $file) {
                  $info = explode('/', $file->info);
                  if ($info[0] == 'image') {
                      $Images[] = $file;
                  } else {
                      $Resources[] = $file;
                  }
              }
          }
          $this->set('images', $Images);
          $this->set('resources', $Resources);
      }
    }

    /** New Report **/
    public function create(){

      if(!$this->Auth->isLoggedIn()){
        header('Location: /user/login?r=1');
      }
      else {

        $logged = true;
        $this->set('logged', $logged);

        $this->set('title', 'Nuovo Report');
        $Errors = new Errors();
        $this->set('street_map', true);
        $this->set('js', array('components/oc_api.js', 'components/leaflet_location_map.js'));

        /** STATUS VAR -
          * Used to check if report has been saved - in which case,
          * redirect user to edit form od said report
          * transferring updated Error class messages
        **/
        $status = 0;
        $data = null;

        if( httpCheck('post', true) ){
          $data = $_POST;

          $videos = $data['video-attachment'];
          $links = $data['link-attachment'];
          unset($data['video-attachment']);
          unset($data['link-attachment']);

          $data = array_filter($data);
          $data = recursiveStripTags($data);

          $data['created_by'] = $this->User->id;
          $report = $this->Report->create($data);

          if(is_numeric($report)){
            $status = 1;

            // $this->Errors->set(21);

            $_SESSION[APPNAME]['message-log'][] = 21;

            // Upload Files
            if(!empty($_FILES)){

              $files = rearrange_files($_FILES['file-attachment']);
              $Files = new Meta('file_repository');
              $File = new Repo();

              $fileInfo = array('title' => 'Report File - ' . $report, 'file_type' => 2, 'disclosure' => 100, 'uid' => $this->User->id);
              $filelist = array();

              foreach($files as $i => $file){
                if($file['error'] == 0 ){
                  $filelist[] = $File->upload($file, $fileInfo);
                }
                elseif($file['error'] == 4 ) {

                }
                else {
                  $_SESSION[APPNAME]['message-log'][] = 650;
                  $this->Errors->set(650);
                }
              }

              if(count($filelist) > 0) {
                $f = $Files->updateFileReferences(T_REP_BASIC, $report, $filelist);
              }
              if(!$f instanceof Errors && count($filelist) > 0){
                $_SESSION[APPNAME]['message-log'][] = 91;
                $this->Errors->set(91);
              }
            }

            // Upload Links
            if(!empty($links)){
              $links = array_filter($links);
              $Links = new Meta('link_repository');
              $Link = new Link();
              $linkList = array();
              foreach($links as $link){
                $link_id = $Link->create(array('URL' => $link));
                $linkList[] = $link_id;
              }
              $f = $Links->updateReferences(T_REP_BASIC, $report, $linkList);
              if(!$f instanceof Errors){
                $_SESSION[APPNAME]['message-log'][] = 92;
                $this->Errors->set(92);
              }
            }

            // Upload Video Links
            if(!empty($videos)){
              $videos = array_filter($videos);
              $Videos = new Meta('video_repository');
              $Video  = new Video();
              $videoList = array();
              foreach($videos as $video){
                $video_id = $Video->create(array('URL' => $video));
                $videoList[] = $video_id;
              }
              $f = $Videos->updateReferences(T_REP_BASIC, $report, $videoList);
              if(!$f instanceof Errors){
                $_SESSION[APPNAME]['message-log'][] = 93;
                $this->Errors->set(93);
              }
            }
          }
          else {
            $this->Errors->set(551);
          }
        }

        if($status == 1){
          header('Location: /report/edit/' . $report . '?saved=success');
        }

        $this->set('data', $data);
        $this->set('errors', $this->Errors);
      }
    }

    /** Edit Report **/
    public function edit($id){

      if(!$this->Auth->isLoggedIn()){
        header('Location: /user/login?r=1');
      }
      else {

        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        // Load Report
        $r = $this->Report->find($id);

        // Check for ownership or permissions
        if( hasPermission($this->User, array(P_EDIT_REPORT, P_ASSIGN_REPORT, P_BOUNCE_REPORT, P_COMMENT_REPORT, P_MANAGE_REPORT_CARD)) || $this->User->id == $r->created_by){


          $logged = true;
          $this->set('logged', $logged);

          $this->set('title', 'Modifica Report');
          $Comments = new Comment();

          $this->set('street_map', true);
          $this->set('js', array('components/oc_api.js', 'components/leaflet_location_map.js'));

          $this->Errors->check();
          if(!empty($this->Errors->errors)){
            $this->set('errors', $this->Errors);
          }

          if( httpCheck('post', true) ){
            $data = $_POST;
            // $this->set('data', $data);
            $data = recursiveStripTags($data);

            $videos = $data['video-attachment'];
            $links = $data['link-attachment'];
            unset($data['video-attachment']);
            unset($data['link-attachment']);
            unset($data['id']);
            $update = $this->Report->update($id, $data);
            if($update) {
              $record = $id;
              $this->Errors->set(21);
            }
            if(!empty($_FILES)){
              $files = rearrange_files($_FILES['file-attachment']);
              $Files = new Meta('file_repository');
              $File = new Repo();

              $fileInfo = array('title' => 'Report File - ' . $record, 'file_type' => 2, 'disclosure' => 100, 'uid' => $this->User->id);
              $filelist = array();

              foreach($files as $i => $file){
                if($file['error'] == 0){
                  $filelist[] = $File->upload($file, $fileInfo);
                }
                else {
                    if(!empty($file['tmp_name'])){
                    $this->Errors->set(650);
                    }
                }
              }

              if(count($filelist) > 0) {
                $f = $Files->updateFileReferences(T_REP_BASIC, $record, $filelist);
                if(!$f instanceof Errors){
                  $this->Errors->set(91);
                }
              }

            }
            // Upload Links
            if(!empty($links)){
              $links = array_filter($links);
              $Links = new Meta('link_repository');
              $Link = new Link();
              $linkList = array();
              foreach($links as $link){
                $link_id = $Link->create(array('URL' => $link));
                $linkList[] = $link_id;
              }
              $f = $Links->updateLinkReferences(T_REP_BASIC, $record, $linkList);
              if(!$f instanceof Errors){
                $this->Errors->set(92);
              }
            }

            // Upload Video Links
            if(!empty($videos)){
              $videos = array_filter($videos);
              $Videos = new Meta('video_repository');
              $Video  = new Video();
              $videoList = array();
              foreach($videos as $video){
                $video_id = $Video->create(array('URL' => $video));
                $videoList[] = $video_id;
              }
              $f = $Videos->updateVideoReferences(T_REP_BASIC, $record, $videoList);
              if(!$f instanceof Errors){
                $this->Errors->set(93);
              }
            }
            $this->set('errors', $this->Errors);
          }



          // Load Report
          $report = $this->Report->find($id);

          // Load Comments
          $this->set('comments', $Comments->findBy(array('entity' => T_REP_BASIC, 'record' => $id)));

          // Get Files
          $Files = new Repo();
          $report->files = $Files->getFiles(T_REP_BASIC, $id, 2);
          foreach($report->files as $i => $file){
            $report->files[$i]->info = $Files->getInfo(ROOT.DS.'public'.DS.'resources'.DS.$file->file_path);
          }

          // Get Links
          $LoadLinks = new Meta('link_repository');
          $LoadLink = new Link();
          $report->links = $LoadLinks->getRepoReference('link_repository', T_REP_BASIC, $id);

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
                else if(strpos($v->URL, 'youtu.be')){
                    $v_pieces = explode('/', $v->URL);
                    $v_id = array_pop($v_pieces);
                    $Vids[$i]->embed = 'https://www.youtube.com/embed/' . $v_id;
                }
                else if(strpos($v->URL, 'vimeo')){
                    $v_pieces = explode('/', $v->URL);
                    $v_id = array_pop($v_pieces);
                    $Vids[$i]->embed = 'https://player.vimeo.com/video/' . $v_id;
                }
                else {
                    $Vids[$i]->embed = $v->URL;
                }
            }
          $report->videos = $Vids;



          $this->set('data', $report);

        } else {
          header('Location: /user/forbidden');
        }
      }
    }

    /** Review Reports
      * Edit fields, add comments
      * Save to draft/published
      * Save who the reviewing user is
      * Send email update to involved users
    **/
    public function review($id){
      // Login check
      if(!$this->Auth->isLoggedIn()){
        header('Location: /user/login?r=1');
      }
      else {
        // Check for ownership or permissions
        if( hasPermission($this->User, array(P_EDIT_REPORT, P_ASSIGN_REPORT, P_BOUNCE_REPORT, P_COMMENT_REPORT, P_MANAGE_REPORT_CARD)) || $this->User->id != $r->created_by){
          $Comments = new Comment();
          $logged = true;
          $this->set('logged', $logged);
          $this->set('title', 'Revisione Report');
          $this->set('street_map', true);
          $this->set('js', array('components/oc_api.js', 'components/leaflet_location_map.js', 'section/review.js'));

          $this->Errors->check();
          if(!empty($this->Errors->errors)){
            $this->set('errors', $this->Errors);
          }

          // If we have post data, set up comments and change content
          if( httpCheck('post', true) ){

              // Get Reviewer ID to update Report Entry
              $reviewer_id = $this->User->id;

              // Sanitize data
              $data = $_POST;
              $data = recursiveStripTags($data);
              $data['reviewed_by'] = $reviewer_id;

              $creator = $data['created_by'];
              $prev_status = $data['current_status'];
              unset($data['current_status']);
              unset($data['created_by']);

              $videos = $data['video-attachment'];
              $links = $data['link-attachment'];
              unset($data['video-attachment']);
              unset($data['link-attachment']);
              unset($data['id']);

              if(isset($data['comment'])){
                  $comments = $data['comment'];
                  unset($data['comment']);
              }

            // Save Report
              $update = $this->Report->update($id, $data);
              if($update) {
                  $record = $id;
                  $this->Errors->set(21);
              }
            // Save Comments
            if(!empty($comments)){
                foreach($comments as $field => $comment){
                    $saved = $Comments->save($comment, $field, T_REP_BASIC, $id, $this->User->id);
                }
            }
            // Check status change
            if($prev_status != $data['status']){
                //status has changed, check how and set up email for users
                $Reporter = new User();
                $reporter = $Reporter->fullProfile($creator);

                if($data['status'] == PUBLISHED){
                    $mailer = true;
                    $subject = "MONITHON - Report Approvato";
                    $message = "Il Report <strong>" . $data['titolo'] . "</strong> è stato approvato, puoi vederlo online. Grazie per aver partecipato al progetto di monitoraggio civico. <br /> " .
                                "Il Report è consultabile alla URL <a href=\"" . APPURL . "/report/view/" . $id . "\">" . APPURL . "/report/view/" . $id . "</a>" .
                                "<br /><br /> - La redazione di Monithon";
                }
                else if($data['status'] == DRAFT){
                    $mailer = true;
                    $subject = "MONITHON - Richiesta modifiche al report!";
                    $message = "Durante la revisione da parte della Redazione di Monithon sono emersi alcuni particolari che necessitano il tuo intervento sul report <strong>" . $data['titolo'] . "</strong>!<br />" .
                               "La Redazione di Monithon ha lasciato dei commenti chiarificatori sulla piattaforma, ti basterà accedervi e modificare il report per leggerli ed intervenire dove opportuno! <br />" .
                               "<br /><br /> - La redazione di Monithon";
                }
                if($mailer){
                    // Send Email
                    // To send HTML mail, the Content-type header must be set
                    $headers[] = 'MIME-Version: 1.0';
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

                    // Additional headers
                    $headers[] = 'From: ' . APPEMAIL;
                    $send = mail($reporter->email, $subject, $message, implode("\r\n", $headers));
                    if($send){
                        $this->Errors->set(5);
                    }
                    else {
                        $this->Errors->set(300);
                    }
                }
            }


          }


          // Load Report
          $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
          $report = $this->Report->find($id);
          // Load Comments
          $this->set('comments', $Comments->findBy(array('entity' => T_REP_BASIC, 'record' => $id)));
          // Load Attachments
          // Get Files
          $Files = new Repo();
          $report->files = $Files->getFiles(T_REP_BASIC, $id, 2);
          foreach($report->files as $i => $file){
            $report->files[$i]->info = $Files->getInfo(ROOT.DS.'public'.DS.'resources'.DS.$file->file_path);
          }

          // Get Links
          $LoadLinks = new Meta('link_repository');
          $report->links = $LoadLinks->getRepoReference('link_repository', T_REP_BASIC, $id);

          // Get Videos
          $LoadVideos = new Meta('video_repository');
          $Vids = $LoadVideos->getRepoReference('video_repository', T_REP_BASIC, $id);
          foreach($Vids as $i => $v){
            if(strpos($v->URL, 'youtube')){
                $v_pieces = explode('?v=', $v->URL);
                $v_id = array_pop($v_pieces);
                $Vids[$i]->embed = 'https://www.youtube.com/embed/' . $v_id;
            }
            else if(strpos($v->URL, 'youtu.be')){
                $v_pieces = explode('/', $v->URL);
                $v_id = array_pop($v_pieces);
                $Vids[$i]->embed = 'https://www.youtube.com/embed/' . $v_id;
            }
            else if(strpos($v->URL, 'vimeo')){
                $v_pieces = explode('/', $v->URL);
                $v_id = array_pop($v_pieces);
                $Vids[$i]->embed = 'https://player.vimeo.com/video/' . $v_id;
            }
            else {
                $Vids[$i]->embed = $v->URL;
            }
          }
          $report->videos = $Vids;
          // Send to template
          $this->set('data', $report);
        }
      }
    }

    /** Routing managers */
      public function unpublished(){
          $this->set('title', 'Report non Pubblicato');
      }
      public function not_found(){
          $this->set('title', 'Report Inesistente');
      }

    /** Delete **/
    public function delete($id){ }
  }
