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
require(ROOT . DS . 'config' . DS . 'local.php');
require(ROOT . DS . 'config' . DS . 'system.php');

require(ROOT . DS . 'lib' . DS . 'functions.php');
require(ROOT . DS . 'lib' . DS . 'main.php');


// Launch Application
init();
