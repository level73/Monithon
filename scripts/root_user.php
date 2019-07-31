<?php

  /**
    * This class calculates the Member Engagement Index parameters for each
    * of the members of ILC. It then proceeds to save these values
    * to a dedicated table on the membernet database (table name:
    * registry_member_engagement_index). It can be called as a cronjob
    * with no arguments to update the index periodically.
    * */

  // Require all needed config files and classes
  require('../config/local.php');
  require('../config/system.php');

  require('../lib/functions.php');
  require('../lib/errors.class.php');
  require('../lib/model.class.php');
  require('../lib/meta.class.php');
  require('../lib/session.class.php');
  require('../lib/auth.class.php');

  require('../app/model/user.mdl.php');

  class RootUser extends Model {

    public function setup(){
      $data = array();

      $data['email'] = 'code@level73.it';
      $data['password'] = password_hash('secret', PASSWORD_BCRYPT);
      $data['username'] = 'lvl73';
      $data['role'] = 1;
      $data['active'] = 2;
      $data['modified_by'] = 1;

      dbga($data);

      $User = new User;
      $idUser = $User->create($data);

      echo "USER ID: " . $idUser;
      if($idUser){
        $RegSession = new Session;
        $RegSession->createSession($idUser);
        // set Permissions
        $RegSession->setPermissions($idUser, array(1,2,3,4,5,6,7,8,9) );
      //  $Errors->set(1);
      }


    }


  }

  $Root = new RootUser();
  $Root->setup();
