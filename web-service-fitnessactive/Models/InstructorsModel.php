<?php

namespace Models;

class InstructorsModel extends ModelBase
{
  public $id;
  public $FirstName;
  public $LastName;
  public $Description;
  public $Thumbnail;
  public $Awards;
  public $ProfessionalArea;

  public function __construct() {
    $this->_classname = __CLASS__;
    parent::__construct();
  }
}

?>