<?php

namespace Utils;

class Helper
{
	public static function get_table_name($classname) {
		$l_trim = ltrim($classname, 'Models');
    $r_trim = rtrim($l_trim, 'Model');
    $l_trim = ltrim($r_trim, '\\');

    return strtolower($l_trim);
	}

	public static function get_clause_from_attrs($attrs, $type = "AND") {
        
    $count = strlen($type) + 1;

    $where = "";

    foreach ($attrs as $key => $val) {
      $where .= "`" . $key . "` = ";

      if (is_integer($val)) {
        $where .= $val;
      } else {
        $where .= "'" . $val ."'";
      }

      $where .= " ".$type." ";
    }

    return substr($where, 0, strlen($where) - $count);
  }

  public static function get_props($classname) {
  	$reflect = new \ReflectionClass($classname);

  	$props = $reflect->getProperties();

    return $props;
  }
}

?>