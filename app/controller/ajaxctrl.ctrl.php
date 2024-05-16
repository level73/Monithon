<?php

  class Ajaxctrl extends Ctrl {

    protected $Auth;
    protected $tbl_sottotemi = 'progetti_sottotemi_20230831';

    protected $opentenderurl = "https://open-api.opentender.eu/search/";


      protected $headers = [
          'x-api-key:' . OPENTENDER_XAPIKEY,
          'Accept:application/json'
      ];

      public function getTenderById(){
          $tender = $_GET['tender'];
          $url = $this->opentenderurl . 'tender_by_id?tender_id=' . $tender;

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
          $response = curl_exec($ch);

          // Close cURL
          curl_close ($ch);

          echo $response;


      }

    public function oc_api($code){
      $auth = base64_encode(OC_API_USERNAME . ":" . OC_API_PASSWORD);
      $context = stream_context_create([
          "http" => [
              "header" => "Authorization: Basic $auth"
          ]
      ]);


      $data = @file_get_contents('https://opencoesione.gov.it/it/api/progetti/' . $code . '/?format=json', false, $context);
      if(!$data){
        $r['message'] = 'Non trovato';
        $r['code'] = '404';
        $data = json_encode($r);
      }
      echo $data;
    }

    public function check_project(){
        $code = $_GET['code'];
        $Report = new Report();
        $reports = $Report->checkProject($code);
        echo json_encode($reports);

    }


    public function programma_operativo($code, $mode = 'json'){
      $PO = new Meta('programma_operativo', true);
      $po = $PO->findLexiconEntry('oc_codice_programma', $code);
      if($mode == 'json'){
        echo json_encode($po);
      }
    }

    public function sottotemi($code, $mode='json'){
      $Sottotemi = new Meta($this->tbl_sottotemi, true, true);
      $sottotema = $Sottotemi->findLexiconEntry('COD_LOCALE_PROGETTO', $code);
      if($mode == 'json'){
        echo json_encode($sottotema);
      }
    }

    public function beni_confiscati($code){
      $BeniConfiscati = new Meta('beni_confiscati', true);
      $bene = $BeniConfiscati->findLexiconEntry('COD_LOCALE_PROGETTO', $code);
      if($bene){
        echo json_encode(array('code' => 200, 'message' => 'bene confiscato', 'COD_LOCALE_PROGETTO' => $code));
      }
      else {
        echo json_encode(array('code' => 404, 'message' => 'non trovato', 'COD_LOCALE_PROGETTO' => $code));
      }
    }

    public function delete_repo_ref($type, $id){
        $Auth = new Auth;
        if($Auth->isLoggedIn()) {
            $User = $Auth->getProfile();
            $Repo = new Repo;
            if (
                hasPermission($User, array(P_EDIT_REPORT, P_ASSIGN_REPORT, P_BOUNCE_REPORT, P_COMMENT_REPORT, P_MANAGE_REPORT_CARD))
                ||
                $Repo->checkOwner($id, $type, $User)
            ) {
                $Meta = new Meta($type);
                $id = (int)$id;
                if ($Meta->unsetRepo($type, $id)) {
                    $d = $Meta->unsetRepoReference(T_REP_BASIC, $type, $id);
                    if ($d) {
                        $response = array(
                            'code' => 200,
                            'msg' => 'Elemento rimosso con successo.',

                        );
                    } else {
                        $response = array(
                            'code' => 500,
                            'msg' => 'Impossibile rimuovere questo elemento.'
                        );
                    }
                } else {
                    $response = array(
                        'code' => 500,
                        'msg' => 'Impossibile rimuovere questo elemento.'
                    );
                }

            } else {
                $response = array('code' => 403, 'msg' => 'Non Autorizzato');
            }
            echo json_encode($response);
        }
    }

    public function map_reports(){
        $Report = new Report();
        $reports = $Report->getReports();
        echo json_encode($reports);
    }

    public function profile_map_reports($profile){
        $Report = new Report();
        $reports = $Report->findBy(array('created_by' => $profile, 'status' => 7));
        echo json_encode($reports);

    }

    public function change_comment_status(){
        $this->Auth = new Auth();
        if(httpCheck('POST') && $this->Auth->isLoggedIn()) {

            $Comment = new Comment();

            $data = $_POST;

            $id = filter_var( $data['id'], FILTER_SANITIZE_NUMBER_INT);
            $status = filter_var( $data['status'], FILTER_SANITIZE_NUMBER_INT);

            $r = $Comment->update($id, array('status' => $status));
            $response = array();
            if($r){
                $response['code'] = 200;
                $response['message'] = 'Status del commento cambiato';
            }
            else {
                $response['code'] = 500;
                $response['message'] = 'Impossibile cambiare status al commento con ID ' . $id;
            }
            echo json_encode($response);
        }
    }
  }
