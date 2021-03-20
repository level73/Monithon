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

    <title>OC Code Grabber - <?php echo APPNAME; ?></title>

</head>
<body>
<div class="container">
    <h1>Grabbing Reports</h1>

    <?php
    $Report = new Report();
    $Reports = $Report->all();
    dbga(count($Reports));

    foreach($Reports as $report){
        echo "<br> ID REPORT " . $report->idreport_basic."<br />";
        if(!empty($report->api_data)){
            $data = json_decode($report->api_data);
            echo "We have data here. <br />"; // dbga($data);


                $id = $report->idreport_basic;
                $oc_project_code = $data->cod_locale_progetto;

                echo "<br />Got data - id:  " . $id . " :: Local Code: " . $oc_project_code;

                $u = $Report->update($id, array('oc_project_code' => $oc_project_code));

                if($u){ echo "<br /> UPDATED"; } else { die('SOMETHING BROKE DUDE'); }


        }
        else {
            echo "Report API data is empty<br />";
        }
        echo "<hr />";

    }