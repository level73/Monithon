<?php
/*
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
*/
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
    <h1>Importer ran already. </h1>
<?php
/*
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
                                    'tab_3_created_at','report_created_at','report_modified_at','created_by','reviewed_by','status','status_tab_3',
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
                'oc_tema_sintetico'	                => $data['oc_tema_sintetico'],
                'oc_data_inizio_progetto'	        => $data['oc_data_inizio_progetto'],
                'oc_data_fine_progetto_effettiva'   => $data['oc_data_fine_progetto_effettiva'],
                'oc_stato_progetto'	                => $data['oc_stato_progetto'],
                'finanz_totale_pubblico'	        => $data['oc_finanz_tot_pub_netto'],
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
            dbga($ApiData);
            $report['api_data'] = json_encode($ApiData);
            // add legacy_id
            $report['legacy_id'] = $data['ID_Monithon2'];

            $report = array_filter($report);

            // Find report by legacy id
            $ReportId = $Report->findBy(array('legacy_id' => $data['ID_Monithon2']));
            //dbga($ReportId[0]);
            echo "Current ID is " . $ReportId[0]->idreport_basic . "<br />";


            if(!empty($ReportId) && is_numeric($ReportId[0]->idreport_basic)){
                $id = $ReportId[0]->idreport_basic;

                $Report->update($id, array('api_data' => $report['api_data']));
                echo "Report Updated - ID " . $id . ", Legacy ID " . $data['ID_Monithon2'];
                echo "<hr />";
            }

        }
        $row++;
    }
}
else {
    echo "could not read CSV file: " . $csv_file . " - exit.";
}
*/
?>
</div>
</body>
</html>
