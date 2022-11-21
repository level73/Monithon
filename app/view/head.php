<!doctype html>
<html lang="it">
  <head>
    <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Load Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Roboto:300,300i,400,900&family=IBM+Plex+Mono" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="/public/font/fontawesome/css/all.css">
      <link rel="stylesheet" type="text/css" href="/public/css/vendor/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="/public/css/vendor/bootstrap-select.min.css">
      <link rel="stylesheet" type="text/css" href="/public/css/vendor/bootstrap-table.min.css">
      <link rel="stylesheet" type="text/css" href="/public/css/main.css?t=19102022">
      <?php if( isset($street_map) && $street_map == true ){ ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
              integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
              crossorigin="">
      <?php } ?>
      <?php loadCSS($css); ?>

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

      <title><?php echo (isset($title) ? $title . ' | ' : '') . APPNAME; ?></title>

  </head>

  <body class="<?php echo $bodyClass; ?>">
    <div class="d-flex flex-column full-wrap">
