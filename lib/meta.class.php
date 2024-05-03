<?php
  /**
    * Meta Class
    * Manages the connection to entities and lexicons
    * Initiates the desired Meta layer and brings up the lexicon
    * @meta (string)  = the name of the meta layer
    * @lexicon (boolean) = true if the meta has  a lexicon
    **/

  class Meta extends Model {

    protected $meta = null;
    protected $meta_table = 'meta_';
    protected $lexicon = null;
    protected $pkey = null;
    public $lexiconList;

    public function __construct($meta, $lexicon = null, $do_not_load_lexicon = null){
      $this->meta =  $meta;
      $this->meta_table = 'meta_' . $meta;
      $this->pkey = 'id' . $meta;
      if($lexicon){
        $this->lexicon = 'lexicon_' . $meta;
        $this->table = $this->lexicon;
      }

      parent::__construct();
      if($meta == 'provincia'){
        // Costruzione della lista di Province con le regioni


      }
      if($lexicon && $do_not_load_lexicon == null){
        $this->lexiconList = $this->all();
      }
    }

    public function listing(){
      if(!empty( $this->lexiconList )){

        $listing = array();

        foreach( $this->lexiconList as $i => $element){
          $listing[$i] = array(
            'id' => $element->{$fields[0]},
            'f1' => $element->{$fields[1]},
            'f2' => $element->{$fields[2]},
          );
        }
        //dbga($listing);
        return $listing;
      }

    }


    public function setSelectList($idlabel, $textlabel, $extralabel = null){
      $list = array();
      $data = $this->lexiconList;

      foreach($data as $i => $element){
        $list[$i]['value'] = $element->{$idlabel};
        $list[$i]['label'] = $element->{$textlabel};
        if(!is_null($extralabel)){ $list[$i]['extra'] = 'data-subtext="' . $element->{$extralabel} . '"'; }
      }

      return $list;
    }

    public function findLexiconEntry($field, $value){
      if($this->lexiconList){
        foreach($this->lexiconList as $i => $entry){
          if($entry->$field == $value){
            return $this->lexiconList[$i];
          }
        }
      } else {

        $sql = 'SELECT * FROM ' . $this->lexicon . ' WHERE ' .$field.' = UPPER( :value ) OR ' . $field . ' = :value2';
        $stmt = $this->database->prepare($sql);

        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':value2', $value);
        $query = $stmt->execute();
        if(!$query){
          $this->Errors->set(502);
          if(SYSTEM_STATUS == 'development'){
            dbga($stmt->errorInfo());
          }
          return $this->Errors;
        }
        else {
          $r = $stmt->fetch(PDO::FETCH_OBJ);
          return $r;
        }
      }
      return false;
    }

    public function getReferences($entity, $record, $lexicon = null, $join_model = null, $orderBy = array() ){
      $sql = 'SELECT * FROM `' . $this->meta_table . '` ';
      if(!is_null($lexicon)) {
        $sql .= ' INNER JOIN ' . $this->lexicon . ' ON ' . $this->lexicon . '.id'. $this->meta .' = ' . $this->meta_table . '.' . $this->meta ;
      }
      if(!is_null($join_model)){
          $sql .= ' INNER JOIN entity_' . $join_model . ' ON ' . $this->meta_table . '.' . $join_model . '  = entity_' . $join_model . '.id' . $join_model ;
      }

      $sql .= ' WHERE `entity` = :entity AND `record` = :record ';

      if(!empty($orderBy)){
        $sql .= ' ORDER BY ' . $orderBy['field'] . ' ' . $orderBy['mode'];
      }
      // echo $sql . "<br /><br />";
      $stmt = $this->database->prepare($sql);

      $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
      $stmt->bindParam(':record', $record, PDO::PARAM_INT);

      $query = $stmt->execute();
      if(!$query){
        $this->Errors->set(502);
        if(SYSTEM_STATUS == 'development'){
          dbga($stmt->errorInfo());
        }
        return $this->Errors;
      }
      else {
        $r = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $r;
      }

    }

    public function getMultipleReferences($entity, $record_array, $lexicon = null, $join_model = null, $orderBy = array() ){
      $sql = 'SELECT * FROM `' . $this->meta_table . '` ';
      if(!is_null($lexicon)) {
        $sql .= ' INNER JOIN ' . $this->lexicon . ' ON ' . $this->lexicon . '.id'. $this->meta .' = ' . $this->meta_table . '.' . $this->meta ;
      }
      if(!is_null($join_model)){
          $sql .= ' INNER JOIN entity_' . $join_model . ' ON ' . $this->meta_table . '.record = entity_' . $join_model . '.id' . $join_model ;
      }
      $sql .= ' WHERE `entity` = :entity AND `record` IN (' . implode(',', $record_array) . ') ';
      if(!empty($orderBy)){
        $sql .= ' ORDER BY ' . $orderBy['field'] . ' ' . $orderBy['mode'];
      }
      //echo $sql . "<br /><br />";

      $stmt = $this->database->prepare($sql);

      $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);

      $query = $stmt->execute();


      if(!$query){
        $this->Errors->set(502);
        if(SYSTEM_STATUS == 'development'){
          dbga($stmt->errorInfo());
        }
        return $this->Errors;
      }
      else {
        $r = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $r;
      }
    }


    public function reverseLookup($entity, $id, $join_model = null, $sorter = null){
      $sql = ' SELECT * FROM ' . $this->meta_table ;
      if(!is_null($join_model)){
          $sql .= ' INNER JOIN entity_' . $join_model . ' ON ' . $this->meta_table . '.record  = entity_' . $join_model . '.id' . $join_model ;
      }
      if(!is_null($sorter)){
        $sql .= ' LEFT JOIN (SELECT * FROM meta_living_dates WHERE entity = ' . $entity . ') AS mld ON mld.record = entity_' . $join_model . '.id' . $join_model;
      }
      $sql .=  ' WHERE entity = :entity AND ' . $this->meta_table . '.' . $this->meta . ' = :id ';
      if(!is_null($sorter)){
        $sql .= ' ORDER BY start DESC';
      }
      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $query = $stmt->execute();

      if(!$query){
        $this->Errors->set(502);
        if(SYSTEM_STATUS == 'development'){
          dbga($stmt->errorInfo());
        }
        return $this->Errors;
      }
      else {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
      }

    }


    public function updateReferences($entity, $record, $meta_records){
      // delete old references
      if(self::unsetReferences($entity, $record) == true && !empty($meta_records)){
        // set new references
        $sql = 'INSERT INTO `' . $this->meta_table . '`(`entity`, `record`, `' . $this->meta . '`) VALUES (:entity, :record, :meta)';

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
        $stmt->bindParam(':record', $record, PDO::PARAM_INT);
        if(!is_array($meta_records)) {
          $meta_records = array($meta_records);
        }

        foreach($meta_records as $i => &$meta_record){

          $stmt->bindParam(':meta', $meta_record, PDO::PARAM_INT);
          $query = $stmt->execute();

          if(!$query){
            $this->Errors->set(502);
            if(SYSTEM_STATUS == 'development'){
              dbga($stmt->errorInfo());
            }
            return $this->Errors;
          }
        }
        return true;
      }
      else {
        $this->Errors->set(520);
        return $this->Errors;
      }
    }

    public function updateFileReferences($entity, $record, $meta_records){
      // set new references
      $sql = 'INSERT INTO `' . $this->meta_table . '`(`entity`, `record`, `' . $this->meta . '`) VALUES (:entity, :record, :meta)';

      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
      $stmt->bindParam(':record', $record, PDO::PARAM_INT);

      foreach($meta_records as $i => &$meta_record){
        $stmt->bindParam(':meta', $meta_record, PDO::PARAM_INT);
        $query = $stmt->execute();
        if(!$query){
          $this->Errors->set(502);
          if(SYSTEM_STATUS == 'development'){
            dbga($stmt->errorInfo());
          }
          return $this->Errors;
        }
      }
      return true;
    }

    public function updateLinkReferences($entity, $record, $meta_records){
      // set new references
      $sql = 'INSERT INTO `' . $this->meta_table . '`(`entity`, `record`, `' . $this->meta . '`) VALUES (:entity, :record, :meta)';

      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
      $stmt->bindParam(':record', $record, PDO::PARAM_INT);

      foreach($meta_records as $i => &$meta_record){
        $stmt->bindParam(':meta', $meta_record, PDO::PARAM_INT);
        $query = $stmt->execute();
        if(!$query){
          $this->Errors->set(502);
          if(SYSTEM_STATUS == 'development'){
            dbga($stmt->errorInfo());
          }
          return $this->Errors;
        }
      }
      return true;
    }

    public function updateVideoReferences($entity, $record, $meta_records){
      // set new references
      $sql = 'INSERT INTO `' . $this->meta_table . '`(`entity`, `record`, `' . $this->meta . '`) VALUES (:entity, :record, :meta)';

      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
      $stmt->bindParam(':record', $record, PDO::PARAM_INT);

      foreach($meta_records as $i => &$meta_record){
        $stmt->bindParam(':meta', $meta_record, PDO::PARAM_INT);
        $query = $stmt->execute();
        if(!$query){
          $this->Errors->set(502);
          if(SYSTEM_STATUS == 'development'){
            dbga($stmt->errorInfo());
          }
          return $this->Errors;
        }
      }
      return true;
    }

    public function unsetReferences($entity, $record){
      $sql = 'DELETE FROM `' . $this->meta_table . '` WHERE `entity` = :entity AND record = :record';

      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
      $stmt->bindParam(':record', $record, PDO::PARAM_INT);
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
    public function unsetRepoReference($entity, $repo, $element){
        $sql = 'DELETE FROM `' . $this->meta_table . '_repository` WHERE `entity` = :entity AND ' . $repo . '_repository = :record';

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
        $stmt->bindParam(':record', $element, PDO::PARAM_INT);
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

    public function unsetRepo($type, $id){
        if($type == 'file'){
            $File = new Repo();
            $file = $File->find($id);
            if($File->getInfo(DIR_REPO . $file->file_path)){
                file_exists(DIR_REPO . '90x90_' . $file->file_path) ? unlink(DIR_REPO . '90x90_' . $file->file_path) : null;
                file_exists(DIR_REPO . '180x180_' . $file->file_path) ?unlink(DIR_REPO . '180x180_' . $file->file_path) : null;
                file_exists(DIR_REPO . '270x270_' . $file->file_path) ?unlink(DIR_REPO . '270x270_' . $file->file_path) : null;
                file_exists(DIR_REPO . 'cropx90_' . $file->file_path) ?unlink(DIR_REPO . 'cropx90_' . $file->file_path) : null;
                file_exists(DIR_REPO . 'cropx180_' . $file->file_path) ?unlink(DIR_REPO . 'cropx180_' . $file->file_path) : null;
            }
            unlink(DIR_REPO . $file->file_path);
        }
        $sql = 'DELETE FROM ' . $type . '_repository WHERE id' . $type . '_repository = :id';
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
            return true;
        }
    }

    public function unsetOrganisationRoles($organisation){
      $sql = 'DELETE FROM `' . $this->meta_table . '` WHERE `organisation` = :org ';

      $stmt = $this->database->prepare($sql);

      $stmt->bindParam(':org', $organisation, PDO::PARAM_INT);
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

    public function unsetContactRoles($contact){
      $sql = 'DELETE FROM `' . $this->meta_table . '` WHERE `contact` = :contact ';

      $stmt = $this->database->prepare($sql);

      $stmt->bindParam(':contact', $contact, PDO::PARAM_INT);
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

    /** Report Connections Meta Table */
      public function getConnections($report, $entity = T_REP_BASIC){
        $sql = 'SELECT * FROM meta_connection WHERE report = :report AND `entity` = :entity';
        $stmt = $this->database->prepare($sql);

          $stmt->bindParam(':report', $report, PDO::PARAM_INT);
          $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
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

      public function unsetConnections($report, $entity = T_REP_BASIC){
          $sql = 'DELETE FROM `' . $this->meta_table . '` WHERE `report` = :report AND `entity` = :entity';

          $stmt = $this->database->prepare($sql);

          $stmt->bindParam(':report', $report, PDO::PARAM_INT);
          $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
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

      public function updateConnections($entity, $report, $data){

        self::unsetConnections($report);
        foreach($data as $i => $data){
        $fields = array_keys($data);
        $holders = query_placeholders($data, true);
        $report = (integer)$report;

        $sql = 'INSERT INTO meta_connection(entity, report, ' . implode(", ", $fields) . ') VALUES (:entity, :report, ' . implode(",", $holders) . ')';

        $stmt = $this->database->prepare($sql);

        $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
        $stmt->bindParam(':report', $report, PDO::PARAM_INT);
        foreach($data as $field => &$value){
            $stmt->bindParam(':'.$field, $value);
        }
        $query = $stmt->execute();
        if(!$query){
            $this->Errors->set(501);
            if(SYSTEM_STATUS == 'development'){
                dbga($stmt->errorInfo());
            }
            return $this->Errors;
        }
      }
    }


    // Connections Relationship Map
      public function unsetConnectionMap($report){
          $sql = 'DELETE FROM `' . $this->meta_table . '` WHERE `report` = :report ';

          $stmt = $this->database->prepare($sql);

          $stmt->bindParam(':report', $report, PDO::PARAM_INT);
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

      public function updateConnectionMap($report, $data){

          self::unsetConnections($report);

          $fields = array_keys($data);
          $holders = query_placeholders($data, true);
          $report = (integer)$report;

          $sql = 'INSERT INTO meta_connection_relationship (report,' . implode(", ", $fields) . ') VALUES (:report, ' . implode(",", $holders) . ')';
          echo $sql;
          /*
          $stmt = $this->database->prepare($sql);

          $stmt->bindParam(':report', $report, PDO::PARAM_INT);
          foreach($data as $field => &$value){
              $stmt->bindParam(':'.$field, $value);
          }
          $query = $stmt->execute();
          if(!$query){
              $this->Errors->set(501);
              if(SYSTEM_STATUS == 'development'){
                  dbga($stmt->errorInfo());
              }
              return $this->Errors;
          }
          */

      }


    /** fields to build the form in this format:
     *  type, name, class, label, options, value
    **/
    public function form($fields){
      $formFields = array();
      $formFields['lexicon'] = '<input type="hidden" name="lexicon" value="' . $this->lexicon  .'">';



      foreach($fields as $field){
        $formField = '';
        // implement tabs
        if($field['type'] == 'tabs'){
          $formField .= '<ul class="nav nav-tabs" role="tablist">';
          foreach($field['tabs'] as $i => $tab){
            $formField .= '<li role="presentation" class="'.($i==0?'active':'').'"><a href="#'.$tab['id'].'" aria-controls="home" role="tab" data-toggle="tab">'.$tab['label'].'</a></li>';
          }
          $formField .= '</ul>';
          $formField .= '<div class="tab-content">';
        }


        elseif($field['type'] == 'tab'){
          $formField .= '<div role="tabpanel" class="tab-pane ' . ($field['options']) . '" id="' . $field['id'] . '">';
        }
        elseif($field['type'] == 'end-tab'){
          $formField .= '</div>';
        }
        elseif($field['type'] == 'end-tabs'){
          $formField .= '</div>';
        }





        elseif($field['type'] == 'select'){

          $formField .= '<div class="form-group">';
          $formField .= '<label for="' . $field['name'] . '">' . $field['label'] . (isset($field['required']) ? ' <span class="required">*</span>' : '') . '</label>';


          $formField .= '<select name="' . $field['name'] . '" id="' . $field['name'] . '" class="form-control ' .  $field['class'] . '" ' . $field['options'] . ' ' . (isset($field['required']) ? ' required  data-error="this field is mandatory"' : '') . '  data-icon-base="far" data-tick-icon="fa-check">';
          if(!empty($field['data'])) {
            foreach($field['data'] as $i => $f){
              $formField .= '<option value="' . $f['value'] . '" ' . (isset($f['extra']) ?  $f['extra'] : '') . ( $f['value'] == $field['value'] ? ' selected' : '') . '>' . $f['label'] . '</option>';
            }
          }
          $formField .= '</select>';
          $formField .= '<div class="help-block with-errors"></div>';
          $formField .= '</div>';

        }

        elseif($field['type'] == 'textarea'){

          $formField .= '<div class="form-group">';
          $formField .= '<label for="' . $field['name'] . '">' . $field['label'] . (isset($field['required']) ? ' <span class="required">*</span>' : '') . '</label>';

          $formField .= '<textarea name="' . $field['name'] . '" id="' . $field['name'] . '" class="form-control ' .  $field['class'] . '" ' . $field['options'] . ' ' . (isset($field['required']) ? ' required' : '') . '>';
          $formField .= $field['value'];
          $formField .= '</textarea>';
          $formField .= '<div class="help-block with-errors"></div>';
          $formField .= '</div>';

        }

        elseif($field['type'] == 'rte'){
          $formField .= '<div class="form-group">';
          $formField .= '<label for="' . $field['name'] . '">' . $field['label'] . (isset($field['required']) ? ' <span class="required">*</span>' : '') . '</label>';

          $formField .= '<textarea name="' . $field['name'] . '" id="' . $field['name'] . '" class=" ' .  $field['class'] . ' summernote" ' . $field['options'] . ' ' . (isset($field['required']) ? ' required' : '') . '>';
          $formField .= $field['value'];
          $formField .= '</textarea>';
          $formField .= '<div class="help-block with-errors"></div>';
          $formField .= '</div>';

        }

        elseif($field['type'] == 'date') {
          $formField .= '<div class="form-group">';
          $formField .= '<label for="' . $field['name'] . '">' . $field['label'] . (isset($field['required']) ? ' <span class="required">*</span>' : '') . '</label>';

          $formField .= '<div class="input-group date">';
          $formField .= '<input type="text" name="' . $field['name'] . '" id="' . $field['name'] . '" class="form-control ' .  $field['class'] . ' date" ' . (isset($field['required']) ? ' required' : '') . ' ' . $field['options'] .' value="' . $field['value'] . '" placeholder="dd/mm/yyyy">';
          $formField .= '<span class="input-group-addon"><span class="far far-calendar-alt"></span></span>';
          $formField .= '</div>';
          $formField .= '<div class="help-block with-errors"></div>';
          $formField .= '</div>';

        }


        elseif($field['type'] == 'money') {
          $formField .= '<div class="form-group">';
          $formField .= '<label for="' . $field['name'] . '">' . $field['label'] . (isset($field['required']) ? ' <span class="required">*</span>' : '') . '</label>';

          $formField .= '<div class="input-group">';
          $formField .= '<span class="input-group-addon"><strong>USD</strong></span>';
          $formField .= '<input type="text" name="' . $field['name'] . '" id="' . $field['name'] . '" class="form-control ' .  $field['class'] . '" ' . (isset($field['required']) ? ' required' : '') . ' ' . $field['options'] .' value="' . $field['value'] . '" placeholder="Amount in US Dollars">';
          $formField .= '<span class="input-group-addon">.00</span>';
          $formField .= '</div>';
          $formField .= '<div class="help-block with-errors"></div>';
          $formField .= '</div>';

        }


        elseif($field['type'] == 'switch') {
          $formField .= '<div class="form-group">';
          $formField .= '<label for="' . $field['name'] . '">' . $field['label'] . (isset($field['required']) ? ' <span class="required">*</span>' : '') . '</label>';

          $formField .= '
                <div class="switch-toggle">
                  <input id="' . $field['name'] . '-1" name="' . $field['name'] . '" type="radio" value="1" ' . ($field['value'] == 1 ? 'checked' : '') . '>
                  <label for="' . $field['name'] . '-1" onclick="">N/A</label>

                  <input id="' . $field['name'] . '-2" name="' . $field['name'] . '" type="radio" value="2" ' . ($field['value'] == 2 ? 'checked' : '') . '>
                  <label for="' . $field['name'] . '-2" onclick="">NO</label>

                  <input id="' . $field['name'] . '-3" name="' . $field['name'] . '" type="radio" value="3" ' . ($field['value'] == 3 ? 'checked' : '') . '>
                  <label for="' . $field['name'] . '-3" onclick="">YES</label>

                  <a class="btn btn-primary"></a>
                </div>';
                $formField .= '<div class="help-block with-errors"></div>';
                $formField .= '</div>';

        }

        else {
          $formField .= '<div class="form-group">';
          $formField .= '<label for="' . $field['name'] . '">' . $field['label'] . (isset($field['required']) ? ' <span class="required">*</span>' : '') . '</label>';

          $formField .= '<input type="' . $field['type'] . '" name="' . $field['name'] . '" id="' . $field['name'] . '" class="form-control ' .  $field['class'] . '" ' . (isset($field['required']) ? ' required' : '') . ' ' . $field['options'] .' value="' . $field['value'] . '">';
          $formField .= '<div class="help-block with-errors"></div>';
          $formField .= '</div>';

        }
        $formFields[] = $formField;
      }

      //dbga( $formFields );

      return $formFields;
    }

    public function updateLexicon($id, $data){

      $sql = 'UPDATE ' . $this->lexicon . ' SET ' . implode(', ', query_placeholders($data)) . ' WHERE ' . $this->pkey . ' = :id';
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

    public function listProvinceByRegion(){
      $sql = 'SELECT *, lexicon_region.region AS region_label  FROM lexicon_provincia INNER JOIN lexicon_region ON lexicon_region.idregion=lexicon_provincia.region ORDER BY lexicon_region.region ASC';

      $stmt = $this->database->prepare($sql);

      $query = $stmt->execute();

      if(!$query){
        $this->Errors->set(501);
        if(SYSTEM_STATUS == 'development'){
          dbga($stmt->errorInfo());
        }
        return $this->Errors;
      } else {
        $List = $stmt->fetchAll(PDO::FETCH_OBJ);
        $response = array();
        foreach($List as $l){
          $response[$l->region_label][] = $l;
        }
        return $response;
      }
    }

    public function getRepoReference($repo, $entity, $record){
      $sql = 'SELECT * FROM '.$repo.' WHERE id'.$repo.' IN (SELECT '.$repo.' FROM meta_'.$repo.' WHERE entity = :entity AND record = :record)';
      $stmt = $this->database->prepare($sql);
      $stmt->bindParam(':entity', $entity, PDO::PARAM_INT);
      $stmt->bindParam(':record', $record, PDO::PARAM_INT);
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


  /** EOF CLASS **/
  }
