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
    // Used by report finder app
    public function reportList()
    {
        if (httpCheck('get', true)) {
            // Init Response Array
            $response = array();
            // Init Report Model
            $Report = new Report;

            $List = $Report->getReportList();
            if($List){

                foreach($List as $i => $report){
                    // Format date
                    $dataIns = strftime('%Y%m%d', $report->uts_created_at);

                    // Get OC Data
                    $ocData = json_decode($report->api_data);
                    //dbga($ocData);

                    $ocTemaSintetico = ( isset($ocData->oc_cod_tema_sintetico) && !empty($ocData->oc_cod_tema_sintetico) ? $ocData->oc_cod_tema_sintetico : -1);
                    $ocFinanzTotPubNetto = (isset($ocData->oc_finanz_tot_pub_netto) && !empty($ocData->oc_finanz_tot_pub_netto) ? (float)$ocData->oc_finanz_tot_pub_netto : 0);
                    $ocCodCiclo = (isset($ocData->oc_cod_ciclo) && !empty($ocData->oc_cod_ciclo) ? $ocData->oc_cod_ciclo : -1);
                    $ocProgrammiOperativi = -1;

                    if(isset($ocData->programmi) && is_array($ocData->programmi) && !empty($ocData->programmi)){
                        $programmi = array();
                        foreach($ocData->programmi as $programma){
                            $programmi[] = $programma->codice_programma;
                        }
                        $ocProgrammiOperativi = implode(':::', $programmi);
                    }


                    $response[] = array(
                        "uid"                       => $report->id,
                        "titolo"                    => $report->titolo,
                        "dataInserimento"           => $dataIns,
                        "codGiudizioSintetico"      => GS_to_int($report->giudizio_sintetico),
                        "ocCodTemaSintetico"        => $ocTemaSintetico,
                        "ocFinanzTotPubNetto"       => $ocFinanzTotPubNetto,
                        "ocCodProgrammaOperativo"   => $ocProgrammiOperativi,
                        "ocCodCicloProgrammazione"  => $ocCodCiclo,
                        "lat"                       => (float)$report->lat_,
                        "long"                      => (float)$report->lon_
                    );
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

    public function reportDetail($id){
        if (httpCheck('get', true)) {
            // Init Response Array
            $response = array();
            // Init Report Model
            $Report = new Report;
            if(is_numeric($id)){
                $report = $Report->find($id);

                // Format date
                $dataIns = strftime('%Y%m%d', strtotime($report->created_at));

                // Get OC Data
                $ocData = json_decode($report->api_data);
                //dbga($ocData);

                $ocTemaSintetico = ( isset($ocData->oc_cod_tema_sintetico) && !empty($ocData->oc_cod_tema_sintetico) ? $ocData->oc_cod_tema_sintetico : -1);
                $ocFinanzTotPubNetto = (isset($ocData->oc_finanz_tot_pub_netto) && !empty($ocData->oc_finanz_tot_pub_netto) ? (float)$ocData->oc_finanz_tot_pub_netto : 0);
                $ocCodCiclo = (isset($ocData->oc_cod_ciclo) && !empty($ocData->oc_cod_ciclo) ? $ocData->oc_cod_ciclo : -1);
                $ocProgrammiOperativi = -1;

                if(isset($ocData->programmi) && is_array($ocData->programmi) && !empty($ocData->programmi)){
                    $programmi = array();
                    foreach($ocData->programmi as $programma){
                        $programmi[] = $programma->codice_programma;
                    }
                    $ocProgrammiOperativi = implode(':::', $programmi);
                }


                $response = array(
                    "uid"                       => $report->idreport_basic,
                    "titolo"                    => $report->titolo,
                    "dataInserimento"           => $dataIns,
                    "codGiudizioSintetico"      => GS_to_int($report->giudizio_sintetico),
                    "ocCodTemaSintetico"        => $ocTemaSintetico,
                    "ocFinanzTotPubNetto"       => $ocFinanzTotPubNetto,
                    "ocCodProgrammaOperativo"   => $ocProgrammiOperativi,
                    "ocCodCicloProgrammazione"  => $ocCodCiclo,
                    "sintesi"                   => $report->descrizione,
                    "link"                      => APPURL . '/report/view/' . $report->idreport_basic
                );

            }
            else {
                $response = array(
                    'code' => 0,
                    'message' => 'Invalid parameter'
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

    public function reportProgramCycles(){
        if (httpCheck('get', true)) {
            // Init Response Array
            $response = array();
            // Init Report Model
            $Report = new Report;

            $List = $Report->getReportList();
            if ($List) {
                foreach ($List as $i => $report) {

                    $ocData = json_decode($report->api_data);
                    $ocCodCiclo = (isset($ocData->oc_cod_ciclo) && !empty($ocData->oc_cod_ciclo) ? (int)$ocData->oc_cod_ciclo : -1);
                    $ocDescrCiclo = (isset($ocData->oc_descr_ciclo) && !empty($ocData->oc_descr_ciclo) ? substr($ocData->oc_descr_ciclo, -9) : 'non specificato');

                    if(array_search($ocCodCiclo, array_column($response, 'ocCodCicloProgrammazione')) === false){
                        $response[] = array(
                            "ocCodCicloProgrammazione"  => $ocCodCiclo,
                            "descCicloProgrammazione"   => $ocDescrCiclo,
                            "isSelected"                => true,
                            "isActive"                  => true
                        );
                    }

                    usort($response, function($a, $b){
                        return ($a["ocCodCicloProgrammazione"] < $b["ocCodCicloProgrammazione"]) ? -1 : 1;
                    });

                    if( array_search(-1, array_column($response, 'ocCodCicloProgrammazione')) === 0 ){
                        $notspec = $response[0];
                        unset($response[0]);
                        $response[] = $notspec;
                    }
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
    public function reportGS(){
        if (httpCheck('get', true)) {
            // Init Response Array
            $response = array();
            // Init Report Model
            $Report = new Report;

            $gs = $Report->getGS();
            // dbga($gs);
            foreach($gs as $g){
                $response[] = array(
                    "codGiudizioSintetico"  => GS_to_int($g->giudizio_sintetico),
                    "descGiudizioSintetico" => strtolower($g->giudizio_sintetico)
                );
            }
            usort($response, function($a, $b){
                return ($a["codGiudizioSintetico"] < $b["codGiudizioSintetico"]) ? -1 : 1;
            });
            $response[] = array(
                "codGiudizioSintetico"  => 7,
                "descGiudizioSintetico" => "non specificato"
            );

        }
        else {
            $response = array(
                'code' => 0,
                'message' => 'Metodo non valido'
            );
        }
        echo json_encode($response);
    }

    public function reportTemi(){
        if (httpCheck('get', true)) {
            // Init Response Array
            $response = array();
            // Init Report Model
            $Report = new Report;
            $List = $Report->getReportList();
            if ($List) {
                foreach ($List as $i => $report) {
                    $ocData = json_decode($report->api_data);
                    $ocCodTema = (isset($ocData->oc_cod_tema_sintetico) && !empty($ocData->oc_cod_tema_sintetico) ? $ocData->oc_cod_tema_sintetico : -1);
                    $ocDescrTema = (isset($ocData->oc_tema_sintetico) && !empty($ocData->oc_tema_sintetico) ? $ocData->oc_tema_sintetico : 'tema non disponibile');

                    if (array_search($ocCodTema, array_column($response, 'ocCodTemaSintetico')) === false) {
                        $response[] = array(
                            "ocCodTemaSintetico" => $ocCodTema,
                            "descTemaSintetico" => $ocDescrTema,
                        );
                    }
                }

                $na_key = array_search(-1, array_column($response, 'ocCodTemaSintetico'));
                if( $na_key !== false ){
                    $notspec = $response[$na_key];
                    unset($response[$na_key]);
                    $response[] = $notspec;
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

    public function getReportsByProject($project){
        if( httpCheck('get', true) ) {
            $response = array();
            if(!is_null($project)){
                $Report = new Report();
                $Reports = $Report->getReportsByProject($project);
                if(!is_null($Report) && !empty($Reports)){
                    $reports = array();
                    foreach($Reports as $r){
                        $reports[$r->idreport_basic] = $r->created_at;
                    }

                    $response = array(
                        'code' => 200,
                        'message' => 'Ok',
                        'body' => $reports
                    );
                }
                else {
                    $response = array(
                        'code' => 404,
                        'message' => 'No Results'
                    );
                }

            }
            else {
                $response = array(
                    'code' => 1,
                    'message' => 'Parametro non valido'
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

    public function projectReports(){
        if( httpCheck('get') ) {
            $response = array();

            $Report = new Report();
            $Reports = $Report->projectReports();
            if(!is_null($Report) && !empty($Reports)){
                $reports = array();
                foreach($Reports as $r){
                    $reports[$r->oc_project_code] = $r->reports;
                }

                $response = array(
                    'code' => 200,
                    'message' => 'Ok',
                    'body' => $reports
                );
            }
            else {
                $response = array(
                    'code' => 404,
                    'message' => 'No Results'
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
