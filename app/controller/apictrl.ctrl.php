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
                    if($ocTemaSintetico == -1 && (isset($ocData->oc_tema_sintetico) && !empty($ocData->oc_tema_sintetico))){
                        $ocTemaSintetico = themeToCode($ocData->oc_tema_sintetico);
                    }
                    $ocFinanzTotPubNetto = (isset($ocData->oc_finanz_tot_pub_netto) && !empty($ocData->oc_finanz_tot_pub_netto) ? (float)$ocData->oc_finanz_tot_pub_netto : 0);
                    if($ocFinanzTotPubNetto === 0){
                        $ocFinanzTotPubNetto = (isset($ocData->finanz_totale_pubblico) && !empty($ocData->finanz_totale_pubblico) ? (float)$ocData->finanz_totale_pubblico : 0);
                    }
                    $ocCodCiclo = (isset($ocData->oc_cod_ciclo) && !empty($ocData->oc_cod_ciclo) ? $ocData->oc_cod_ciclo : -1);
                    if($ocCodCiclo == -1 && (isset($ocData->oc_descr_ciclo) && !empty($ocData->oc_descr_ciclo))){
                        $cycle = substr($ocData->oc_descr_ciclo, -9);
                        if($cycle == '2007-2013'){
                            $ocCodCiclo = 1;
                        }
                        else if($cycle == '2014-2020'){
                            $ocCodCiclo = 2;
                        }
                        else {
                            $ocCodCiclo = -1;
                        }
                    }

                    $ocProgrammiOperativi = -1;

                    if(isset($ocData->programmi) && is_array($ocData->programmi) && !empty($ocData->programmi)){
                        $programmi = array();
                        foreach($ocData->programmi as $programma){
                            $programmi[] = $programma->codice_programma;
                        }
                        $ocProgrammiOperativi = implode(':::', $programmi);
                    }


                    $response[] = array(
                        "uid"                       => ISO2 . $report->id,
                        "titolo"                    => $report->titolo,
                        "dataInserimento"           => $dataIns,
                        "codGiudizioSintetico"      => $report->gs,
                        //"codGiudizioSintetico"      => GS_to_int($report->giudizio_sintetico),
                        //"codGiudizioDiEfficacia"    => $report->gs,
                        "codStatoDiAvanzamento"     => $report->stato_di_avanzamento,
                        "ocCodTemaSintetico"        => $ocTemaSintetico,
                        "ocFinanzTotPubNetto"       => $ocFinanzTotPubNetto,
                        "curr"                      => CURRENCY_STR,
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

            if(!is_numeric($id) && is_string($id)){
                // Split Id
                $instance = strtolower(substr($id, 0, 2));
                $id = substr($id, 2);
            }

            if(is_numeric($id)){
                $report = $Report->find($id);

                // Format date
                $dataIns = strftime('%Y%m%d', strtotime($report->created_at));

                // Get OC Data
                $ocData = json_decode($report->api_data);


                $ocTemaSintetico = ( isset($ocData->oc_cod_tema_sintetico) && !empty($ocData->oc_cod_tema_sintetico) ? $ocData->oc_cod_tema_sintetico : -1);
                if($ocTemaSintetico == -1 && (isset($ocData->oc_tema_sintetico) && !empty($ocData->oc_tema_sintetico))){
                    $ocTemaSintetico = themeToCode($ocData->oc_tema_sintetico);
                }
                $ocFinanzTotPubNetto = (isset($ocData->oc_finanz_tot_pub_netto) && !empty($ocData->oc_finanz_tot_pub_netto) ? (float)$ocData->oc_finanz_tot_pub_netto : 0);

                if($ocFinanzTotPubNetto === 0){
                    $ocFinanzTotPubNetto = (isset($ocData->finanz_totale_pubblico) && !empty($ocData->finanz_totale_pubblico) ? (float)$ocData->finanz_totale_pubblico : 0);
                }


                $ocCodCiclo = (isset($ocData->oc_cod_ciclo) && !empty($ocData->oc_cod_ciclo) ? $ocData->oc_cod_ciclo : -1);
                if($ocCodCiclo == -1 && (isset($ocData->oc_descr_ciclo) && !empty($ocData->oc_descr_ciclo))){
                    $cycle = substr($ocData->oc_descr_ciclo, -9);
                    if($cycle == '2007-2013'){
                        $ocCodCiclo = 1;
                    }
                    else if($cycle == '2014-2020'){
                        $ocCodCiclo = 2;
                    }
                    else {
                        $ocCodCiclo = -1;
                    }
                }
                $ocProgrammiOperativi = -1;

                if(isset($ocData->programmi) && is_array($ocData->programmi) && !empty($ocData->programmi)){
                    $programmi = array();
                    foreach($ocData->programmi as $programma){
                        $programmi[] = $programma->codice_programma;
                    }
                    $ocProgrammiOperativi = implode(':::', $programmi);
                }
                // check if obiettivi is not empty, check fr descrizione in that case
                $desc = (!empty($report->obiettivi) ? $report->obiettivi : $report->descrizione);
                $response = array(
                    "uid"                       => ISO2 . $report->idreport_basic,
                    "titolo"                    => $report->titolo,
                    "dataInserimento"           => $dataIns,
                    "codGiudizioSintetico"      => $report->gs,
                    //"codGiudizioSintetico"      => GS_to_int($report->giudizio_sintetico),
                    "codStatoDiAvanzamento"     => $report->stato_di_avanzamento,
                    "ocCodTemaSintetico"        => $ocTemaSintetico,
                    "ocFinanzTotPubNetto"       => $ocFinanzTotPubNetto,
                    "curr"                      => CURRENCY_STR,
                    "ocCodProgrammaOperativo"   => $ocProgrammiOperativi,
                    "ocCodCicloProgrammazione"  => $ocCodCiclo,
                    "sintesi"                   => apiHellip($desc),
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
                $response = array_values($response);
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
           /* $na_key = array_search(7, array_column($response, 'codGiudizioSintetico'));
            $response[$na_key] = array(
                "codGiudizioSintetico"  => 7,
                "descGiudizioSintetico" => "non specificato"
            );
            */
        }
        else {
            $response = array(
                'code' => 0,
                'message' => 'Metodo non valido'
            );
        }
        echo json_encode($response);
    }

    // use by report finder - new GdE entries
    public function reportGdE(){
        if (httpCheck('get', true)) {
            // Init Response Array
            $response = array(
                array( "codGiudizioSintetico" => 1 ),
                array( "codGiudizioSintetico" => 2 ),
                array( "codGiudizioSintetico" => 3 ),
                array( "codGiudizioSintetico" => 4 ),
            );

        }
        echo json_encode($response);
    }

    public function reportSdA(){
        if (httpCheck('get', true)) {
            // Init Response Array
            $response = array(
                1 => "Appena avviato",
                2 => "Mai partito",
                3 => "In corso senza particolari intoppi",
                4 => "In corso con problemi",
                5 => "Bloccato",
                6 => "Concluso",
                7 => "Impossibile verificare"
            );

        }
        echo json_encode($response);
    }

    public function reportThemes(){
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

                usort($response, function($a, $b){
                    return ($a["ocCodTemaSintetico"] < $b["ocCodTemaSintetico"]) ? -1 : 1;
                });

                $na_key = array_search(-1, array_column($response, 'ocCodTemaSintetico'));
                if( $na_key !== false ){
                    $notspec = $response[$na_key];
                    unset($response[$na_key]);
                    $response[] = $notspec;
                }

                $response = array_values($response);
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

    public function reportOperativeProgrammes(){
        if (httpCheck('get', true)) {
            // Init Response Array
            $response = array();
            // Init Report Model
            $Report = new Report;
            $List = $Report->getReportList();

            if ($List) {
                foreach ($List as $i => $report) {
                    $ocData = json_decode($report->api_data);
                    $ocProgrammiOperativi = -1;

                    if(isset($ocData->programmi) && is_array($ocData->programmi) && !empty($ocData->programmi)){
                        $programmi = array();
                        $descProgramma = array();
                        foreach($ocData->programmi as $programma){
                            $programmi[] = $programma->codice_programma;
                            $descProgramma[] = $programma->oc_descrizione_programma;
                        }

                        $ocProgrammiOperativi = implode(':::', $programmi);
                        $ocDescProgrammiOperativi = implode(':::', $descProgramma);

                        if (array_search($ocProgrammiOperativi, array_column($response, 'ocCodProgrammaOperativo')) === false) {
                            $response[] = array(
                                "ocCodProgrammaOperativo"   => $ocProgrammiOperativi,
                                "descProgrammaOperativo"    => $ocDescProgrammiOperativi,
                            );
                        }
                    }


                }
                $na_key = array_search(-1, array_column($response, 'ocCodProgrammaOperativo'));
                if( $na_key === false ){
                    $response[] = array(
                        "ocCodProgrammaOperativo"   => "-1",
                        "descProgrammaOperativo"    => "Non disponibile",
                    );
                }

                $response = array_values($response);
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

    /** OC API
      * Codice Locale Progetto (oc_project_code)
        URL CLP Opencoesione
        URL Report
        ID Report
        Tipo Utenza (ASOC, ASOC EXP, Uni, Civil Society)
        Team ID ASOC (se presente aggiungere)
        Data monitoraggio (YYYYMMDD) (created_at)
        Giudizio Sintetico (codice numerico)
        Stato Avanzamento (codice numerico)
     */

    public function oc_report_list(){
        if( httpCheck('get') ) {
            $response = array();

            $Report = new Report();
            $reports = $Report->ocProjectReports();
            if($reports){
                $response['code'] = 200;
                $response['message'] = 'Ok';
                $response['count'] = count($reports);
                $response['body'] = array();
                foreach($reports as $i => $report){
                    // Format report URL
                    $report_url = APPURL . '/report/view/' . $report->id_report_monithon;

                    if( ($report->role > 3 && $report->role < 11) || $report->role == 3 && !is_null($report->asoc_team_id) ){
                        $creator_role = 'ASOC';
                    }
                    elseif($report->role == 11){
                        $creator_role = 'Studente Universitario';
                    }
                    else {
                        $creator_role = 'Società Civile';
                    }

                    $response['body'][$i]['codice_locale_progetto'] = $report->codice_locale_progetto;
                    $response['body'][$i]['url_opencoesione'] = (strpos($report->url_opencoesione, 'http') === 0 ? $report->url_opencoesione : 'https://' . $report->url_opencoesione);
                    $response['body'][$i]['id_report_monithon'] = $report->id_report_monithon;
                    $response['body'][$i]['url_monithon'] = $report_url;
                    $response['body'][$i]['data_report_monithon'] = $report->data_report_monithon;
                    $response['body'][$i]['giudizio_di_efficacia'] = $report->giudizio_di_efficacia;
                    $response['body'][$i]['stato_di_avanzamento_al_monitoraggio'] = $report->stato_di_avanzamento_al_monitoraggio;
                   // $response['body'][$i]['tipo_utente_creatore'] = $creator_role;
                   // $response['body'][$i]['asoc_team_id'] = $report->asoc_team_id;

                }
            }
            else {
                $response['code'] = 500;
                $response['message'] = 'Errore nel fetch della risorsa';
            }
        }
        else {
            $response['code'] = 400;
            $response['message'] = 'Non autorizzato';
        }

        echo json_encode($response);
    }


      public function openCUP($cup){

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_VERBOSE, true);
          curl_setopt($ch, CURLOPT_URL, "https://api.sogei.it/rgs/opencup/o/extServiceApi/v1/opendataes/cup/" . $cup);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



          curl_setopt($ch, CURLOPT_HTTPHEADER, OPENCUP_API_HEADERS);
          $response = curl_exec($ch);

          // Close cURL
          curl_close ($ch);

          echo $response;
      }

  }
