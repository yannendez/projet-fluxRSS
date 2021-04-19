<?php

require_once("Flux.class.php");

class Nouvelle{
    private int $id;
    private string $date;
    private string $titre;
    private string $description;
    private string $lien;
    private string $image;
    private string $flux;


     function __construct(int $id=0,string $date='',string $titre='',string $description='',string $lien='',string $image='',string $flux=''){
        $this->id = $id;
        $this->date = $date;
        $this->titre = $titre;
        $this->description = $description;
        $this->lien = $lien;
        $this->image = $image;
        $this->flux = $flux;

    }

  public function  getTitre() {
    return $this->titre;
  }

  public function  getImage() {
    return $this->image;
  }

  public function getDate(){
    return $this->date;
  }

  public function getDescription(){
    return $this->description;
  }

  public function getLien(){
    return $this->lien;
  }

  public function getFlux(){
    return $this->flux;
  }


}

?>
