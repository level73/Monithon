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

  }
