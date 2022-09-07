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
    public function findBy($params, $orderBy = null){
      $sql = 'SELECT * FROM `' . $this->table . '` WHERE ';
      $sql .= implode(' AND ', query_placeholders($params));
      if(!is_null($orderBy) && is_array($orderBy)){
          $sql .= ' ORDER BY ' . $orderBy['field'] . ' ' . $orderBy['direction'];
      }
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
      $stmt = $this->database->prepare($sql);
      if(!$stmt){
        dbga( $this->database->errorInfo() );
      }
      foreach($data as $field => $value ){
        if( ( empty($value) || is_null($value) ) ){
          $data[$field] = null;
        }
      }

      foreach($data as $field => &$value){
        $binder = $stmt->bindParam(':' . $field, $value);
        if(!$binder){
           echo 'error binding params: ['.$field.'|'.$value.'] :: ' . $stmt->error;
        }
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
          echo $field . "<br />";
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
