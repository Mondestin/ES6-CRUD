<?php
namespace CRUD;
  require_once('user.php');
  require_once('utilities.php');
  require_once('userController.php');

  $controller = new UserController;
  
  // Handle Fetch All Users 
  if (isset($_GET['index'])) {
    $res=$controller->index();
    echo $res;
  }
  
  // Handle Add New User
  if (isset($_POST['add'])) {
     $res=$controller->store();
     echo $res;
  }


  // Handle Edit User 
  if (isset($_GET['edit'])) {
    $res=$controller->show($_GET['id']);
    echo $res;
  }

  // Handle Update User 
  if (isset($_POST['update'])) {
    $res=$controller->update($_POST['id']);
    echo $res;
  }

  // Handle Delete User 
  if (isset($_GET['delete'])) {
    $res=$controller->delete($_GET['id']);
    echo $res;
  }

?>
