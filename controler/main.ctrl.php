<?php
session_start();
if(isset($_SESSION['login'])){

  require_once('../framework/view.class.php');
  require_once("../model/DAO.class.php");

  $dao = new DAO();
  $login = $_SESSION["login"];

  // Création de l'objet vue
  $view = new View('main.view.php');

  $view->nouvelles = array();
  $view->flux = array();

  // Demande le nombre de produits
  $nouvelles = $dao->getNouvellesUtilisateur($login);

  $allFlux = $dao->getAllFluxUtilisateur($login);



  // Passage des valeurs à placer dans la vue
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


 ?>
