<?php
  /**
   * Authorizes URL and checks for users being Logged In
   * Validates and authorizes user sessions
   * 0cchi0Vigil3Cumpà
   * */

  class Auth extends Session {

      public $url;

      protected $authorized = false;
      protected $openroutes = array(
                              'user/login',
                              );

      public function checkRoute($url){
        $this->url = $url;
        if(in_array($url, $this->openroutes)){
          $this->authorized = true;
          return true;
        }
        elseif($this->isLoggedIn()){
          $this->authorized = true;
          return true;
        }
        else {
          $this->authorized = false;
          return false;
        }
      }


      public function isLoggedIn(){
        if($this->getSession() !== false){
          $this->authorized = true;
          return true;
        }
        else {
          $this->authorized = false;
          return false;
        }
      }


      public function authorize($user){
        $Session = new Session;
        $token = $this->token();
        $sessionset = $Session->setSession($user, $token);

        if($sessionset){
          $this->authorized = true;
        }

        return $sessionset;
      }

      private function token(){
        $salt = '$1$' . md5(substr(time(), -8))  . SESSIONSALT;
        $token = md5(APPKEY . substr(time(), -8));
        return crypt($token, $salt);
      }

      public function getProfile(){
        $session = $this->getSession();
        // add permission loading
        return $session;
      }

      

  }
