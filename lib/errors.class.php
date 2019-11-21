<?php

  /**
   * Manages
   *
   * @private $dictionary : sets message to corresponding error code.
   *  0   -> 299 : success messages
   *  300 -> 499 : warning messages
   *  500 -> 699 : error messages
   *  700 -> 999 : notices
   **/

  class Errors {

    public $errors = array();

    private $dictionary = array(
      /** Success **/
      0   => 'Email inviata! Cortesemente, controllate la vostra casella email <strong>con attenzione alla cartella dello spam.</strong>.',
      1   => 'Utente creato correttamente',
      2   => 'Utente modificato correttamente',
      3   => 'Password modificata con successo. Verrai reindirizzato <a href="/user/login">alla pagina di login</a> in 5 secondi.',
      4   => 'Profilo ASOC creato con successo',
      5   => 'Registrazione effettuata! Riceverai una email al tuo indirizzo di registrazione con un link per attivare il tuo profilo. <strong>Controlla anche nella cartella <em>Spam<em>!</strong>',
      20  => 'Oggetto cancellato.',
      21  => 'Report salvato con successo.',
      91  => 'File caricati!',
      92  => 'Link registrati!',
      93  => 'Video salvati!',


      /** Warnings **/
      300 => 'Abbiamo registrato le tue informazioni, ma qualcosa è andato storto con l\'invio della email di attivazione. Per favore, <a href="mailto:'.APPEMAIL.'">contatta la redazione</a>.',
      /** Errors **/
      500 => 'Impossibile connettersi al database',
      501 => 'Impossibile eseguire la query (parametri mancanti o tipo di parametro errato)',
      502 => 'Non ho potuto eseguire la query',
      503 => 'Parametro non permesso, query non eseguita',
      504 => 'Impossibile cancellare l\'oggetto',

      520 => 'Impossibile reinizializzare i metadati',
      550 => 'Impossibile recuperare i campi dell\'entità',
      551 => 'Impossibile creare il record',
      552 => 'Mancano dei valori in campi obbligatori (*). Dati non salvati. ',
      580 => 'Impossibile inviare l\'email a causa di problemi tecnici',

      600 => 'L\'email non può essere vuota',
      601 => 'Usare un indirizzo email valido',
      602 => 'La password non può essere vuota',
      603 => 'Impossibile creare la sessione utente',
      604 => 'Impossibile recuperare il profilo utente',
      605 => 'Impossibile eseguire la query. (session.model.php, 113)',
      606 => 'Password errata',
      607 => 'Nessun account (attivo) con quella email',
      608 => 'Impossibile recuperare la lista dei permessi',
      609 => 'Le password non coincidono',
      610 => 'Questa email è già in uso',
      611 => 'Impossibile reinizializzare la password',
      612 => 'problemi durante il salvataggio dei dati del team Asoc',


      650 => 'Errore nel caricamento del file. File non salvato.',
      651 => 'Tipo di file non permesso. File non salvato.',
      652 => 'Errore nel salvataggio del file sul server. File non salvato.',

      /** Notices **/
    );

    public function __construct(){
      if(!isset($this->errors)){
        $this->errors = array();
      }
      else {
        return $this->errors;
      }
    }

    public function set($code){
      $this->errors[$code] = $this->dictionary[$code];
    }

    public function noErrors(){
      if( max(array_keys($this->errors)) < 300){
        return true;
      }
      else {
        return false;
      }
    }

    public function display(){

      foreach($this->errors as $code => $message){

        if($code < 300) {
          /** success **/
          echo '<div class="alert alert-success"><i class="far fa-tick"></i> ' . $message . ' [' . $code . ']</div>';
        }
        else if($code < 500 && $code > 299){
          /** warning **/
          echo '<div class="alert alert-warning"><i class="far fa-exclamation-triangle"></i> ' . $message . ' [' . $code . ']</div>';
        }
        else if($code < 700 && $code > 499){
          /** error **/
          echo '<div class="alert alert-danger"><i class="far fa-times"></i> ' . $message . ' [' . $code . ']</div>';
        }
        else if($code < 1000 && $code > 699){
          /** notice **/
          echo '<div class="alert alert-notice"><i class="far fa-exclamation-circle"></i> ' . $message . ' [' . $code . ']</div>';
        }
      }

    }

  }
