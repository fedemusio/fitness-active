<?php

namespace Models;

class MemberModel extends ModelBase
{
  public $id;
  public $FirstName;
  public $LastName;
  public $Email;

  public function __construct() {
    $this->_classname = __CLASS__;
    parent::__construct();
  }
}

?>