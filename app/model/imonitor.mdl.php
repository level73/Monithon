<?php

class Imonitor extends Model
{
    protected $table = 'entity_imonitor';
    protected $pkey = 'idimonitor';


    public function reviewableReports($id_user){
        $sql = '  SELECT idimonitor, title, username, email, erb.created_at, erb.modified_at, status FROM `' . $this->table . '` AS erb 
                INNER JOIN auth ON auth.idauth = created_by 
                WHERE status = 3 OR status = 7 OR (status = 5 AND reviewed_by = :user_1) OR (created_by = :user_2)                 
                ORDER BY erb.modified_at DESC';



        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':user_1', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':user_2', $id_user, PDO::PARAM_INT);

        $query = $stmt->execute();
        if(!$query){
            $this->Errors->set(501);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return $this->Errors;
        } else {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
}