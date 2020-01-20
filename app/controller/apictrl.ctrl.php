<?php

  class ApiCtrl extends Ctrl {


    public function getReport($report_id){
      if( httpCheck('get', true) ){
        $response = array();
        if(is_numeric($report_id)){
          $Report = new Report;
          $report = $Report->find($report_id);
          $response['code'] = 200;
          $response['message'] = 'Ok';
          $response['body'] = array(
            'report_id' => $report_id,
            'report_url' => APPURL . '/report/' . $report_id,
            'report_title' => $report->titolo,
            'report_assessment' => $report->giudizio_sintetico,
            'report_status' => $report->status
          );
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
