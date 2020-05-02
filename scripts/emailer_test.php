<?php
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DS', '/');
// Load configuration files
require(ROOT . DS . 'config' . DS . 'local.php');
require(ROOT . DS . 'config' . DS . 'system.php');
    require '../lib/emailer.class.php';
    $Emailer = new Emailer();

