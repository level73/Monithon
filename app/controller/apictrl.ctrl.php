<?php

  class ApiCtrl extends Ctrl {

    public function __construct($model, $controller, $action){
      parent::__construct($model, $controller, $action);

      $this->Errors = new Errors;
      // get allowed origins
    //  $origins = $this->Api->all();
      // Produce headers for allowed origins

    //  foreach($origins as $origin){
    //    header('Access-Control-Allow-Origin: ' . $origin->registrar);
    //  }
      header('Content-type:application/json;charset=UTF-8');
      mb_internal_encoding('UTF-8');
    }

    public function getReport($report_id){
      if( httpCheck('get', true) ){
        $response = array();
        if(is_numeric($report_id)){
          $Report = new Report;
          $report = $Report->find($report_id);
          if(!empty($report)){
            // Cycle Status Values
            $status = null;
            switch($report->status){
              case 1:
                $status = 'Bozza';
                break;
              case 3:
                $status = 'In attesa di revisione';
                break;
              case 5:
                $status = 'In revisione';
                break;
              case 7:
                $status = 'Pubblicato';
                break;
            }

            $response['code'] = 200;
            $response['message'] = 'Ok';
            $response['body'] = array(
              'report_id' => $report_id,
              'report_url' => APPURL . '/report/' . $report_id,
              'report_title' => $report->titolo,
              'report_assessment' => $report->giudizio_sintetico,
              'report_status' => $status
            );
          }
          else {
            $response['code'] = 404;
            $response['message'] = 'Report non trovato.';
          }
        }
      }
      else {
        $response = array(
          'code' => 0,
          'message' => 'Metodo non valido'
        );
      }

      echo json_encode($response);

    }
  }
