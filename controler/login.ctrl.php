<?php
  require_once('../framework/view.class.php');
  require_once("../model/DAO.class.php");

  //Récupération des infos
  $login = $_POST["user"];
  $mp = $_POST["mdp"];

  $dao = new DAO();
  if($dao->loginOk($login, $mp)==4){
    session_start();
    $_SESSION["login"] = $login;
    header("Location: main.ctrl.php");
  }else{
    //si le login échoue, renvoi l'utilisateur sur la page de connexion
    header('Location: ../index.html');
  }
