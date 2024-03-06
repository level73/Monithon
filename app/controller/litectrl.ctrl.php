<?php

class LiteCtrl extends Ctrl
{
    protected $Auth;
    protected $User;
    public    $Errors;

    public $pager = 25;

    //public $Lite;

    public function __construct($model, $controller, $action){
        parent::__construct($model, $controller, $action);
        $this->Errors = new Errors;
        $this->Auth = new Auth;

        //$this->Lite = new Lite;

        $logged = false;
        if($this->Auth->isLoggedIn()){
            $this->User = $this->Auth->getProfile();
            $this->set('user', $this->User);
            $logged = true;
        }
        $this->set('logged', $logged);
    }

    public function create(){

        if(isset($_GET['pfurl']) && !empty($_GET['pfurl'])){
            setcookie('pfurl', $_GET['pfurl'], strtotime('+1 day'), '/');
            $this->set('pfurl', $_GET['pfurl']);
            if(isset($_GET['ref']) && !empty($_GET['ref']) && $_GET['ref'] == 's24'){
                setcookie('ref', $_GET['ref'], strtotime('+1 day'), '/');
                $this->set('ref', $_GET['ref']);
            }
        }

        elseif(isset($_COOKIE['pfurl']) && !empty($_COOKIE['pfurl'])){
            $this->set('pfurl', $_COOKIE['pfurl']);
            if(isset($_COOKIE['ref']) && !empty($_COOKIE['ref'])){
                $this->set('ref', $_COOKIE['ref']);
            }
        }

        if(!$this->Auth->isLoggedIn()){
            header('Location: /user/login?r=1');
        }

        else {
            $logged = true;
            $this->set('logged', $logged);
            $this->set('title', 'Nuovo Report');
            $this->set('street_map', true);
            $Errors = new Errors();
            $this->set('js', array('components/lite_report.js?v=0.2', 'components/leaflet_location_map.js'));

            /** STATUS VAR -
             * Used to check if report has been saved - in which case,
             * redirect user to edit form of said report
             * transferring updated Error class messages
             **/
            $status = 0;
            $data = null;

            if( httpCheck('post', true) ){
                $data = $_POST;
                if(isset($_COOKIE['ref'])){
                    $data['referrer'] = $_COOKIE['ref'];
                }

                $videos = $data['video-attachment'];
                $links = $data['link-attachment'];
                unset($data['video-attachment']);
                unset($data['link-attachment']);

                /** Check for OC API URL and Data **/
                if(!empty($data['project_url']) && empty($data['api_data'])){

                    $code_url = explode('/', rtrim($data['project_url']));
                    dbga($code_url);
                    $code = end($code_url);

                    $auth = base64_encode(OC_API_USERNAME . ":" . OC_API_PASSWORD);
                    $context = stream_context_create([
                        "http" => [
                            "header" => "Authorization: Basic $auth"
                        ]
                    ]);

                    $oc_api_data = @file_get_contents('https://opencoesione.gov.it/it/api/progetti/' . $code . '/?format=json', false, $context);
                    if(!$oc_api_data){
                        $r['message'] = 'Non trovato';
                        $r['code'] = '404';
                        //    $data = json_encode($r);
                    }
                    else {
                        $data['api_data'] = $oc_api_data;
                    }
                }

                $data = array_filter($data);
                $data = recursiveStripTags($data);

                if(!empty($data['api_data'])){
                    $json = json_decode($data['api_data']);
                    $oc_project_code = $json->cod_locale_progetto;
                    $data['project_code'] = $oc_project_code;
                }
                $data['status'] = DRAFT;
                $data['created_by'] = $this->User->id;
                $report = $this->Lite->create($data);

                if(is_numeric($report)){
                    $status = 1;
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
                            $f = $Files->updateFileReferences(T_REP_LITE, $report, $filelist);
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
                        $f = $Links->updateReferences(T_REP_LITE, $report, $linkList);
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
                        $f = $Videos->updateReferences(T_REP_LITE, $report, $videoList);
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
                header('Location: /lite/edit/' . $report . '?saved=success');
            }

            /** Connection Type Lexicon **/
            $ConnectionType = new Meta('connection_type', true);
            $this->set('connection_type', $ConnectionType->lexiconList);
            $this->set('data', $data);
            $this->set('errors', $this->Errors);
        }

        $this->set('data', $data);
    }


    public function edit($id)
    {
        if (!$this->Auth->isLoggedIn()) {
            header('Location: /user/login?r=1');
        } else {

            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            // Load Report
            $r = $this->Lite->find($id);

            // Check for ownership or permissions
            if (hasPermission($this->User, array(P_EDIT_REPORT, P_ASSIGN_REPORT, P_BOUNCE_REPORT, P_COMMENT_REPORT, P_MANAGE_REPORT_CARD)) || $this->User->id == $r->created_by) {

                $logged = true;
                $this->set('logged', $logged);

                $this->set('title', 'Modifica Report');
                $Comments = new Comment();

                $this->set('street_map', true);
                $this->set('js', array('components/lite_report.js?v=0.2', 'components/leaflet_location_map.js'));

                $this->Errors->check();
                if (!empty($this->Errors->errors)) {
                    $this->set('errors', $this->Errors);
                }

                if (httpCheck('post', true)) {
                    $data = $_POST;
                    // $this->set('data', $data);
                    $data = recursiveStripTags($data);

                    $code_url = explode('/', rtrim($data['project_url']));
                    $code = end($code_url);
                    // force call to rest api if api_data is empty
                    if (empty($data['api_data']) && !empty($data['project_url'])) {
                        $auth = base64_encode(OC_API_USERNAME . ":" . OC_API_PASSWORD);
                        $context = stream_context_create([
                            "http" => [
                                "header" => "Authorization: Basic $auth"
                            ]
                        ]);

                        $response = @file_get_contents('https://opencoesione.gov.it/it/api/progetti/' . $code . '/?format=json', false, $context);
                        if (!$response) {
                            $r['message'] = 'Non trovato';
                            $r['code'] = '404';
                            $response = json_encode($r);
                        }
                    }

                    if (!empty($data['api_data'])) {
                        $json = json_decode($data['api_data']);
                        $oc_project_code = $json->cod_locale_progetto;
                        $data['project_code'] = $oc_project_code;
                    }

                    $videos = $data['video-attachment'];
                    $links = $data['link-attachment'];
                    unset($data['video-attachment']);
                    unset($data['link-attachment']);
                    unset($data['id']);
                    $update = $this->Lite->update($id, $data);

                    if ($update) {
                        $record = $id;
                        $this->Errors->set(21);
                    }
                    if (!empty($_FILES)) {
                        $files = rearrange_files($_FILES['file-attachment']);
                        $Files = new Meta('file_repository');
                        $File = new Repo();

                        $fileInfo = array('title' => 'Report File - ' . $record, 'file_type' => 2, 'disclosure' => 100, 'uid' => $this->User->id);
                        $filelist = array();

                        foreach ($files as $i => $file) {
                            if ($file['error'] == 0) {
                                $filelist[] = $File->upload($file, $fileInfo);
                            } else {
                                if (!empty($file['tmp_name'])) {
                                    $this->Errors->set(650);
                                }
                            }
                        }

                        if (count($filelist) > 0) {
                            $f = $Files->updateFileReferences(T_REP_LITE, $record, $filelist);
                            if (!$f instanceof Errors) {
                                $this->Errors->set(91);
                            }
                        }

                    }
                    // Upload Links
                    if (!empty($links)) {
                        $links = array_filter($links);
                        $Links = new Meta('link_repository');
                        $Link = new Link();
                        $linkList = array();
                        foreach ($links as $link) {
                            $link_id = $Link->create(array('URL' => $link));
                            $linkList[] = $link_id;
                        }
                        $f = $Links->updateLinkReferences(T_REP_LITE, $record, $linkList);
                        if (!$f instanceof Errors) {
                            $this->Errors->set(92);
                        }
                    }

                    // Upload Video Links
                    if (!empty($videos)) {
                        $videos = array_filter($videos);
                        $Videos = new Meta('video_repository');
                        $Video = new Video();
                        $videoList = array();
                        foreach ($videos as $video) {
                            $video_id = $Video->create(array('URL' => $video));
                            $videoList[] = $video_id;
                        }
                        $f = $Videos->updateVideoReferences(T_REP_LITE, $record, $videoList);
                        if (!$f instanceof Errors) {
                            $this->Errors->set(93);
                        }
                    }
                    $this->set('errors', $this->Errors);
                }


                // Load Report
                $report = $this->Lite->find($id);

                // Load Comments
                $this->set('comments', $Comments->findBy(array('entity' => T_REP_LITE, 'record' => $id)));

                // Get Files
                $Files = new Repo();
                $report->files = $Files->getFiles(T_REP_LITE, $id, 2);
                foreach ($report->files as $i => $file) {
                    $report->files[$i]->info = $Files->getInfo(ROOT . DS . 'public' . DS . 'resources' . DS . $file->file_path);
                }

                // Get Links
                $LoadLinks = new Meta('link_repository');
                $LoadLink = new Link();
                $report->links = $LoadLinks->getRepoReference('link_repository', T_REP_LITE, $id);

                // Get Videos
                $LoadVideos = new Meta('video_repository');
                $LoadVideo = new Video();
                $Vids = $LoadVideos->getRepoReference('video_repository', T_REP_LITE, $id);
                foreach ($Vids as $i => $v) {
                    if (strpos($v->URL, 'youtube')) {
                        $v_pieces = explode('?v=', $v->URL);
                        $v_id = array_pop($v_pieces);
                        $Vids[$i]->embed = 'https://www.youtube.com/embed/' . $v_id;
                    } else if (strpos($v->URL, 'youtu.be')) {
                        $v_pieces = explode('/', $v->URL);
                        $v_id = array_pop($v_pieces);
                        $Vids[$i]->embed = 'https://www.youtube.com/embed/' . $v_id;
                    } else if (strpos($v->URL, 'vimeo')) {
                        $v_pieces = explode('/', $v->URL);
                        $v_id = array_pop($v_pieces);
                        $Vids[$i]->embed = 'https://player.vimeo.com/video/' . $v_id;
                    } else {
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

    public function review($id){
        if(!$this->Auth->isLoggedIn()){
            header('Location: /user/login?r=1');
        }
        else {
            // Check for ownership or permissions
            if (hasPermission($this->User, array(P_EDIT_REPORT, P_ASSIGN_REPORT, P_BOUNCE_REPORT, P_COMMENT_REPORT, P_MANAGE_REPORT_CARD)) || $this->User->id != $r->created_by) {
                $Comments = new Comment();
                $logged = true;
                $this->set('logged', $logged);
                $this->set('title', 'Revisione Report');
                $this->set('street_map', true);
                $this->set('js', array('components/lite_report.js?v=0.2', 'components/leaflet_location_map.js', 'section/review.js'));

                $this->Errors->check();
                if (!empty($this->Errors->errors)) {
                    $this->set('errors', $this->Errors);
                }

                if( httpCheck('post', true) ) {

                    // Get Reviewer ID to update Report Entry
                    $reviewer_id = $this->User->id;

                    // Sanitize data
                    $data = $_POST;
                    $data = recursiveStripTags($data);
                    $data['reviewed_by'] = $reviewer_id;


                    $creator = $data['created_by'];
                    $prev_status = $data['current_status'];
//                    $prev_status_tab_3 = $data['current_status_tab_3'];
                    unset($data['current_status']);
  //                  unset($data['current_status_tab_3']);
                    unset($data['created_by']);

                    $videos = $data['video-attachment'];
                    $links = $data['link-attachment'];
                    unset($data['video-attachment']);
                    unset($data['link-attachment']);
                    unset($data['id']);

                    if (isset($data['comment'])) {
                        $comments = $data['comment'];
                        unset($data['comment']);
                    }

                    // Save Report
                    $update = $this->Lite->update($id, $data);
                    if($update) {
                        $record = $id;
                        $this->Errors->set(21);
                    }

                    // Save Comments
                    if(!empty($comments)){
                        foreach($comments as $field => $comment){
                            $saved = $Comments->save($comment, $field, T_REP_LITE, $id, $this->User->id);
                        }
                    }

                    if( ($prev_status != $data['status']) /*|| ($prev_status_tab_3 != $data['status_tab_3']) */){
                        //status has changed, check how and set up email for users
                        $Reporter = new User();
                        $reporter = $Reporter->fullProfile($creator);

                        if($data['status'] == PUBLISHED ){
                            $mailer = true;
                            $subject = "MONITHON - Report Approvato";

                            $message = "Il Report <strong>" . $data['titolo'] . "</strong> è stato approvato, congratulazioni!<br />Puoi vedere il report pubblicato al seguente link: <a href=\"" . APPURL . "/report/view/" . $id . "\">" . APPURL . "/report/view/" . $id . "</a><br />Controlla la pagina dedicata al tuo team e aggiorna bio e social se necessario: <a href=\"/profile/view/" . $creator . "\">Controlla il tuo profilo</a><br />Grazie per aver partecipato!<br /><br />La Redazione di Monithon";

                        }
                        else if($data['status_tab_3'] == PUBLISHED){
                            $mailer = true;
                            $subject = "MONITHON - Step 3 del Report Approvato";

                            $message = "Il terzo step del tuo report è stato approvato, congratulazioni!<br />
                                Pubblicheremo queste ulteriori informazioni in analisi aggregate o casi studio.<br /><br />                                
                                La redazione di Monithon";
                        }
                        else if($data['status'] == DRAFT || $data['status_tab_3'] == DRAFT){
                            $mailer = true;
                            $subject = "MONITHON - Richiesta modifiche al report!";
                            $message = "Durante la revisione da parte della Redazione di Monithon sono emersi alcuni particolari che necessitano il tuo intervento sul report <strong>" . $data['titolo'] . "</strong>!<br />" .
                                "La Redazione di Monithon ha lasciato dei commenti chiarificatori sulla piattaforma, ti basterà accedervi e modificare il report per leggerli ed intervenire dove opportuno! <br />";

                        }
                        if($mailer){
                            if($prev_status_tab_3 != $data['status_tab_3']){
                                $message .= 'In particolare, rivolgi l\'attenzione al terzo step, Impatto e Risultati.';
                            }
                            $message .= "<br /><br /> - La redazione di Monithon";
                            // Send Email
                            $Emailer = new Emailer();
                            $Emailer->compose($reporter->email, $subject, $message);
                            $send = $Emailer->deliver();

                            if($send){
                                $this->Errors->set(5);
                            }
                            else {
                                $this->Errors->set(300);
                            }
                        }
                    }

                /*** EOF HAS POST DATA **/
                }
                // Load Report
                $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
                $report = $this->Lite->find($id);

                // Load Connections


                // Load Comments
                $this->set('comments', $Comments->findBy(array('entity' => T_REP_LITE, 'record' => $id)));
                // Load Attachments
                // Get Files
                $Files = new Repo();
                $report->files = $Files->getFiles(T_REP_LITE, $id, 2);
                foreach($report->files as $i => $file){
                    $report->files[$i]->info = $Files->getInfo(ROOT.DS.'public'.DS.'resources'.DS.$file->file_path);
                }

                // Get Links
                $LoadLinks = new Meta('link_repository');
                $report->links = $LoadLinks->getRepoReference('link_repository', T_REP_LITE, $id);

                // Get Videos
                $LoadVideos = new Meta('video_repository');
                $Vids = $LoadVideos->getRepoReference('video_repository', T_REP_LITE, $id);
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

        /*** EOF LOGIN CHECK **/
        }
    }
}