<?php

/** Controller for Reports
  * This sends out all data tot he views that are used to
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
        $logged = true;
      }
      $this->set('logged', $logged);
    }

    /** Report List **/
    public function index(){
      if(!$this->Auth->isLoggedIn()){
        $logged = false;
      }
      else {
        $logged = true;
        $this->set('logged', $logged);
      }

      $this->set('title', 'Lista dei Report');
      $Errors = new Errors();

    }

    /** View Report - public **/
    public function view($id){ }

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

        $data = null;
        if( httpCheck('post', true) ){
          $data = $_POST;
          // $this->set('data', $data);

          $videos = $data['video-attachment'];
          $links = $data['link-attachment'];
          unset($data['video-attachment']);
          unset($data['link-attachment']);

          $data = array_filter($data);

          $data['created_by'] = $this->User->id;
          $report = $this->Report->create($data);

          if(is_numeric($report)){
            $this->Errors->set(21);

            // Upload Files
            if(!empty($_FILES)){
              $files = rearrange_files($_FILES['file-attachment']);

              $Files = new Meta('file_repository');
              $File = new Repo();

              $fileInfo = array('title' => 'Report File - ' . $report, 'file_type' => 2, 'disclosure' => 100, 'uid' => $this->User->id);
              $fileList = array();

              foreach($files as $i => $file){
                if($file['error'] == 0){
                  $filelist[] = $File->upload($file, $fileInfo);
                }
                else {
                  $this->Errors->set(650);
                }
              }

              if(count($fileList > 0)) { $Files->updateFileReferences(T_REP_BASIC, $report, $filelist); }
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
              $Links->updateReferences(T_REP_BASIC, $report, $linkList);
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
              $Videos->updateReferences(T_REP_BASIC, $report, $videoList);
            }
          }
          else {
            $this->Errors->set(551);
          }


        }
        $this->set('data', $data);
      }
    }

    /** Edit Report **/
    public function edit($id){ }

    /** Delete **/
    public function delete($id){ }
  }
