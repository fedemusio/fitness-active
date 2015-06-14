<?php

namespace Models;

class CoursesModel extends ModelBase
{
  public $id;
  public $CourseName;
  public $Description;
  public $Room;
  public $Category;
  public $Instructor1;
  public $Instructor2;
  public $Level;

  public function __construct() {
    $this->_classname = __CLASS__;
    parent::__construct();
  }
}

?>