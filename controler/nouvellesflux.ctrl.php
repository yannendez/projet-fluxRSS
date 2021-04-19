<?php
session_start();
if(isset($_SESSION["login"])){
  require_once('../framework/view.class.php');
  require_once("../model/DAO.class.php");

  $dao = new DAO();

  if(isset($_GET["flux"])){
    $flux = $_GET["flux"];
  }

  $nouvelles = $dao->getNouvellesFlux($flux);


  $view = new View('header.view.php');
  $view->nouvelles = array();

  foreach ($nouvelles as $nouvelle) {

    $view->nouvelles[] = $nouvelle;
  }



  $view->show();
}else{
  header('Location: ../index.html');
}

?>
