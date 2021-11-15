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
require(ROOT . DS . 'app' . DS . 'model' . DS . 'report.mdl.php');


/** Random String Generator */
function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}
?>

<!doctype html>
<html lang="it">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Load Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,900" rel="stylesheet">
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
    <h1>NEW PROFILES - DRY RUN</h1>
    <?php
/*
    // Main CSV File - load data and create handler
    $csv_file = 'new-profiles.csv';
    $csv_handle = fopen($csv_file, "r");

    if($csv_handle){
        $UserModel = new User;
        $RegSession = new Session;
        $ReportModel = new Report;

        $row = 0;
        $keys = array();
        echo "<h2>Starting - Row 0</h2><br />";
        while(($data = fgetcsv($csv_handle, 0, ",")) !== FALSE){
            if($row == 0){
                echo "skipping first row (labels)... <br />";
            }
            else {
                // Setting up changes
                $report_id = $data[0];

                $userdata['password']         = password_hash(random_str(12), PASSWORD_BCRYPT);
                $userdata['email']            = $data[2];
                $userdata['username']         = filter_var($data[1], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $userdata['role']             = 3;
                $userdata['active']           = 1;

                // Create User Profiles
                echo "<h3>Row ".$row."</h3>";
                echo "<p>Create User with email: " . $userdata['email'] . "</p>";
                $idUser = $UserModel->create($userdata);
                if($idUser){
                    $sess = $RegSession->createSession($idUser);
                    if($sess){
                        echo "<p> Session created</p>";
                    }
                    else {
                        die("ERROR SESSION NOT CREATED");
                    }
                }

                // Update report
                $new = array(
                        'created_by'    => $idUser,
                        'autore'        => $userdata['username']
                );
                $report_update = $ReportModel->update($report_id, array('created_by' => $idUser));
                if($report_update){
                    echo "<p> Report updated</p>";
                    echo "<pre>"; print_r($new); echo "</pre>";
                }
                else {
                    die("ERROR REPORT NOT UPDATED");
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
