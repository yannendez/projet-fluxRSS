<?php
    require_once("Flux.class.php");
    require_once("Utilisateur.class.php");


    class FluxUtilisateur{
        private $utilisateur;
        private $flux;
        private $nom;
        private $categorie;

        public function __construct(Utilisateur $utilisteur, Flux $flux, $nom, $categorie=""){
            $this->utilisateur = $utilisateur;
            $this->flux = $flux;
            $this->nom =  $nom;
            $this->categorie = $categorie;
        }
    }


?>
