<?php
 class User extends Model {
    protected $table = 'auth';

    public function fullProfile($id){
      $sql = 'SELECT * FROM auth WHERE idauth = :id';

      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $query = $stmt->execute();
      if(!$query){
        $this->Errors->set(501);
        if(SYSTEM_STATUS == 'development'){
          dbga($stmt->errorInfo());
        }
        return $this->Errors;
      } else {
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $Avatar = new Repo();
        $files = $Avatar->getFiles(T_USER, $id);
        $avatar = array_pop($files);
        $user->avatar = $avatar;
        return $user;
      }
    }

    public function getPermissions(){
      $sql = 'SELECT * FROM `auth_lexicon_permission`';
      $stmt = $this->database->prepare($sql);
      $query = $stmt->execute();
      if(!$query){
        $this->Errors->set(502);
        if(SYSTEM_STATUS == 'development'){
          dbga($stmt->errorInfo());
        }
        return $this->Errors;
      } else {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
      }
    }

    public function listProfiles(){
      $sql = 'SELECT
              	auth.idauth as id, auth.username, auth.email, auth_role.role, auth.active, auth.privacy, UNIX_TIMESTAMP(auth_session.modified_at) AS last_login
              FROM auth
              	INNER JOIN auth_role ON auth_role.idrole = auth.role
                INNER JOIN auth_session ON auth_session.auth = auth.idauth
              ORDER BY last_login DESC';

      $stmt = $this->database->prepare($sql);
      $query = $stmt->execute();
      if(!$query){
        $this->Errors->set(502);
        if(SYSTEM_STATUS == 'development'){
          dbga($stmt->errorInfo());
        }
        return $this->Errors;
      } else {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
      }

    }

 }
