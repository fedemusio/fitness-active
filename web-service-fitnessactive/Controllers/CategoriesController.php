<?php

namespace Controllers;

class CategoriesController extends ControllerBase
{
  public function createAction($params) {
    $courseName = $params["coursetname"];
    $description = $params["description"];
    $room = $params["room"];
    $category = $params["category"];
    $instructor1 = $params["instructor1"];
    $instructor2 = $params["instructor2"];
    $level = $params["level"];
        

    if (!isset($courseName) || !isset($description) || !isset($room) || !isset($category) || !isset($instructor1)) {
      $this->throwError(400, "Data Missing!");
    }

    $this->model->CourseName = $courseName;
    $this->model->Description = $description;
    $this->model->Room = $room;
    $this->model->Category = $category;
    $this->model->Instructor1 = $instructor1;
    $this->model->Instructor2 = $instructor2;
    $this->model->Level = $level;

    $res_id = $this->model->create();

    if ($res_id) {

      $l = array(
        "id" => $res_id,
        "CourseName" => $courseName,
        "Description" => $description,
        "Room" => $room,
        "Category" => $category,
        "Instructor1" => $instructor1,
        "Instructor2" => $instructor2,
        "Level" => $level
      );

      $this->render($l);
    } else {
      $this->throwError(500, "Error executing the query");
    }
  }

  public function getAction($id) {
    $params = $this->REQ->get_params();
    if ($id == null) {
      //List all members
      $courses = $this->model->findAll();
    } else {
        if(isset($params["join"]) && $params["join"] == "instructors") {
            $courses = $this->model->findByAttributes(
                array(
                    "Instructor1" => (int)$id,
                    "Instructor2" => (int)$id), 
                    "OR");
        } else {
            //Retrieve specific member
            $courses = $this->model->findByPk((int)$id);
        }
    }  
      
    if ($courses == null) 
      $courses = array();
    $this->render($courses);
   
  }

  public function updateAction($params) {
    $id = $params["_ID"];

    if (!isset($id) || trim($id) == "") {
      $this->throwError(400, "Missing an ID?!");
    }

    $id = (int)$id;
    
    $this->model->CourseName = $params["coursename"];
    $this->model->Description = $params["description"];
    $this->model->Room = $params["room"];
    $this->model->Category = $params["category"];
    $this->model->Instructor1 = $params["instructor1"];
    $this->model->Instructor2 = $params["instructor2"];
    $this->model->Level = $params["level"];
    $this->model->id = $id;

    $this->model->update();
  }

  public function deleteAction($id) {
    echo __METHOD__;
  }
}

?>