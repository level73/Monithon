<?php

  class Ajaxctrl extends Ctrl {

    public function oc_api($code){
      $data = @file_get_contents('https://opencoesione.gov.it/it/api/progetti/' . $code . '/?format=json');
      if(!$data) {
        $data['message'] = 'Non trovato';
        $data['code'] = 404;
        $data = json_encode($data);
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

  }
