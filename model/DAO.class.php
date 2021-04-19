<?php
require_once('../model/Flux.class.php');
require_once('../model/FluxUtilisateur.class.php');
require_once('../model/Nouvelle.class.php');
require_once('../model/Utilisateur.class.php');


// Classe Data Access Objet : elle représente la base de données
class DAO {
  // L'objet base de donnée
  private $db;
  // Localisation de la BD par rapport au controleur
  // NE PAS MODIFIER CET ATTRIBUT
  private $database = '../data/db/newsDB';

  // Le constructeur ouvre l'acces à la BD
  public function __construct() {
    // Verifie que le fichier base de donnée existe etdie('tararce'); est en lecture écriture
    if (! file_exists($this->database)) {
      die ("Database error: file not found '".$this->database."'\n");
    }
    if (!is_writable($this->database)) {
      die ("Database error: file not writable '".$this->database."'\n");
    }

    try {
      $this->db = new PDO("sqlite:".$this->database);
      if (!$this->db) {
        die ("Database error: cannot open '".$this->database."'\n");
      }
    } catch (PDOException $e) {
      die("PDO Error :".$e->getMessage()." '".$this->database."'\n");
    }

  }

  //retourne toute les nouvelles de la DB
  public function getNouvelles(){

    $q = "SELECT * FROM nouvelles";
    try {
      $r = $this->db->query($q);
      if($r === FALSE){
        die("getNouvelles Error ".$this->db->errorInfo()[2]." $q\n");
      }
      $res = $r->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'Nouvelle');
    }catch (PDOException $e) {
        die("PDO Error :".$e->getMessage());
    }

    return $res;

  }

  //retourne toutes les nouvelles d'un flux
  public function getNouvellesFlux($flux){

    $q = "SELECT * FROM nouvelles WHERE flux='$flux'";
    try {
      $r = $this->db->query($q);
      if($r === FALSE){
        die("getNouvelles Error ".$this->db->errorInfo()[2]." $q\n");
      }
      $res = $r->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'Nouvelle');
    }catch (PDOException $e) {
        die("PDO Error :".$e->getMessage());
    }

    return $res;

  }

  //retourne tous les flux de la base de données
  public function getAllFlux(){
    $q = "SELECT * FROM flux";
    try {
      $r = $this->db->query($q);
      if($r === FALSE){
        die("getAllFlux Error ".$this->db->errorInfo()[2]." $q\n");
      }
      $res = $r->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'Flux');
    }catch (PDOException $e) {
        die("PDO Error :".$e->getMessage());
    }

    return $res;
  }

  //ajoute un flux à la table flux
  public function ajouterFlux($flux){

    $nbFlux = count($this->db->query("SELECT * FROM flux WHERE url = '$flux'")->fetchAll());

    if($nbFlux == 0){
      $req =$this->db->prepare("INSERT INTO flux(url) VALUES (:url)");
      $res = $req->execute(['url' => $flux]);
      if($req->execute([$flux])){
        return TRUE;
      }
    }else{
      return FALSE;
    }
      return TRUE;
  }

  //Test si utilisateur avec de mot de passe existe
  public function loginOk($login, $mp){
    $q = "SELECT * FROM utilisateurs WHERE login = '$login' AND mp = '$mp'";
    try{
      $r = $this->db->query($q);
      if($r === FALSE){
        die("login OK Error ".$this->db->errorInfo()[2]." $q\n");
      }
      $res = count($r->fetch());

    }catch (PDOException $e) {
        die("PDO Error :".$e->getMessage());
    }

    return $res;
  }

  //permet à un utilisateur de s'abonner à un flux, si le flux n'est pas il est créé
  //si un nouveau est créé
  public function suivreFlux($flux, $login){

    $nbFlux = count($this->db->query("SELECT * FROM flux WHERE url = '$flux'")->fetchAll());

    if($nbFlux == 0){
      $req =$this->db->prepare("INSERT INTO flux(url) VALUES (:url)");
      $res = $req->execute(['url' => $flux]);

      if ($res) {
            $req2 = $this->db->prepare("INSERT INTO flux_utilisateur(flux, login) values(:flux, :login)");
            $req2->execute(['flux'=>$flux, 'login'=>$login]);
        }
    }else{
      $fluxExiste = count($this->db->query("SELECT * FROM flux_utilisateur WHERE flux = '$flux'")->fetchAll());
      if($fluxExiste == 0){
        $req2 = $this->db->prepare("INSERT INTO flux_utilisateur(flux, login) values(:flux, :login)");
        $req2->execute(['flux'=>$flux, 'login'=>$_SESSION['login']]);
        return TRUE;
      }
    }

  }

  //retourne tous les flus associés à un utilisateur
  public function getAllFluxUtilisateur($login){
    $q = "SELECT url FROM flux, flux_utilisateur WHERE flux_utilisateur.login = '$login' AND flux_utilisateur.flux = flux.url";
    try {
      $r = $this->db->query($q);
      if($r === FALSE){
        die("getAllFluxUtilisateur Error ".$this->db->errorInfo()[2]." $q\n");
      }
      $res = $r->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'Flux');
      return $res;
    }catch (PDOException $e) {
        die("PDO Error :".$e->getMessage());
    }

  }

  //retourne toutes les nouvelles pour lesquelles un utilisateur est abonné
  public function getNouvellesUtilisateur($login){
    $q = "SELECT url FROM flux, flux_utilisateur WHERE flux_utilisateur.login = '$login' AND flux_utilisateur.flux = flux.url";

    try {
      $r = $this->db->query($q);

      if($r === FALSE){
        die("getNouvellesUtilisateur Error ".$this->db->errorInfo()[2]." $q\n");
      }
      $res = $r->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'Flux');

      foreach ($res as $flux) {

        $nouvelles[] = $this->extractNouvellesFromFlux(trim($flux->getUrl()));

      }

      return $nouvelles;

    }catch (PDOException $e) {
        die("PDO Error :".$e->getMessage());
    }


  }

  //retourne toutes les nouvelles d'un flux passé en paramètre
  public function extractNouvellesFromFlux($flux){ //retourne un tableau de nouvelle à partir d'un flux
    $req = $this->db->query("SELECT * FROM nouvelles WHERE flux='$flux'");
    $nouvelles = $req->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,"Nouvelle");

    return $nouvelles;
  }

  //supprime le lien entre un flux et un utilisateur
  public function deleteFluxUtilisateur($flux, $login){
    $q = "DELETE FROM flux_utilisateur WHERE flux ='$flux' AND login ='$login'";
    try {
      $r = $this->db->query($q);
      if($r === FALSE){
        die("deleteFlux Error ".$this->db->errorInfo()[2]." $q\n");
      }
    }catch (PDOException $e) {
        die("PDO Error :".$e->getMessage());
    }
  }



}
