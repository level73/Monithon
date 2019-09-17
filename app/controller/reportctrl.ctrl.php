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
        $logged = true;
      }
      $this->set('logged', $logged);
    }

    /** Report List **/
    public function index(){
    }

    /** View Report - public **/
    public function view($id){ }

    /** New Report **/
    public function create(){
      $this->set('title', 'Nuovo Report');
      $Errors = new Errors();
      $this->set('js', array('components/oc_api.js'));
    }

    /** Edit Report **/
    public function edit($id){ }

    /** Delete **/
    public function delete($id){ }
  }
