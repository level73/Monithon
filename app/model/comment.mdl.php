<?php

  class Comment extends Model {
    protected $table  = 'entity_comment';
    protected $pkey   = 'idcomment';

    public function save($comment, $field, $entity, $record, $user_id){
        $sql = 'INSERT INTO ' . $this->table . ' ( entity, record, field, comment, created_by) VALUES (:entity, :record, :field, :comment, :created_by)';

        $stmt = $this->database->prepare($sql);

        $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
        $stmt->bindParam(':record', $record, PDO::PARAM_INT);
        $stmt->bindParam(':field', $field, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':created_by', $user_id, PDO::PARAM_INT);

        $query = $stmt->execute();
        if(!$query){
            $this->Errors->set(501);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return $this->Errors;
        } else {
            return true;
        }
    }

  }
