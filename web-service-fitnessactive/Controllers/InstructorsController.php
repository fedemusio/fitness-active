<?php

namespace Controllers;

class InstructorsController extends ControllerBase
{
  public function createAction($params) {
    $firstName = $params["firstname"];
    $lastName = $params["lastname"];
    $description = $params["description"];
    $awards = $parmas["awards"];
    $professionalArea = $params["professionalarea"];
    $thumbnail = $params["thumbnail"];
        

    if (!isset($firstName) || !isset($lastName) || !isset($description) || !isset($awards) || !isset($professionalArea) ||           !isset($thumbnail)) {
      $this->throwError(400, "Data missing!");
    }

    $this->model->FirstName = $firstName;
    $this->model->LastName = $lastName;
    $this->model->Description = $description;
    $this->model->Awards = $awards;
    $this->model->ProfessionalArea = $professionalArea;
    $this->model->Thumbnail = $thumbnail;

    $res_id = $this->model->create();

    if ($res_id) {

      $l = array(
        "id" => $res_id,
        "FirstName" => $firstName,
        "LastName" => $lastName,
        "Description" => $description,
        "Awards" => $awards,
        "ProfessionalArea" => $professionalArea,
        "Thumbnail" => $thumbanil
      );

      $this->render($l);
    } else {
      $this->throwError(500, "Error executing the query");
    }
  }

  public function getAction($id) {

    if ($id == null) {
      //List all members
      $instructors = $this->model->findAll();
    } else {
      //Retrieve specific member
      $instructors = $this->model->findByPk((int)$id);
    } 
       
    if ($instructors == null) 
      $instructors = array();
    $this->render($instructors);
   
  }

  public function updateAction($params) {
    $id = $params["_ID"];

    if (!isset($id) || trim($id) == "") {
      $this->throwError(400, "Missing an ID?!");
    }

    $id = (int)$id;
    
    $this->model->Thumbnail = $params["thumbnail"];
    $this->model->ProfessionalArea = $params["professionalarea"];
    $this->model->Awards = $params["awards"];
    $this->model->Description = $params["description"];
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