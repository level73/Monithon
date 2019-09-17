<?php

  class MainCtrl extends Ctrl {

    public function index(){
      $this->set('title', 'Homepage');
      $Auth = new Auth();

      $logged = false;
      if($Auth->isLoggedIn()){
        $logged = true;
      }

      $this->set('logged', $logged);
      
    }

  }
