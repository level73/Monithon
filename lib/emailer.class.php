<?php

  /* Simple Email class to send out emails */
  class Emailer {

    public $headers = array();

    public function __construct(){
      // To send HTML mail, the Content-type header must be set
      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=iso-8859-1';
      // Additional headers
      $headers[] = 'From: ' . APPNAME . ' <' . APPEMAIL . '>';

      $this->headers = implode("\r\n", $headers);

    }

    public function send($to, $subject, $message){
      return mail($to, APPNAME . ' | ' . $subject, $message, $this->headers);      
    }

  }
