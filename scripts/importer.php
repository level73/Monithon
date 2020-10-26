<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DS', '/');

// Load configuration files
require(ROOT . DS . 'config' . DS . 'local.php');
require(ROOT . DS . 'config' . DS . 'system.php');

// Load Core Classes & System functions
require(ROOT . DS . 'lib' . DS . 'functions.php');
require(ROOT . DS . 'lib' . DS . 'errors.class.php');
require(ROOT . DS . 'lib' . DS . 'model.class.php');
require(ROOT . DS . 'lib' . DS . 'session.class.php');

// Load Models
require(ROOT . DS . 'app' . DS . 'model' . DS . 'user.mdl.php');
require(ROOT . DS . 'app' . DS . 'model' . DS . 'asoc.mdl.php');
require(ROOT . DS . 'app' . DS . 'model' . DS . 'report.mdl.php');

?>

<!doctype html>
<html lang="it">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Load Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,900" rel="stylesheet">
    <script src="https://kit.fontawesome.com/faba35a8a9.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/public/css/vendor/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="/public/css/vendor/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main.css">


    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="72x72" href="/public/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/public/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/public/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/public/images/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/public/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <title>Importer - <?php echo APPNAME; ?></title>

</head>
<body>
<div class="container">
<?php

// Main CSV File - load data and create handler
$csv_file = 'dataset_monithon.csv';
$csv_handle = fopen($csv_file, "r");

if($csv_handle){
    $row = 0;
    $keys = array();
    echo "<h2>Starting - Row 0</h2><br />";
    while(($data = fgetcsv($csv_handle, 0, ",")) !== FALSE){
        if($row == 0){
            $keys = $data;
        }
        else {
            echo "<h3>Row ".$row."</h3>";
            // set keys as values from first row
            $data = array_combine($keys, $data);

            dbga($data);

            // Set up auth
            $User = new User();
            $auth_fields = array('email','secondary_email','password','username','bio','avatar','city','twitter','role','recover','active','privacy','created_at','modified_at');

            $auth = array(); // auth data
            $auths = array(); // list of auth ids
            foreach($auth_fields as $field){
                $auth[$field] = $data[$field];
            }
            echo "looking for email " . $auth['email'] . " ... <br />";
            $auth['email'] = (empty($auth['email']) || is_null($auth['email']) ? 'placeholder_email@monithon' : $auth['email']);
            echo "checking email " . $auth['email'] . " <br />";
            $email_check = $User->findBy( array('email' => $auth['email']) );


            dbga($email_check);


            if(count($email_check) > 0){
                // This email is in our system. We need to get the Auth id and nothing else
                echo "Email found! handing over id auth -- " . $email_check[0]->idauth . "<br />";
                $idauth = $email_check[0]->idauth;
            }
            else {
                echo "User not found, creating one...<br />";
                $auth['password'] = password_hash((empty($auth['password']) || is_null($auth['password']) ? 'placeholder_passwrd':$auth['password']), PASSWORD_BCRYPT);
                $auth['username'] = (empty($auth['username']) || is_null($auth['username']) ? 'Monithon Batch Import':$auth['username']);
                // Crosscheck roles - will set everyone to "reporter"
                $auth['role'] = 3;
                $auth['active'] = 1;
                $auth = array_filter($auth);

                $idauth = $User->create($auth);
                dbga($idauth);
            }
            echo "Set up of idauth done, " . $idauth . "<br />";
            $auths[] = $idauth;
            // Set up ASOC entity if applicable
            $asoc = array();
            $Asoc = new Asoc();
            if(!empty($data['remote_id']) && !is_null($data['remote_id'])){
                echo '<span style="color:red;">Adding ASOC participant...</span><br />';
                $asoc_fields = array('remote_id','auth','istituto','tipo_istituto','regione','provincia','comune','link_blog','link_elaborato');
                foreach($asoc_fields as $field){
                    $asoc[$field] = $data[$field];
                }
                $asoc['auth'] = $idauth;
                $asoc = array_filter($asoc);
                $idasoc = $Asoc->create($asoc);
                if($idasoc){
                    echo 'ASOC entity created, ID' . $idasoc . '<br />';
                }
                // dbga($asoc);
            }
            // Import Report
            echo "Ok, ready to import the report now... <br />";
            $Report = new Report();
            $report = array();
            $report_fields = array('titolo','autore','id_open_coesione','api_data','indirizzo','cap','lat_','lon_','descrizione','parte_di_piano',
                                    'giudizio_sintetico','avanzamento','risultato_progetto','valutazione_risultati','punti_di_forza','punti_deboli',
                                    'problemi_amministrativi','problemi_tecnici','risultato_insoddisfacente','non_efficace','non_sufficiente',
                                    'necessita_interventi_extra','rischi','soluzioni_progetto','raccolta_informazioni','visita_diretta',
                                    'intervista_responsabili_progetto','intervista_utenti_beneficiari','intervista_altri_utenti','raccolta_info_web',
                                    'raccolta_info_attuatore','referenti_politici','intervista_soggetto_programmatore','intervista_autorita_gestione',
                                    'intervista_intervistati','intervista_domande','intervista_risposte','diffusione_twitter','diffusione_facebook',
                                    'diffusione_instagram','diffusione_eventi','diffusione_open_admin','diffusione_blog','diffusione_offline','diffusione_incontri',
                                    'diffusione_interviste','diffusione_altro','media_connection','tv_locali','tv_nazionali','giornali_locali','giornali_nazionali',
                                    'blog_online','media_other','admin_connection','admin_response_no','admin_response_formal','admin_response_some',
                                    'admin_response_promises','admin_response_unlocked','admin_response_flagged','admin_altro','impact_description',
                                    'tab_3_created_at','report_created_at','report_modified_at','created_by','reviewed_by','status','status_tab_3','author_type','legacy_id',
                                    'immagine_monitoraggio_daASOC',	'video_daASOC',	'immagine_team1_daASOC', 'immagine_team2_daASOC', 'immagine_team3_daASOC',
                                    );
            foreach($report_fields as $field){
                $report[$field] = $data[$field];
            }
            // Get API Data for project (?)
            // get fields and reformat

            $ApiData = array(
                'cod_grande_progetto'               => $data['cod_grande_progetto'],
                'cod_locale_progetto'               => $data['cod_grande_progetto'],
                'oc_titolo_progetto'                => $data['oc_titolo_progetto'],
                'oc_tema_sintetico'	                => $data['oc_tema_sintentico'],
                'oc_data_inizio_progetto'	        => $data['oc_data_inizio_progetto'],
                'oc_data_fine_progetto_effettiva'   => $data['oc_data_fine_progetto_effettiva'],
                'oc_stato_progetto'	                => $data['oc_stato_progetto'],
                'oc_finanz_tot_pub_netto'	        => $data['oc_finanz_tot_pub_netto'],
                'oc_descrizione_programma'	        => $data['oc_descrizione_programma'],
                'oc_descr_ciclo'	                => $data['oc_descr_ciclo'],
                'data_aggiornamento'                => $data['data_aggiornamento']
            );
            $ApiData['soggetti'] = array();

            $ApiRuoli = array(
                'programmatore' => $data['"ruoli":["Programmatore"]'],
                'attuatore'     => $data['"ruoli":["Attuatore"]'],
                'beneficiario'  => $data['"ruoli":["Beneficiario"]'],
                'realizzatore'  => $data['"ruoli":["Realizzatore"]'],
            );
            foreach($ApiRuoli as $ruolo => $denominazione){
                $finder = array_search($denominazione, array_column($ApiData['soggetti'], 'denominazione'));
                $role_holder = array();
                if( $finder !== FALSE ){
                    $ApiData['soggetti'][$finder]['ruoli'][] = $ruolo;
                }
                else {
                    $ApiData['soggetti'][] = array(
                        'denominazione' => $denominazione,
                        'ruoli' => array($ruolo)
                    );
                }
            }


            echo "API Data created... <br />";
            $report['api_data'] = json_encode($ApiData);

            // Fix lat and lon
            $report['lat_'] = str_replace(',', '.', $data['lat_']);
            $report['lon_'] = str_replace(',', '.', $data['lon_']);

            // add author_type
            $report['author_type'] = $data['Type_auth'];
            // add legacy_id
            $report['legacy_id'] = $data['ID_Monithon2'];
            // add created_by
            $report['created_by'] = $idauth;
            // add reviewed_by
            $report['reviewed_by'] = 2;
            // add status
            $report['status'] = 7;
            // add status_tab_3
            $report['status_tab_3'] = 7;
            // fix creation date to timestamp
            $creation_date = date('Y-m-d H:i:s', strtotime($report['report_created_at']));
            echo 'Creation date timestamp: ' . $creation_date . '<br />';

            $report['created_at'] = $creation_date;
            $report['tab_3_created_at'] = $creation_date;
            unset($report['report_created_at']);
            unset($report['report_modified_at']);

            dbga($report);

            $report = array_filter($report);


            $idreport = $Report->create($report);
            if($idreport){
                echo "<strong>REPORT CREATED</strong> - ID: " .$idreport." <br /><hr /><br /><br />";
            }
            dbga($report);
        }
        $row++;
    }
}
else {
    echo "could not read CSV file: " . $csv_file . " - exit.";
}

?>
</div>
</body>
</html>
