<?php

  class Ajaxctrl extends Ctrl {



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


    public function programma_operativo($code, $mode = 'json'){
      $PO = new Meta('programma_operativo', true);
      $po = $PO->findLexiconEntry('oc_codice_programma', $code);
      if($mode == 'json'){
        echo json_encode($po);
      }
    }

    public function sottotemi($code, $mode='json'){
      $Sottotemi = new Meta('progetti_sottotemi_20190831', true, true);
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
            if (hasPermission($User, array(P_EDIT_REPORT, P_ASSIGN_REPORT, P_BOUNCE_REPORT, P_COMMENT_REPORT, P_MANAGE_REPORT_CARD))) {
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

  }
