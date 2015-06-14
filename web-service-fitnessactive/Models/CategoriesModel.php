<?php

namespace Models;

class CategoriesModel extends ModelBase
{
  public $id;
  public $CategoryName;
  public $Description;

  public function __construct() {
    $this->_classname = __CLASS__;
    parent::__construct();
  }
}

?>