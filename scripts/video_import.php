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
require(ROOT . DS . 'lib' . DS . 'meta.class.php');
require(ROOT . DS . 'lib' . DS . 'video.class.php');

// Load Models
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
        <h1>VIDEO IMPORTER RAN ALREADY</h1>
<?php /*
// Main CSV File - load data and create handler
$csv_file = 'dataset_monithon_videos.csv';
$csv_handle = fopen($csv_file, "r");

$Report = new Report();
$Videos = new Meta('video_repository');
$Video  = new Video();

if($csv_handle){
    while(($data = fgetcsv($csv_handle, 0, ",")) !== FALSE){

        $report = $Report->findBy(array('legacy_id' => $data[0]));
        $id = $report[0]->idreport_basic;
        echo 'ID FOUND -- ' . $id . '<br />';

        // Set Meta reference

        $videoList = array();
        $video_id = $Video->create(array('URL' => $data[1]));
        echo 'VIDEO ID -- ' . $video_id . '<br />';
        $f = $Videos->updateVideoReferences(T_REP_BASIC, $id, array($video_id) );
        if($f == true){
            echo "VIDEO META SET - MOVING FORWARD<hr />";

        }
        else {
            echo "<strong>SOMETHING WENT WRONG HERE!</strong>";
            die();
        }

    }
}
*/

?>
    </div>
</body>
</html>