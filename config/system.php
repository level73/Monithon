<?php
/** Set Debug Mode **/
define('DEBUG', true);
/** System status - influences error reporting **/
define('SYSTEM_STATUS', 'development');

/** Define Entities **/

/** Set default controller and route **/
define('DEFAULT_CONTROLLER', 'main');
define('DEFAULT_METHOD', 'index');

/** Paths **/
define('DIR_REPO', $_SERVER['DOCUMENT_ROOT'] . '/public/resources/' );
define('URL_REPO', '/public/resources/');

/** Permissions **/
define('P_CREATE_USER', 1);
define('P_ASSIGN_PERMISSIONS', 2);
define('P_CREATE_REPORT', 3);
define('P_ASSIGN_REPORT', 4);
define('P_EDIT_REPORT', 5);
define('P_COMMENT_REPORT', 6);
define('P_APPROVE_REPORT', 7);
define('P_BOUNCE_REPORT', 8);
define('P_MANAGE_REPORT_CARD', 9);

/** Entity Statuses **/
define('DRAFT', 1);
define('PENDING_REVIEW', 3);
define('IN_REVIEW', 5);
define('PUBLISHED', 7);

/** Entities **/
define('T_USER',        1);
define('T_REP_BASIC',   2);

/** Default User Role - Change when ASOC starts
 *  ASOC = Role 4
 *  Reporter = Role 3
 */
define('DEFAULT_ROLE', 3);
/** Routes **/
$routes = array(
  0     => "/main",
  1     => "/report/create"
);

const SDA_LABELS = array(
    1 => "Appena avviato",
    2 => "Mai partito",
    3 => "In corso senza particolari intoppi",
    4 => "In corso con problemi di realizzazione",
    5 => "Bloccato",
    6 => "Concluso",
    7 => "Non è stato possibile verificare l’avanzamento",
);

const GDE_LABELS = array(
    "labels_opt_1" => array(
        1 =>  array('main' => "Potenzialmente efficace", "sub" => "Il progetto sembra utile e complessivamente ben progettato, anche se potenziali rischi possono essere individuati"),
        2 =>  array('main' => "Potenzialmente efficace ma con rischi sostanziali", "sub" => "Il progetto sembra utile, anche se ci sono debolezze o rischi importanti che ne possono pregiudicare l’efficacia"),
        3 =>  array('main' => "Inutile o dannoso", "sub" => "Non andava finanziato: non serve o può avere conseguenze negative, oppure la progettazione è largamente insufficiente per raggiungere gli obiettivi"),
        4 =>  array('main' => "Non è stato possibile valutare", "sub" => "Le informazioni disponibili non sono sufficienti; i soggetti coinvolti non ci hanno risposto")
    ),
    "labels_opt_2" => array(
        1 =>  array('main' => "Potenzialmente efficace", "sub" => "Il progetto sembra utile e il suo sviluppo incoraggiante, anche se potenziali rischi possono essere individuati"),
        2 =>  array('main' => "Potenzialmente efficace ma con problemi", "sub" => "Il progetto sembra complessivamente utile ma ci sono debolezze o rischi importanti che ne possono pregiudicare l’efficacia, non legati a ritardi o problemi realizzativi"),
        3 =>  array('main' => "Intervento inutile o dannoso", "sub" => "Non andava finanziato: non serve o può avere conseguenze negative, oppure la realizzazione presenta problemi che rendono impossibile raggiungere gli obiettivi"),
        4 =>  array('main' => "Non è stato possibile valutare", "sub" => "Le informazioni disponibili non sono sufficienti; i soggetti coinvolti non ci hanno risposto")
    ),
    "labels_opt_3" => array(
        1 =>  array('main' => "Intervento efficace", "sub" => "Gli aspetti positivi prevalgono ed è giudicato complessivamente efficace dal punto di vista dell'utente finale"),
        2 =>  array('main' => "Intervento utile ma presenta problemi", "sub" => "Ha avuto alcuni risultati positivi ed è tutto sommato utile, anche se presenta aspetti negativi significativi"),
        3 =>  array('main' => "Intervento inefficace o dannoso", "sub" => "Era meglio non finanziarlo perché non ha provocato alcun effetto o ha provocato effetti negativi"),
        4 =>  array('main' => "Non è stato possibile valutare", "sub" => "Es. il progetto non ha ancora prodotto risultati valutabili")
    )
);

const SDAI_LABELS = array(
    1 => "Non avviato",
    2 => "In avvio di progettazione - Studio di fattibilità",
    3 => "In corso di progettazione - Progettazione esecutiva",
    4 => "In affidamento - Affidamento gara in corso",
    5 => "In esecuzione - Lavori iniziati",
    6 => "Eseguito - Conclusa la fase di esecuzione",


);
