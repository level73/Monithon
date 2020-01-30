<?php

  class Model {

    protected $database;
    protected $table;
    protected $hasOrg;
    protected $dates = true;
    protected $pkey;
    public $Errors;

    /** Constructor and Connector **/
    public function __construct() {
      $this->Errors = new Errors;
      if(is_null($this->pkey)){
        $this->pkey = 'id' . $this->table;
      }
      if(!$this->database){
        $dns = DBTYPE . ':dbname=' . DBNAME . ';host=' . DBHOST . ';charset=utf8';
        $this->database = new PDO(
          $dns,
          DBUSER,
          DBPASS
        );
        if (is_object($this->database)) {
          $this->database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
          return $this->database;
        }
        else {
          $this->Errors->set(500);
          return $this->Errors;
        }
      }
    }

    /** All Model data **/
    public function all(){
      $sql = 'SELECT * FROM `' . $this->table . '`';
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

    /** Find by Table PK **/
    public function find($id, $array = false){
      $sql = 'SELECT `' . $this->table . '`.* ';
      $sql .= ' FROM `' . $this->table . '`';
      $sql .= ' WHERE `' . $this->pkey . '` = :id ';

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
        if($array == false) {
          return $stmt->fetch(PDO::FETCH_OBJ);
        }
        else {
          return $stmt->fetch(PDO::FETCH_ASSOC);
        }
      }
    }

    /** Find by Params
      * params @array, keys are fields
    **/
    public function findBy($params){
      $sql = 'SELECT * FROM `' . $this->table . '` WHERE ';
      $sql .= implode(' AND ', query_placeholders($params));

      $stmt = $this->database->prepare($sql);

      foreach($params as $field => &$value){
        $stmt->bindParam(':' . $field, $value);
      }

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

    /** Update record **/
    public function update($id, $data){
      $sql = 'UPDATE ' . $this->table . ' SET ' . implode(', ', query_placeholders($data)) . ' WHERE ' . $this->pkey . ' = :id';
      // echo $sql . "<br /><br />";
      $stmt = $this->database->prepare($sql);
      foreach($data as $field => $value ){
      //  echo "Working on <strong>" . $field . "</strong> [" . $value . "]<br />";
        if( ( empty($value) || is_null($value) ) ){
          $data[$field] = null;
        }
        // echo "transformed into - " . $data[$field] . "<br /><br />";
      }

      foreach($data as $field => &$value){
        // echo "BINDING " . $field . " TO " . $value . "<br />";
        $stmt->bindParam(':' . $field, $value);
      }
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

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

    /** Create record **/
    public function create($data){
      $sql = 'INSERT INTO ' . $this->table . ' (`' . implode('`, `', array_keys($data)) . '`) VALUES (' . implode(', ', query_placeholders($data, true)) . ')';
      $stmt = $this->database->prepare($sql);

      foreach($data as $field => &$value){
        $stmt->bindParam(':' . $field, $value);
      }

      $query = $stmt->execute();

      if(!$query){
        $this->Errors->set(501);
        if(SYSTEM_STATUS == 'development'){
          dbga($stmt->errorInfo());
        }
        return $this->Errors;
      } else {
        return $this->database->lastInsertId();
      }
    }

    /** Delete record **/
    public function delete($id){
      $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->pkey . '= :id';
      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      $query = $stmt->execute();
      if($query){
        return true;
      }
      else {
        dbga($stmt->errorInfo());
      }
    }


  }
