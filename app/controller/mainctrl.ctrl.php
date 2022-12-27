<?php

  class MainCtrl extends Ctrl {

    public function index(){
      $this->set('title', 'Homepage');
      $Auth = new Auth();
/*
      $this->set('street_map', true);
      $this->set('js', array('components/leaflet_reports_map.js'));
*/
      $logged = false;
      if($Auth->isLoggedIn()){
        $logged = true;
        $this->set('user', $Auth->getProfile());
      }

      $this->set('logged', $logged);

      // Get latest 5 reports
        $Reports = new Report();
        $this->set('reports', $Reports->getReports(0, 4));

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
