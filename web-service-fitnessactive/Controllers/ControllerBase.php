<?php

namespace Controllers;

class ControllerBase
{
  protected $REQ = null;
  protected $_action = null;
  protected $model = null;
  private $_parameter = array();

  public function __construct($request) {
    $this->REQ = $request;

    switch($this->REQ->get_action())
    {
      case 'GET':
        $this->_action = 'get';
        $this->_parameter = $this->REQ->get_target();
        break;
      case 'PUT':
        $this->_action = 'update';
        $this->_parameter = $this->REQ->get_params();
        $this->_parameter["_ID"] = $this->REQ->get_target();
        break;
      case 'POST':
        $this->_action = 'create';
        $this->_parameter = $this->REQ->get_params();
        break;
      case 'DELETE':
        $this->_action = 'delete';
        $this->_parameter = $this->REQ->get_target();
        break;
      default:
        break;
    }

    $this->_action = $this->_action . 'Action';

    $ns_modelClassName = 'Models\\' . ucwords($this->REQ->get_ns()) . "Model";
    $this->model = new $ns_modelClassName();
  }

  public function get_action_name() {
    return $this->_action;
  }

  public function get_arg() {
    return $this->_parameter;
  }

  public function render($array) {
    $json = json_encode($array);

    header('HTTP/1.0 200r\r\n');
    header('Content-Type: text/json\r\n');

    echo $json;
  }

  protected function throwError($http_error, $message) {
    $error_string = array(
      "Error" => $http_error,
      "Message" => $message
    );

    header('HTTP/1.0 ' . $http_error . '\r\n');
    header('Content-Type: text/json\r\n');

    die(json_encode($error_string));
  }
}

?>