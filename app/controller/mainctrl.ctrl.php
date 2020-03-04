<?php

  class MainCtrl extends Ctrl {

    public function index(){
      $this->set('title', 'Homepage');
      $Auth = new Auth();

      $logged = false;
      if($Auth->isLoggedIn()){
        $logged = true;
        $this->set('user', $Auth->getProfile());
      }

      $this->set('logged', $logged);

    }

    public function privacy(){
      $this->set('title', 'Privacy Policy');
      $Auth = new Auth();
      $logged = false;
      if($Auth->isLoggedIn()){
        $logged = true;
        $this->set('user', $Auth->getProfile());
      }
      $this->set('logged', $logged);

    }


  }
