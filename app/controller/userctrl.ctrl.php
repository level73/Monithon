<?php

    /** Calls User
     * Handles the login and logout functionalities
     * as well as user creation, update (deactivation)
     * also password recovery /reset
     */

    class UserCtrl extends Ctrl {

        protected $Auth;
        protected $User;
        protected $logged = false;

        public function login(){
            $this->set('title', 'Login');
            $Errors = new Errors();

            if(isset($_GET['r']) && !empty($_GET['r']) && is_numeric($_GET['r'])){
              $r = filter_var($_GET['r'], FILTER_SANITIZE_NUMBER_INT);
              $this->set('referrer', $r);
            }

            if( httpCheck('post', true) ){
                // Check for errors
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    $Errors->set(601);
                }
                if(empty($_POST['pwd'])){
                    $Errors->set(602);
                }

                global $routes;
                if(isset($_POST['r']) && !empty($_POST['r']) && is_numeric($_POST['r'])) {
                  $r = filter_var($_POST['r'], FILTER_SANITIZE_NUMBER_INT);
                  $referrer = $routes[$r];
                }
                else {
                  $referrer = $routes[0];
                }

                // If we have no registered errors, we can proceed to logging in
                if(empty($Errors->errors)){

                    $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                    $password = filter_var($_POST['pwd'], FILTER_SANITIZE_STRING);

                    $user = $this->User->findBy(array('email' => $email, 'active' => 2));

                    if($user){
                        if(password_verify($password, $user[0]->password)){
                          $Auth = new Auth;
                          $Auth->authorize($user[0]->idauth);
                          $User = $Auth->getProfile();

                          if($User && $Auth->isLoggedIn()){
                            header('Location: ' . $referrer);
                          }
                        }
                        else {
                          /** password didn't check out **/
                          $Errors->set(606);
                        }
                    } else {
                        /** No user with that email **/
                        $Errors->set(607);
                    }
                }
                $this->set('errors', $Errors);
            }
        }


        public function logout(){
            unset($_SESSION[APPNAME][SESSIONKEY]);
            session_destroy();
            header('Location: /main');
        }

        public function create(){
            $this->Auth = new Auth();
            $Errors = new Errors();

            if(!$this->Auth->isLoggedIn()){
                header('Location: /user/login');
            }
            else {

                $this->logged = true;
                $this->set('logged', $this->logged);
                $this->User = $this->Auth->getProfile();
                $this->set('user', $this->User);
                $this->set('title', 'Nuovo Utente');

                if(!(in_array(P_CREATE_USER, array_keys($this->User->permissions)))){
                    header('Location: /user/ops');
                }
                else {
                  // Check for data in the post
                  if( httpCheck('post', true) ){
                    $data = array();

                    $data['email'] = 'code@level73.it';
                    $data['password'] = password_hash('secret', PASSWORD_BCRYPT);
                    $data['username'] = 'lvl73';
                    $data['role'] = 1;
                    $data['active'] = 2;
                    $data['modified_by'] = 1;



                  // Create USER

                  // Create SESSION

                  }
                }

            }
        }

        public function register(){
          $this->set('title', 'Registrati');
          $this->set('js', array('section/user.js'));
          $Errors = new Errors();
        }

        public function edit(){

          $this->Auth = new Auth();
          $Avatar     = new Repo();
          $File       = new Meta('file_repository');
          $Errors     = new Errors();
          $Report    = new Report();

          if(!$this->Auth->isLoggedIn()){
            header('Location: /user/login');
          }
          else {
            $this->logged = true;
            $this->set('logged', $this->logged);

            $this->user = $this->Auth->getProfile();
            $this->set('user', $this->user);
            $this->set('title', 'Modifica il tuo Profilo');

            // Check for data in the post
            if( httpCheck('post', true) ){
              // clean up things
              $data   = $_POST;
              $id     = $data['id'];

              unset($data['id']);
              unset($data['email']);
              unset($data['username']);

              // get file out

              // Update profile
              $u = $this->User->update($id, $data);
              if($u) {
                $Errors->set(2);
              }
              else {
                $Errors->set(502);
              }


              if($_FILES['avatar']['error'] == 0) {
                $upload = $Avatar->upload($_FILES['avatar'], array('title' => 'User Avatar - ' . $this->user->username, 'file_type' => 1, 'disclosure' => 100, 'uid' => $id));
                if(!$upload){
                  $Errors->set(650);
                }
                else {
                  $Errors->set(91);
                  $filelist = array($upload);
                }
              }
              $File->updateFileReferences(T_USER, $id, $filelist);
            }

            $Profile = $this->User->fullProfile($this->user->id);
            $Reports = $Report->findBy(array('created_by' => $this->user->id));
            $this->set('errors', $Errors);
            $this->set('Profile', $Profile);
            $this->set('reports', $Reports);


          }

        }

        public function update($id){


        }

        public function recover(){ }

        public function reset(){ }

        /** Error page **/
        public function ops(){

        }



    }
