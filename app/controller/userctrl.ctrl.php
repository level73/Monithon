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
                            header('Location: /user/edit');
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
            $UserModel = new User();

            if(!$this->Auth->isLoggedIn()){
                header('Location: /user/login');
            }
            else {
                $this->set('js', array('section/user.js'));
                $this->logged = true;
                $this->set('logged', $this->logged);
                $this->User = $this->Auth->getProfile();
                $this->set('user', $this->User);
                $this->set('title', 'Nuovo Utente');

                if(!(in_array(P_CREATE_USER, array_keys($this->User->permissions)))){
                    header('Location: /user/ops');
                }
                else {
                  $Region = new Meta('region', true);
                  $Provincia = new Meta('provincia', true);
                  $Roles = $UserModel->getRoles();

                  $this->set('regioni', $Region->lexiconList);
                  $this->set('province', $Provincia->listProvinceByRegion() );
                  $this->set('roles', $Roles);
                  $this->set('permissions', $UserModel->getPermissions());
                  // Check for data in the post
                  if( httpCheck('post', true) ){
                    $data = array();

                    $data = filter_var_array($_POST);
                    if(!empty($data['email'])){
                      if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                        $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
                      } else {
                        $Errors->set(601);
                      }
                    }
                    else {
                      $Errors->set(600);
                    }

                    if(!empty($data['pwd'])) {
                      if($data['pwd'] != $data['c_pwd']){
                        $Errors->set(609);
                      }
                    } else {
                      $Errors->set(602);
                    }

                    // $Usr = new User;
                    $email_check = $UserModel->findBy( array('email' => $data['email']) );
                    if(count($email_check) > 0){
                      $Errors->set(610);
                    }


                    if(empty($Errors->errors)){
                      /** encrypts password **/
                      $userdata['password']         = password_hash($data['pwd'], PASSWORD_BCRYPT);
                      $userdata['email']            = $data['email'];
                      $userdata['secondary_email']  = filter_var($data['secondary_email'], FILTER_SANITIZE_EMAIL);
                      $userdata['username']         = filter_var($data['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                      $userdata['role']             = filter_var($data['role'], FILTER_SANITIZE_NUMBER_INT);
                      $userdata['active']           = 2;

                      $permissions = filter_var_array($data['permissions'], FILTER_SANITIZE_NUMBER_INT);

                      unset($data['pwd']);
                      unset($data['c_pwd']);

                      $idUser = $UserModel->create($userdata);
                      if($idUser){
                        $RegSession = new Session;
                        $RegSession->createSession($idUser);

                        // set Permissions
                        if(!empty($permissions)){
                          $RegSession->setPermissions($idUser, $permissions);
                        }
                        $Errors->set(1);

                        // Set other data, as in ASOC profiles
                        if($userdata['role'] > 3){
                          $region = null;
                          if(!empty($data['provincia'])){
                            $p = $Provincia->findLexiconEntry('idprovincia', $data['provincia']);
                            if($p){
                              $region = $p->region;
                            }
                          }


                          $asoc['remote_id']      = filter_var($data['remote_id'], FILTER_SANITIZE_NUMBER_INT);
                          $asoc['auth']           = $idUser;
                          $asoc['istituto']       = filter_var($data['istituto'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                          $asoc['tipo_istituto']  = filter_var($data['tipo_istituto'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                          $asoc['regione']        = $region;
                          $asoc['provincia']      = filter_var($data['provincia'], FILTER_SANITIZE_NUMBER_INT);
                          $asoc['comune']         = filter_var($data['comune'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                          $asoc['link_blog']      = filter_var($data['link_blog'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                          $asoc['link_elaborato'] = filter_var($data['link_elaborato'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                          $ASOC = new Asoc;
                          $idasoc = $ASOC->create($asoc);

                          if($idasoc){
                            $Errors->set(5);
                          }
                          else {
                            $Errors->set(612);
                          }
                        }
                      }
                    }
                    $this->set('errors', $Errors);
                  }
                }
            }
        }

        public function register(){
          $this->set('title', 'Registrati');
          $this->set('js', array('section/user.js'));

          $this->Auth = new Auth();
          $Errors = new Errors();
          $UserModel = new User();

          if(!$this->Auth->isLoggedIn()){
            if( httpCheck('post', true) ){
              $data = array();
              $data = filter_var_array($_POST);

              // Check if email is in use already
              $email_check = $UserModel->findBy( array('email' => $data['email']) );
              if(count($email_check) > 0){
                $Errors->set(610);
              }
              // check validity of email
              if(!empty($data['email'])){
                if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                  $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
                } else {
                  $Errors->set(601);
                }
              }
              else {
                $Errors->set(600);
              }

              // Check Password correspondance
              if(!empty($data['pwd'])) {
                if($data['pwd'] != $data['c_pwd']){
                  $Errors->set(609);
                }
              } else {
                $Errors->set(602);
              }

              // Sanitize username
              $data['username'] = !empty($data['username']) ? filter_var($data['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : 'username';

              if(empty($Errors->errors)){
                /** encrypts password **/
                $userdata['password']         = password_hash($data['pwd'], PASSWORD_BCRYPT);
                $userdata['email']            = $data['email'];
                $userdata['username']         = filter_var($data['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $userdata['role']             = 4;
                $userdata['active']           = 1;
                $userdata['recover']          = strtoupper(bin2hex(random_bytes(12)));


                // Create User
                $idUser = $UserModel->create($userdata);
                if($idUser){
                  // create session
                  $RegSession = new Session;
                  $RegSession->createSession($idUser);

                  // Send activation email
                  $message  = '<h2>Benvenuto!</h2>E grazie di esserti registrato su Monithon, la piattaforma per il monitoraggio civico.<br />Per attivare il tuo account, clicca sul link qui sotto, o copialo ed incollalo nel tuo browser.<br /><br />';
                  $message .= '<a href="' . APPURL . '/user/activate/' . $userdata['recover'] . '">Attiva il tuo Account.</a>';

                  // To send HTML mail, the Content-type header must be set
                  $headers[] = 'MIME-Version: 1.0';
                  $headers[] = 'Content-type: text/html; charset=iso-8859-1';

                  // Additional headers
                  $headers[] = 'From: ' . APPEMAIL;

                  $send = mail($userdata['email'], 'Monithon - Attivazione Account', $message, implode("\r\n", $headers));
                  if($send){
                    $Errors->set(5);
                  }
                  else {
                    $Errors->set(300);
                  }
                }
              }
            }
            $this->set('errors', $Errors);
          }
          else {

          }
        }

        public function edit(){

          $this->Auth = new Auth();
          $Avatar     = new Repo();
          $File       = new Meta('file_repository');
          $Errors     = new Errors();
          $Report     = new Report();

          if(!$this->Auth->isLoggedIn()){
            header('Location: /user/login');
          }
          else {
            $this->logged = true;
            $this->set('logged', $this->logged);

            $this->user = $this->Auth->getProfile();
            $this->set('user', $this->user);
            $this->set('title', 'Modifica il tuo Profilo');

            $Region = new Meta('region', true);
            $Provincia = new Meta('provincia', true);

            $this->set('regioni', $Region->lexiconList);
            $this->set('province', $Provincia->listProvinceByRegion() );

            // Check for data in the post
            if( httpCheck('post', true) ){
              // clean up things
              $data   = $_POST;
              $id     = $this->user->id;

              unset($data['id']);
              unset($data['email']);
              unset($data['username']);

              // If role is > 3, then it is an ASOC profile
              if($this->user->role > 3){
                // set region
                $region = null;
                if(!empty($data['provincia'])){
                  $p = $Provincia->findLexiconEntry('idprovincia', $data['provincia']);
                  if($p){
                    $region = $p->region;
                  }
                }

                $asoc = array();

                $asoc['remote_id']      = filter_var($data['remote_id'], FILTER_SANITIZE_NUMBER_INT);
                $asoc['auth']           = $id;
                $asoc['istituto']       = filter_var($data['istituto'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $asoc['tipo_istituto']  = filter_var($data['tipo_istituto'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $asoc['regione']        = $region;
                $asoc['provincia']      = filter_var($data['provincia'], FILTER_SANITIZE_NUMBER_INT);
                $asoc['comune']         = filter_var($data['comune'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $asoc['link_blog']      = filter_var($data['link_blog'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $asoc['link_elaborato'] = filter_var($data['link_elaborato'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                unset($data['remote_id']);
                unset($data['istituto']);
                unset($data['tipo_istituto']);
                unset($data['regione']);
                unset($data['provincia']);
                unset($data['comune']);
                unset($data['link_blog']);
                unset($data['link_elaborato']);

                $ASOC = new Asoc;
                $asocprofile = $ASOC->findBy(array('auth' => $id));
                if($asocprofile){

                  $ASOC->update($asocprofile[0]->idasoc, $asoc);
                }
                else {
                  $ASOC->create($asoc);
                }
              }

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

            if($this->user->role > 3){
              $ASOC_Profile = new Asoc();
              $asoc_profile = $ASOC_Profile->findBy(array('auth' => $this->user->id));
              $this->set('ASOC_Profile', $asoc_profile[0]);
            }

            $Reports = $Report->findBy(array('created_by' => $this->user->id));
            $this->set('errors', $Errors);
            $this->set('Profile', $Profile);
            $this->set('reports', $Reports);
          }
        }

        public function update($id){
          $this->Auth = new Auth();
          $Avatar     = new Repo();
          $File       = new Meta('file_repository');
          $Errors     = new Errors();
          $Report     = new Report();
          $UserModel  = new User();

          if(!$this->Auth->isLoggedIn()){
            header('Location: /user/login');
          }
          else {

            $this->logged = true;
            $this->set('logged', $this->logged);


            $this->user = $this->Auth->getProfile();
            $Permissions = $this->Auth->getPermissions($this->user->id);



            $this->set('user', $this->user);
            $this->set('title', 'Modifica il Profilo');

            if(in_array(P_CREATE_USER, array_keys($Permissions)) && in_array(P_ASSIGN_PERMISSIONS, array_keys($Permissions))){
              $Region = new Meta('region', true);
              $Provincia = new Meta('provincia', true);
              $Roles = $UserModel->getRoles();

              $this->set('roles', $Roles);
              $this->set('regioni', $Region->lexiconList);
              $this->set('province', $Provincia->listProvinceByRegion() );

              // Check for data in the post
              if( httpCheck('post', true) ){
                // clean up things
                $data   = $_POST;
                $id     = $data['id'];

                unset($data['id']);
                unset($data['email']);
                unset($data['username']);

                $data['active'] = $data['active'] == 2 ? 2 : 1;
                // If role is > 3, then it is an ASOC profile
                if($this->user->role > 3){
                  // set region
                  $region = null;
                  if(!empty($data['provincia'])){
                    $p = $Provincia->findLexiconEntry('idprovincia', $data['provincia']);
                    if($p){
                      $region = $p->region;
                    }
                  }

                  $asoc = array();

                  $asoc['remote_id']      = filter_var($data['remote_id'], FILTER_SANITIZE_NUMBER_INT);
                  $asoc['auth']           = $id;
                  $asoc['istituto']       = filter_var($data['istituto'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                  $asoc['tipo_istituto']  = filter_var($data['tipo_istituto'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                  $asoc['regione']        = $region;
                  $asoc['provincia']      = filter_var($data['provincia'], FILTER_SANITIZE_NUMBER_INT);
                  $asoc['comune']         = filter_var($data['comune'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                  $asoc['link_blog']      = filter_var($data['link_blog'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                  $asoc['link_elaborato'] = filter_var($data['link_elaborato'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                  unset($data['remote_id']);
                  unset($data['istituto']);
                  unset($data['tipo_istituto']);
                  unset($data['regione']);
                  unset($data['provincia']);
                  unset($data['comune']);
                  unset($data['link_blog']);
                  unset($data['link_elaborato']);

                  $ASOC = new Asoc;
                  $asocprofile = $ASOC->findBy(array('auth' => $id));
                  if($asocprofile){

                    $ASOC->update($asocprofile[0]->idasoc, $asoc);
                  }
                  else {
                    $ASOC->create($asoc);
                  }
                }

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
                    $File->updateFileReferences(T_USER, $id, $filelist);
                  }
                }

              }

              $Profile = $this->User->fullProfile($id);

              if($Profile->role > 3){
                $ASOC_Profile = new Asoc();
                $asoc_profile = $ASOC_Profile->findBy(array('auth' => $id));
                $this->set('ASOC_Profile', $asoc_profile[0]);
              }

              $Reports = $Report->findBy(array('created_by' => $id));
              $this->set('errors', $Errors);
              $this->set('Profile', $Profile);
              $this->set('reports', $Reports);
            }
            else {
              header('Location: /user/ops');
            }
          }
        }

        /* User list for platform admins **/
        public function list(){
          $this->Auth = new Auth();
          $Errors = new Errors();
          $UserModel = new User();

          if(!$this->Auth->isLoggedIn()){
              header('Location: /user/login');
          }
          else {
              $this->set('js', array('section/user.js'));
              $this->logged = true;
              $this->set('logged', $this->logged);
              $this->User = $this->Auth->getProfile();
              $this->set('user', $this->User);
              $this->set('title', 'Lista Utenti');

              if(!(in_array(P_CREATE_USER, array_keys($this->User->permissions)))){
                  header('Location: /user/ops');
              }
              else {
                $List = $UserModel->listProfiles();
                $this->set('list', $List);

              }
            }
        }


        public function recover(){ }

        public function activate($code){
          $this->set('title', 'Attivazione Account');
          $activation = $this->User->activate($code);

          if($activation == true){
            $this->set('activation', $activation);
          }
          else {
            $this->set('errors', $activation);
          }

        }

        public function reset(){ }

        /** Error page **/
        public function ops(){
          $Auth = new Auth();
          if(!$this->Auth->isLoggedIn()){
            header('Location: /user/login');
          }
          else {

            $this->logged = true;
            $this->set('logged', $this->logged);
            $this->set('title', 'Oooops!');
          }
        }
    }
