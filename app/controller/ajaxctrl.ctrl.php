<?php

  class Ajaxctrl extends Ctrl {

    public function oc_api($code){

      $data = file_get_contents('https://opencoesione.gov.it/it/api/progetti/' . $code . '/?format=json');
      echo $data;
    }

  }
