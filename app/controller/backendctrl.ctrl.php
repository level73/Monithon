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
    public function export_reports(){
        if( hasPermission( $this->User, array(P_APPROVE_REPORT) ) ){
            $time = time();

            $AllReports = $this->Backend->reports();
            $reports = array();
            $reports[] = array_keys((array)($AllReports[0]));
            //remove header for api data;
            unset($reports[0][4]);
            $reports[0][] = 'oc_TitoloProgetto';
            $reports[0][] = 'oc_SintesiProgetto';
            $reports[0][] = 'oc_DataInizioProgetto';
            $reports[0][] = 'oc_FinanzTotPubNetto';
            $reports[0][] = 'oc_CodTemaSintetico';
            $reports[0][] = 'oc_codStatoProgetto';
            $reports[0][] = 'oc_totPagamenti';

            foreach ($AllReports as $report){

                $data = json_decode($report->api_data);
                if(is_object($data)){
                    $report->oc_TitoloProgetto = $data->oc_titolo_progetto ?? '';
                    $report->oc_SintesiProgetto = $data->oc_sintesi_progetto ?? '';
                    $report->oc_DataInizioProgetto = $data->oc_data_inizio_progetto ?? '';
                    $report->oc_FinanzTotPubNetto = isset( $data->oc_finanz_tot_pub_netto ) ? $data->oc_finanz_tot_pub_netto : (isset($data->finanz_totale_pubblico) ? $data->finanz_totale_pubblico : '' );
                    //$report->oc_CodCategoriaSpesa = $data->oc_cod_categoria_spesa;
                    $report->oc_CodTemaSintetico = $data->oc_cod_tema_sintetico ?? '';
                    $report->oc_codStatoProgetto = $data->oc_stato_progetto ?? '';
                    $report->oc_totPagamenti = $data->tot_pagamenti ?? '';
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
    }
}