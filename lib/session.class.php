<?php

class Session extends Model {

  protected $table = 'auth_session';
  protected $dates = true;
  public $Errors;

  public function __construct(){
    parent::__construct();
    $this->Errors = new Errors;
  }

  public function createSession($user){
      $session = 'noToken'.md5(substr(time(), -8));
      $created_at = date('Y-m-d H:i:s', time() );
      $sql = 'INSERT INTO `auth_session`(`session`, `auth`, created_at) VALUES (:session, :user, :tm)';

      $stmt = $this->database->prepare($sql);

      $stmt->bindParam(':session', $session, PDO::PARAM_STR);
      $stmt->bindParam(':user', $user, PDO::PARAM_INT);
      $stmt->bindParam(':tm', $created_at, PDO::PARAM_STR);

      $q = $stmt->execute();

      if(!$q){
          $this->Errors->set(603);
          return false;
      }
      else {
          return true;
      }


  }

  public function setSession($user, $sessionToken) {

      $sql = 'UPDATE `auth_session` SET `session` = :session WHERE `auth` = :user';

      $stmt = $this->database->prepare($sql);

      $stmt->bindParam(':session', $sessionToken, PDO::PARAM_STR);
      $stmt->bindParam(':user', $user, PDO::PARAM_INT);

      $q = $stmt->execute();

      if(!$q){
          $this->Errors->set(603);
          dbga($stmt->errorInfo());
          return false;
      }
      else {
          unset($_SESSION[APPNAME]);
          $_SESSION[APPNAME][SESSIONKEY] = $sessionToken;

          return true;
      }
  }

  protected function getSession() {
      if(array_key_exists(APPNAME, $_SESSION)){
        $session = $_SESSION[APPNAME][SESSIONKEY];

        $sql = 'SELECT auth.idauth AS id, auth.username, auth.email FROM auth
                INNER JOIN auth_session ON auth_session.auth = auth.idauth
                WHERE auth_session.session = :session';

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':session', $session, PDO::PARAM_STR);
        $q = $stmt->execute();


        if(!$q){
            $this->Errors->set(604);
            return false;
        }
        else {
            $objectUser = $stmt->fetch(PDO::FETCH_OBJ);

            if(is_object($objectUser)){
                $objectUser->permissions = self::getPermissions($objectUser->id);
            }
            return $objectUser;
        }
    } else {
      return false;
    }
  }


  public function getPermissions($user){
    $sql = 'SELECT
              `auth_meta_permissions`.`permission` AS  `permission`,
              `auth_lexicon_permission`.`permission` AS  `label`
            FROM `auth_meta_permissions`
            INNER JOIN `auth_lexicon_permission`
              ON `auth_lexicon_permission`.`idpermission` = `auth_meta_permissions`.`permission`
            WHERE `auth` = :user ';
    $stmt = $this->database->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);
    $q = $stmt->execute();
    if(!$q){
        $this->Errors->set(608);
        return false;
    }
    else {
      $obj = $stmt->fetchAll(PDO::FETCH_OBJ);
      $permissions = array();
      foreach($obj as $i => $p){
        $permissions[$p->permission] = $p->label;
      }
      return $permissions;
    }

  }

  /**
   * Set Permissions for $user
   * @user = id of user (int)
   * @permissions = array of ids of permissions
   * return true on success, false oon failure
   **/
  public function setPermissions($user, $permissions){
    // Delete any current permissions
    $sql_d = 'DELETE FROM auth_meta_permissions WHERE auth = :user';
    $stmt_d = $this->database->prepare($sql_d);
    $stmt_d->bindParam(':user', $user, PDO::PARAM_INT);
    $q = $stmt_d->execute();

    $sql_i = 'INSERT INTO auth_meta_permissions(auth, permission) VALUES (:user, :permission)';
    $stmt_i = $this->database->prepare($sql_i);
    $stmt_i->bindParam(':user', $user, PDO::PARAM_INT);
    foreach($permissions as $p){
      $stmt_i->bindParam(':permission', $p, PDO::PARAM_INT);
      $stmt_i->execute();
    }
  }

  public function destroySession($user) {
       if(!is_numeric($user)){
          $this->Errors->set(503);
          return false;
      }
      else {
          $sql = 'DELETE FROM `' . $this->table . '` WHERE `user` = :id';
          $stmt = $this->database->prepare($sql);
          if(!$stmt && SYSTEM_STATUS == 'development'){
              dbga($this->database->errorInfo());
          }
          else {
              $stmt->bindParam(':id', $user, PDO::PARAM_INT);

              $q = $stmt->execute();
              if(!$q && SYSTEM_STATUS == 'development'){
                  $err = $stmt->errorInfo();

                  $this->Errors->set(605);
                  return false;
              }
              else {
                  return true;
              }
          }
      }
  }
}
