<?php

  class Ctrl {

    protected $_controller;
    protected $_model;
    protected $_method;
    protected $_template;

    function __construct($model, $controller, $method) {

      $this->_controller = $controller;
      $this->_method = $method;
      $this->_model = $model;

      $this->$model = new $model;

      $this->_template = new Template($controller, $method);

      // generate variable to append to html body tag
      $this->_template->set('bodyClass', strtolower($model . ' ' . $method));
      $this->set('css', '');
      $this->set('js', '');
    }

    function set($name,$value) {
      $this->_template->set($name, $value);
    }

    function __destruct() {
      $this->_template->render();
    }
  }
