<?php

/**  Check System Status and set error reporting
  *  SYSTEM_STATUS is set in config/local.php
  **/
function errorReporting() {
  if (SYSTEM_STATUS == 'development') {
    // Enable server error reporting
    ini_set('display_errors', 'On');
    error_reporting(E_ALL & ~E_DEPRECATED);
  }
  elseif (SYSTEM_STATUS == 'production') {
    // Hide server error reporting
    ini_set('display_errors', 'Off');
    error_reporting(0);
  }
}

/** Autoload **/
function mvc_core($className){
    require (ROOT . DS . 'lib' . DS . 'vendor' . DS . 'autoload.php');
  if(file_exists(ROOT . DS . 'lib' . DS . strtolower($className).'.class.php')){
      require_once(ROOT . DS . 'lib' . DS . strtolower($className).'.class.php');
  }
  elseif(file_exists(ROOT . DS . 'app' . DS . 'model' . DS . strtolower($className) . '.mdl.php')){
      require_once(ROOT . DS . 'app' . DS . 'model' . DS . strtolower($className) . '.mdl.php');
  }
  elseif(file_exists(ROOT .  DS . 'app' . DS . 'controller' . DS . strtolower($className).'.ctrl.php')){
      require_once(ROOT . DS . 'app' . DS . 'controller' . DS . strtolower($className).'.ctrl.php');
  }
  else {
      if (DEBUG) { dbga(debug_backtrace()); }
      echo 'Class <strong>'.ucfirst($className).'</strong> Not Found. <br /> Application Fail.';

  }
}



/** Register Autoloader **/
spl_autoload_register('mvc_core');




/** Launch Application
**/
function init(){
  // Activate error reporting
  errorReporting();

  // Capture Routing Params
  global $url;

  $exclude = array('js', 'css');

  $array_url = explode('/', $url);

  // the Controller is the first element of our Route
  $route = $array_url[0];
  array_shift($array_url);

  // Check for a method and (eventually) a querystring
  if (!empty($array_url)) {
      $method = $array_url[0];
      array_shift($array_url);
      $queryString = $array_url;
    
  }
  else {
    // Set default method
    $method = 'index';
    $queryString = array();
  }

  // Empty controller? go to default Route
  if (empty($route)) {
    $route = DEFAULT_CONTROLLER;
    $method = DEFAULT_METHOD;
  }




  $baseClassName = rtrim(ucwords($route));
  $controller = $baseClassName . 'Ctrl';
  $model = $baseClassName;
  // avoid dispatching for js and css
  if(!in_array($route, $exclude)){

    // Create Instance
    // refer to lib/ctrl.class.php to see how the controller handles the business logic
    try {
      $dispatch = new $controller($model, $route, $method);

      if (method_exists($controller, $method) == true) {
          // Execute method
          call_user_func_array(array($dispatch, $method), $queryString);
      } else {
        /** TO DO
          * Set to 404 Page, with links and
          * suggestions for action
          **/
          echo "No such method";
      }
    }
    catch (Errors $e){

    }

  }
}
