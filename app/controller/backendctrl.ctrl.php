<?php

class BackendCtrl extends Ctrl
{
    protected $Auth;
    protected $User;
    public    $Errors;



    public function __construct($model, $controller, $action){
        parent::__construct($model, $controller, $action);
        $this->Errors = new Errors;
        $this->Auth = new Auth;

        $logged = false;
        if($this->Auth->isLoggedIn()){
            $this->User = $this->Auth->getProfile();
            $this->set('user', $this->User);
            $logged = true;
        }
        $this->set('logged', $logged);
    }

    public function index(){
        if( hasPermission( $this->User, array(P_APPROVE_REPORT) ) ){
            $this->set('title', "Data Export Backend");
        }
    }

    public function explore_json($report_id){
        if( hasPermission( $this->User, array(P_APPROVE_REPORT) ) ){
            $Report = new Report();
            $report = $Report->find($report_id);

            $data = $report->api_data;
            $data = json_decode($data);
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    }
    public function export_subjects(){
        if( $this->Auth->isLoggedIn() && hasPermission( $this->User, array(P_APPROVE_REPORT) ) ) {
            $time = time();

            $AllReports = $this->Backend->reports();
            $subjects = array();
            $headers = array(
                'idreport',
                'cod_locale_progetto',
                'oc_url',
                'url_soggetto',
                'denominazione',
                'codice_fiscale',
                'indirizzo',
                'cap',
                'ruoli'
            );
            $subjects[] = $headers;
            
            foreach($AllReports as $report){
                $single_sub = array();
                if(!empty($report->api_data)){
                    $data = json_decode($report->api_data);

                    if( !is_null($data) && isset($data->soggetti) && !empty($data->soggetti) ){
                        // echo $report->idreport_basic . " >> COUNT SUBJECTS:: " . count($data->soggetti) . "<br />";
                        foreach($data->soggetti as $soggetto){

                            $single_sub['idreport'] = $report->idreport_basic;
                            $single_sub['cod_locale_progetto'] = $report->oc_project_code;
                            $single_sub['oc_url'] = $report->id_open_coesione;
                            $single_sub['url_soggetto'] = $soggetto->url ?? '';
                            $single_sub['denominazione'] = $soggetto->denominazione;
                            $single_sub['codice_fiscale'] = $soggetto->codice_fiscale ?? '';
                            $single_sub['indirizzo'] = $soggetto->indirizzo ?? '';
                            $single_sub['cap'] = $soggetto->cap ?? '';
                            $single_sub['ruoli'] = implode('::', $soggetto->ruoli);

                            $subjects[] = $single_sub;
                        }
                    }
                    else {
                        $single_sub['idreport'] = $report->idreport_basic;
                        $single_sub['cod_locale_progetto'] = $report->oc_project_code;
                        $single_sub['oc_url'] = $report->id_open_coesione;
                        $single_sub['url_soggetto'] = 'N.A.';
                        $single_sub['denominazione'] = 'N.A.';
                        $single_sub['codice_fiscale'] = 'N.A.';
                        $single_sub['indirizzo'] = 'N.A.';
                        $single_sub['cap'] = 'N.A.';
                        $single_sub['ruoli'] = 'N.A.';

                        $subjects[] = $single_sub;
                    }
                }
                else {
                    $single_sub['idreport'] = $report->idreport_basic;
                    $single_sub['cod_locale_progetto'] = $report->oc_project_code;
                    $single_sub['oc_url'] = $report->id_open_coesione;
                    $single_sub['url_soggetto'] = 'N.A.';
                    $single_sub['denominazione'] = 'N.A.';
                    $single_sub['codice_fiscale'] = 'N.A.';
                    $single_sub['indirizzo'] = 'N.A.';
                    $single_sub['cap'] = 'N.A.';
                    $single_sub['ruoli'] = 'N.A.';

                    $subjects[] = $single_sub;
                }

                //echo "<br /> ------------------- <br />";

            }
            // dbga($subjects);


            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="subjects_export_' . $time . '.csv";');

            $fp = fopen('php://output', 'w+');

            foreach ($subjects as $subject) {
                if(is_array($subject)){
                    fputcsv($fp, $subject, ',', '"');
                }
                else {
                    var_dump($subject);
                }
            }

            $csv_contents = stream_get_contents($fp); // Fetch the contents of our CSV
            fclose($fp); // Close our pointer and free up memory and /tmp space

            // Handle/Output your final sanitised CSV contents
            echo $csv_contents;

        }
        else {
            header('Location: /user/login');
        }

    }
    public function export_reports(){
        if( $this->Auth->isLoggedIn() && hasPermission( $this->User, array(P_APPROVE_REPORT) ) ){
            $time = time();

            $AllReports = $this->Backend->reports();
            $reports = array();
            $reports[] = array_keys((array)($AllReports[0]));
            //remove header for api data;
            unset($reports[0][4]);
            $reports[0][] = 'oc_TitoloProgetto';
            $reports[0][] = 'oc_SintesiProgetto';
            $reports[0][] = 'oc_DataInizioProgetto';
            $reports[0][] = 'oc_programmi_operativi';
            $reports[0][] = 'oc_FinanzTotPubNetto';
            $reports[0][] = 'oc_CodTemaSintetico';
            $reports[0][] = 'oc_codStatoProgetto';
            $reports[0][] = 'oc_totPagamenti';
            $reports[0][] = 'oc_ciclo_di_programmazione';

            foreach ($AllReports as $report){

                $data = json_decode($report->api_data);
                if(is_object($data)){
                    $report->oc_TitoloProgetto = $data->oc_titolo_progetto ?? '';
                    $report->oc_SintesiProgetto = $data->oc_sintesi_progetto ?? '';
                    $report->oc_DataInizioProgetto = $data->oc_data_inizio_progetto ?? '';

                    $report->oc_programmi_operativi = '';
                    if( isset($data->programmi) && !empty($data->programmi)) {
                        $progList = array();
                        foreach ($data->programmi as $programma) {
                            $progList[] = $programma->oc_descrizione_programma;
                        }
                        $report->oc_programmi_operativi = implode('::', $progList);
                    }
                    elseif(isset($data->oc_descrizione_programma) && !empty($data->oc_descrizione_programma)){
                        $report->oc_programmi_operativi = $data->oc_descrizione_programma;
                    }


                    $report->oc_FinanzTotPubNetto = isset( $data->oc_finanz_tot_pub_netto ) ? $data->oc_finanz_tot_pub_netto : (isset($data->finanz_totale_pubblico) ? $data->finanz_totale_pubblico : '' );
                    //$report->oc_CodCategoriaSpesa = $data->oc_cod_categoria_spesa;
                    $report->oc_CodTemaSintetico = $data->oc_cod_tema_sintetico ?? '';
                    $report->oc_codStatoProgetto = $data->oc_stato_progetto ?? '';
                    $report->oc_totPagamenti = $data->tot_pagamenti ?? '';
                    $report->ciclo_di_programmazione = $data->oc_descr_ciclo ?? '';
                }
                unset($report->api_data);
                $reports[] = (array)$report;

            }

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="report_export_' . $time . '.csv";');

            $fp = fopen('php://output', 'w+');

            foreach($reports as $report){
                //var_dump($report); die();
                fputcsv($fp, $report, ',', '"');

            }

            $csv_contents = stream_get_contents($fp); // Fetch the contents of our CSV
            fclose($fp); // Close our pointer and free up memory and /tmp space

            // Handle/Output your final sanitised CSV contents

            echo $csv_contents;



        }
        else {
            header('Location: /user/login');
        }
    }

    public function genderdata(){
        $time = time();

        $AllReports = $this->Backend->GenderEqualityReports();
        $reports = array();
        $reports[] = array_keys((array)($AllReports[0]));

        foreach ($AllReports as $report){
            $report->parita_di_genere = ($report->parita_di_genere == 1 ? 'SI' : 'NO');
            $report->gender_objectives = cycleAnswers($report->gender_objectives);
            $report->gender_language = cycleAnswers($report->gender_language);
            $report->gender_finance = cycleAnswers($report->gender_finance);
            $report->gender_indicators = cycleAnswers($report->gender_indicators);

            $reports[] = (array)$report;
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="report_export_' . $time . '.csv";');

        $fp = fopen('php://output', 'w+');

        foreach($reports as $report){
            fputcsv($fp, $report, ',', '"');
        }

        // Fetch the contents of our CSV
        $csv_contents = stream_get_contents($fp);
        // Close our pointer and free up memory and /tmp space
        fclose($fp);

        // Handle/Output your final sanitised CSV contents
        echo $csv_contents;

    }
}