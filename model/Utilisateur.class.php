<?php

class Utilisateur{
    private $login;
    private $password;

    function __construct($login,$mdp){
        $this->login = $login;
        $this->password = $mdp;
    }
}
