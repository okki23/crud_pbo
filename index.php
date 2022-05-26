<?php 
include "crud.php";
$crud = new CRUD;

$action = $_GET['action'] ? $_REQUEST['action'] : '';

switch($action){

  case "view":
  $crud->MainPage();
  break;

  case "load-data":
  $crud->LoadData();
  break;

  case "save":
  $crud->SaveData();
  break;

  case "getdata":
  $crud->GetData();
  break;
  
  case "delete":
  $crud->DestroyData();
  break;

  default:
  $crud->MainPage();
}
?>