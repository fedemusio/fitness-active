<?php

spl_autoload_register(function($class) {
  $c = str_replace("\\", "/", $class) . ".php";
  require_once($c);
});


$request = new Utils\Request($_SERVER);
$className = ucwords($request->get_ns()) . 'Controller';

$file = 'Controllers/' . $className . '.php';

if (file_exists($file)) {
  $ns_className = 'Controllers\\' . $className;

  $controller = new $ns_className($request);
  $action = $controller->get_action_name();
  $arg = $controller->get_arg();
  $controller->$action($arg);

} else {
  $errCode = 404;
  $errMessage = "Namespace not found!";

  $error = array(
    "Error" => $errCode,
    "Message" => $errMessage
  );

  header('HTTP/1.0 ' . $errCode . '\r\n');
  header('Content-Type: text/json\r\n');

  die(json_encode($error));
}



?>