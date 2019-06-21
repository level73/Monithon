<?php

  class Entity extends Model {

    public $name;
    public $fields;
    const PREFIX = 'entity_';

    public function __construct($entity){
      parent::__construct();
      $this->entity = $entity;
    }


    public function getFields(){
      $sql = 'SHOW FULL COLUMNS FROM  `' . $this->table . '`';
      echo $sql;
      $stmt = $this->database->prepare($sql);
      $query = $stmt->execute();
      if(!$query){
        $this->Errors->set(550);
        if(SYSTEM_STATUS == 'development'){
          dbga($stmt->errorInfo());
        }
        return $this->Errors;
      } else {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
      }
    }

    /** fields to build the form in this format:
     *  type, name, class, label, options, value
    **/
    public function form($fields){
      $formFields = array();
      $formFields['entity'] = '<input type="hidden" name="entity" value="' . $this->entity  .'">';



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
        elseif($field['type'] == 'miniswitch') {
          $formField .= '<div class="form-group">';
          $formField .= '<label for="' . $field['name'] . '">' . $field['label'] . (isset($field['required']) ? ' <span class="required">*</span>' : '') . '</label>';

          $formField .= '
                <div class="switch-toggle">
                  <input id="' . $field['name'] . '-1" name="' . $field['name'] . '" type="radio" value="1" ' . ($field['value'] == 1 ? 'checked' : '') . '>
                  <label for="' . $field['name'] . '-1" onclick="">YES</label>

                  <input id="' . $field['name'] . '-2" name="' . $field['name'] . '" type="radio" value="2" ' . ($field['value'] == 2 ? 'checked' : '') . '>
                  <label for="' . $field['name'] . '-2" onclick="">NO</label>


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

  }
