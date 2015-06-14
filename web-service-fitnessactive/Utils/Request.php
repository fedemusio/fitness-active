<?php

namespace Utils;

class Request 
{
  private $request_uri = null;
  private $request_ns = null;
  private $request_id = null;
  private $request_params = array();
  private $request_method = null;
  private $REQUEST = null;


  public function __construct($server_info) {
    if (!isset($server_info)) {
      return null;
    }

    $this->REQUEST = $server_info;

    $this->parse_request();
  }

  private function parse_request() {

    #METHOD
    switch($this->REQUEST["REQUEST_METHOD"]) {
      case 'GET':
      case 'POST':
      case 'PUT':
      case 'DELETE':
        $this->request_method = $this->REQUEST["REQUEST_METHOD"];
        break;
      default:
        $this->throwError(HTTP_ERROR::BAD_REQUEST, "Request not accepted");
        break;
    }

    #NAMESPACE & TARGET
    if (isset($this->REQUEST["PATH_INFO"])) {
      $req_expl = explode('/', $this->REQUEST["PATH_INFO"]);
    }

    if (count($req_expl) == 0) {
      $this->throwError(HTTP_ERROR::BAD_REQUEST, "Mssing namespace?!");
    }

    $this->request_ns = strtolower($req_expl[1]);

    if (isset($req_expl[2])) {
      $this->request_id = $req_expl[2];
    }

    #PARAMS
    $qs = $this->REQUEST["QUERY_STRING"];

    if (isset($qs) && $qs != "") {
      $qs_expl = explode('&', $qs);

      $newar = &$this->request_params;

      foreach ($qs_expl as $val)
      {
        $val_expl = explode('=', $val);

        if (!isset($val_expl[1])) {
          $this->throwError(HTTP_ERROR::BAD_REQUEST, "Params must be like key=value");
        }
        $newar[$val_expl[0]] = $val_expl[1];
      }
    }
  }

  private function throwError($http_error, $message) {
    $error_string = array(
      "Error" => $http_error,
      "Message" => $message
    );

    header('HTTP/1.0 ' . $http_error . '\r\n');
    header('Content-Type: text/json\r\n');

    die(json_encode($error_string));
  }

  public function get_ns() {
    return $this->request_ns;
  }

  public function get_action() {
    return $this->request_method;
  }

  public function get_params() {
    return $this->request_params;
  }

  public function get_target() {
    return $this->request_id;
  }
}

?>