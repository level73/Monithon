<?php

  class Template {

    protected $variables = array();
    protected $_controller;
    protected $_method;
    protected $Auth;

    /** array to exclude certain routes (like csv exports or AJAX urls) **/
    private $exclude = array();

    public function __construct($controller, $method) {
      $this->_controller = $controller;
      $this->_method = $method;
      $this->Auth = new Auth;
    }

    /** Set Variables **/
    public function set($name, $value) {
      $this->variables[$name] = $value;
    }

    /** Display Template **/
    public function render() {

      extract($this->variables);

      if( !in_array($this->_method, $this->exclude) && $this->_controller != 'ajax'  && $this->_controller != 'api' && $this->_method != 'export'  && $this->_method != 'jsonWorkAreas' ){
        /* Include Base Head @ view/head.php */
        include (ROOT . DS . 'app' . DS . 'view' . DS . 'head.php');

        /** Include Header **/
        if (file_exists(ROOT . DS . 'app' . DS . 'view' . DS . $this->_controller . DS . 'header.php')) {
          include (ROOT . DS . 'app' . DS . 'view' . DS . $this->_controller . DS . 'header.php');
        } else {
          include (ROOT . DS . 'app' . DS . 'view' . DS . 'header.php');
        }
        /** check for sub-menus **/
        if( file_exists(ROOT . DS . 'app' . DS . 'view' . DS . $this->_controller . DS . 'sub-menu.php' )){
          include(ROOT . DS . 'app' . DS . 'view' . DS . $this->_controller . DS . 'sub-menu.php' );
        }
        /** If we have any errors, this is where we print them without breaking the whole thing ***/
        if( isset($errors) && $errors instanceof Errors ){
            include(ROOT . DS . 'app' . DS . 'view' . DS . '_partials' . DS . 'errors.php');
        }

        /** Include desired center template **/
        if( !file_exists(ROOT . DS . 'app' . DS . 'view' . DS . $this->_controller . DS . $this->_method . '.php')) {
          echo "<h3>Template piece not found: <em>" . DS . $this->_controller . DS . $this->_method . "</em></h3>";
        } else {
          include (ROOT . DS . 'app' . DS . 'view' . DS . $this->_controller . DS . $this->_method . '.php');
        }

        /** Include footer **/
        if (file_exists(ROOT . DS . 'app' . DS . 'view' . DS . $this->_controller . DS . 'footer.php')) {
            include (ROOT . DS . 'app' . DS . 'view' . DS . $this->_controller . DS . 'footer.php');
        } else {
            include (ROOT . DS . 'app' . DS . 'view' . DS . 'footer.php');
        }

        /* Include Base Foot @ view/foot.php */
        include (ROOT . DS . 'app' . DS . 'view' . DS . 'foot.php');
      }
      else {
        /** requested file should not include header and footer, might be different mime or AJAX content **/

        if(file_exists(ROOT . DS . 'app' . DS . 'view' . DS . $this->_controller . DS . $this->_method . '.php')){
          include (ROOT . DS . 'app' . DS . 'view' . DS . $this->_controller . DS . $this->_method . '.php');
        }
      }
    }

  }
