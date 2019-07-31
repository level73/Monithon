<?php

    /** Calls User
     * Handles the login and logout functionalities
     * as well as user creation, update (deactivation)
     * also password recovery /reset
     */

    class UserCtrl extends Ctrl {

        protected $Auth;
        protected $User;


        public function login(){
            $this->set('title', 'Login');
            $Errors = new Errors();

            if( httpCheck('post', true) ){
                // Check for errors
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    $Errors->set(601);
                }
                if(empty($_POST['pwd'])){
                    $Errors->set(602);
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
                                header('Location: /main');
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
          $Errors = new Errors();
        }

        public function update($id){

        }

        public function recover(){ }

        public function reset(){ }

        /** Error page **/
        public function ops(){

        }



    }
