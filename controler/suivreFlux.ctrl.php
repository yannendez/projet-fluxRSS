<?php
session_start();
if(isset($_SESSION['login'])){

$login = $_SESSION['login'];
require_once('../framework/view.class.php');
require_once("../model/DAO.class.php");

$dao = new DAO();

if(isset($_GET["flux"])){
  $flux = $_GET["flux"];
  $dao->suivreFlux($flux, $login);
  include("../framework/majFlux.php");
}

$view = new View('ajouteFlux.view.php');
$view->nouvelles = array();
$view->flux = array();

$allFlux = $dao->getAllFlux();


$nouvelles = $dao->getNouvellesUtilisateur($login);

foreach ($nouvelles as $nouvelle) {

  $view->nouvelles[] = $nouvelle;
}

foreach ($allFlux as $flux) {
  $view->flux[] = $flux;
}

// Appel la vue
$view->show();

}else{
  header('Location: ../index.html');
}
