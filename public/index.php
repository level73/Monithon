<?php
// Set Session Max Lifetime
session_name('MONITHON');
// Initialize Session
session_start();

header('Content-Type: text/html; charset=utf-8');
$url = (isset($_GET['url']) ? $_GET['url'] : '');

// Set filesystem constants
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DS', '/');

// Load configuration files
require(ROOT . 'config' . DS . 'local.php');
require(ROOT . 'config' . DS . 'system.php');

require(ROOT . 'lib' . DS . 'functions.php');
require(ROOT . 'lib' . DS . 'main.php');


// Launch Application
init();
