<?php

namespace Controllers;

class MemberController extends ControllerBase
{
  public function createAction($params) {
    /*
    Official API
    $firstName = $params["firstname"];
    $lastName = $params["lastname"];

    AngularJS's ngResource doesn't share our way of thinkig of appennding the params to the URI in POST requests but in the body (payload) instead, so 
    we workaround in this way. Not really elegant, imho.
    */

    $request_body = file_get_contents('php://input');
    $parse = json_decode($request_body);

    $firstName = $parse->{"firstname"};
    $lastName = $parse->{"lastname"};
    $email = $parse->{"email"};

    if (!isset($firstName) || !isset($lastName) || !isset($email)) {
      $this->throwError(400, "First Name or Last Name missing");
    }

    $this->model->FirstName = $firstName;
    $this->model->LastName = $lastName;
    $this->model->Email = $email;

    $res_id = $this->model->create();

    if ($res_id) {

      $l = array(
        "id" => $res_id,
        "FirstName" => $firstName,
        "LastName" => $lastName
      );

      $this->render($l);
    } else {
      $this->throwError(500, "Error executing the query");
    }
  }

  public function getAction($id) {
    
    if ($id == null) {
      //List all members
      $members = $this->model->findAll();
    } else {
      //Retrieve specific member
      $members = $this->model->findByPk((int)$id);
    }

    if ($members == null) 
      $members = array();

    $this->render($members);
  }

  public function updateAction($params) {
    $id = $params["_ID"];

    if (!isset($id) || trim($id) == "") {
      $this->throwError(400, "Missing an ID?!");
    }

    $id = (int)$id;

    $this->model->FirstName = $params["firstname"];
    $this->model->LastName = $params["lastname"];
    $this->model->id = $id;

    $this->model->update();
  }

  public function deleteAction($id) {
    echo __METHOD__;
  }
}

?>