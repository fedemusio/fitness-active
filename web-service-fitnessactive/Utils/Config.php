<?php

namespace Utils;

class Config
{
  private static $config = array(
  'db' => array(
          'host' => 'localhost',
          'user' => 'fitnessactive',
          'pass' => '',
          'db_name' => 'my_fitnessactive')
  );

  public static function get($key) {
    return self::$config[$key];
  }
}


?>
