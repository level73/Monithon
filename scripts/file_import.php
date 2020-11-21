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
require(ROOT . DS . 'lib' . DS . 'repo.class.php');

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
        <h1>IMPORTER RAN ALREADY</h1>
<?php
// Main CSV File - load data and create handler
/*
$csv_file = 'dataset_files.csv';
$csv_handle = fopen($csv_file, "r");

$Report = new Report();
$Files = new Meta('file_repository');
$File  = new Repo();
$unwanted = array();
$unfound = array();
$counter = 1;
if($csv_handle){
    while(($data = fgetcsv($csv_handle, 0, ",")) !== FALSE){
        $fileList = array();

        echo "<h2>ROW ". $counter ."</h2><br />";

        // Check if we have report already
        $report = $Report->findBy(array('legacy_id' => $data[0]));
        $id = $report[0]->idreport_basic;
        echo 'ID FOUND -- ' . $id . '<br />';

        if(strpos($data[2], '[') === 0) {
            $revert = json_decode($data[2]);
            if(!empty($revert)){
                foreach($revert as $f){
                    $fileList[] = $f->url;
                }
            }
        }
        else {
            $fileList[] = $data[2];
        }
        dbga($fileList);
        // Files are an array tied to the ame report
        foreach($fileList as $filename){

          $filepath = DIR_REPO . $filename;

          if(!file_exists($filepath)){
                echo "File not found -- Checking monithon old repo...";

                $remotepath = $filename;

              $file_headers = @get_headers($remotepath);

              if($file_headers[0] == 'HTTP/1.0 404 Not Found'){
                  echo "The file " . $filename . " does not exist<br />";
                  $unfound[] = $counter . ' - ' . $filename;
              } else if ($file_headers[0] == 'HTTP/1.0 302 Found' && $file_headers[7] == 'HTTP/1.0 404 Not Found'){
                  echo "The file " . $filename . " does not exist, and I got redirected to a custom 404 page...<br />";
                  $unfound[] = $counter . ' - ' . $filename;
              } else {
                  echo "The file " . $filename . " exists. <br />";
                  $newfile_name = basename($filepath);
                  $newfile = fopen(DIR_REPO . $newfile_name, "w+");
                  $newfile_path = DIR_REPO . $newfile_name;
                  if ( copy($remotepath, $newfile_path) ) {
                      echo "<strong><span style='color: green;'>Copy success!</span></strong> <br />";
                      $filepath = $newfile_path;
                  } else{
                      echo '<strong><span style="color: red">Copy failed. </span></strong><br />';
                  }
              }
          }
        if(!empty($filename)){
            // Set Meta reference
            $insert_data = array(
              'title'       => 'REPORT ATTACHMENT - Legacy report ' . $report->legacy_id,
              'file_path'   => basename($filename),
              'file_type'   => 2,
              'disclosure'  => 100,
              'modified_by' => 1
            );


            $file_id = $File->create($insert_data);
            echo 'File ID -- ' . $file_id . '<br />';
            $f = $Files->updateFileReferences(T_REP_BASIC, $id, array($file_id) );
            if($f == true){
                echo "FILE META SET - MOVING FORWARD<hr />";

            }
            else {
                echo "<strong>SOMETHING WENT WRONG HERE!</strong>";
                die();
            }

            }
        }
        $counter++;
        echo "<br /><hr /><br />";
    }
}
echo "<hr /><h1>" .count($unfound). " File non trovati/assenti</h1>";
dbga($unfound);
echo "<hr /><h1>" .count($unwanted)." File non rispettano i nostri criteri</h1>";
dbga($unwanted);

*/
?>
    </div>
</body>
</html>