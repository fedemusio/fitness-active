<?php

namespace Models;

class ModelBase {

  private $DbHandler = null;
  protected $_dbtable = null;
  protected $_classname = null;
  protected $config = null;
  protected $ext_model = null;
  protected $entity = null;
  protected $props = null;

  public function __construct () {
    $db = \Utils\Config::get('db');

    $this->DbHandler = new \mysqli($db['host'], $db['user'], $db['pass'], $db['db_name']);
    $this->_dbtable = \Utils\Helper::get_table_name($this->_classname);
    $this->props = \Utils\Helper::get_props($this->_classname);
    $this->DbHandler->set_charset("utf8");
  }

  public function create() {

    $props = \Utils\Helper::get_props($this);

    $query = "INSERT INTO " . $this->_dbtable . " ";
    $col_names = "(";
    $values = "(";

    foreach($props as $val) {
      if ($val->getDeclaringClass()->getName() == $this->_classname && $val->getValue($this) !== null) {
        $col_names .= $val->getName() . ",";
        $values .= "'" . $val->getValue($this) . "' ,";
      }
    }

    $col_trim = rtrim($col_names, ",");
    $val_trim = rtrim($values, ",");

    $col_trim .= ")";
    $val_trim .= ")";

    $final_query = $query . $col_trim . " VALUES " . $val_trim;

    $conn = $this->DbHandler;
    $res = $conn->query($final_query);

    if ($res) {
      return $conn->insert_id;
    } else {
      return null;
    }
  }

  public function update() {
    $props = \Utils\Helper::get_props($this);

    $query = "UPDATE " . $this->_dbtable . " SET ";

    $set = "";
    $id;

    foreach($props as $val) {
      if ($val->getDeclaringClass()->getName() == $this->_classname && $val->getValue($this) !== null && $val->getName() != "id") {
        $set .= $val->getName() . " = " . "'" . $val->getValue($this) . "' ,";
      }

      if ($val->getName() == "id") {
        $id = $val->getName();
      }
    }

    $set_q = rtrim($set, ",");

    $final_query = $query . $set_q . "WHERE id=" . $id;

    echo $final_query;

    //$res = $conn->query($final_query);

    // if ($res) {
    //   return $conn->insert_id;
    // } else {
    //   return null;
    // }
  }

  public function findByPk($pk) {
    $conn = $this->DbHandler;

    $query = "SELECT * FROM " . $this->_dbtable . " WHERE id = " . $pk;
    $result = $conn->query($query);

    if (!$result) {
      return null;
    } else {
      return $result->fetch_assoc();
    }
  }

  public function findAll() {
    return $this->findByAttributes(null);
  }

  public function findByAttributes($attrs = null, $type = "") {
    $conn = $this->DbHandler;
    $query;
    
    if ($attrs == null) {
      $query = "SELECT * FROM " . $this->_dbtable;
    } else {
      $where = \Utils\Helper::get_clause_from_attrs($attrs, $type);
      $query = "SELECT * FROM " . $this->_dbtable . " WHERE " . $where;
    }

    $results = $conn->query($query);
      
    if (!$results) {
      return null;
    }

    $collection = array();

    while ($row = $results->fetch_assoc()) {
      $collection[] = $row;
    }
      
    return $collection;
  }

}

?>