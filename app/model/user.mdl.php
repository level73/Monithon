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
 }
