<?php

require_once("util.php");
require_once("../model/Flux.class.php");

$dsn = 'sqlite:../data/db/newsDB';

try {
    $pdo = new PDO($dsn);
} catch (PDOException $e) {
    die ("Erreur : ".$e->getMessage());
}



//récupération de la totalité du flux
$xml = simplexml_load_file($flux);

// on récupère les nouvelles du flux
$nouvelles = $xml->xpath("//item");

foreach ($nouvelles as $nouvelle) {  // On parcourt toutes les nouvelles du flux récupéré au hasard

    // Test si la nouvelle est déjà présente dans la table nouvelles de la base de donnée
    $titre = $pdo->quote($nouvelle->title);
    $verifNom = $pdo->query("SELECT * FROM nouvelles WHERE titre = $titre");
    $desc = $pdo->quote($nouvelle->description);;
    $verifDesc = $pdo->query("SELECT * FROM nouvelles WHERE description = $desc");

    $result1 = $verifNom->fetch();
    $result2 = $verifDesc->fetch();

    $url_image = getURLImage($nouvelle);
    $ext = extensionImage($url_image);
    $nbNouvelles = count($pdo->query("SELECT * FROM nouvelles")->fetchAll());

    if(empty($result1 && $result2)){


        $ext = 'image'.$nbNouvelles.'.'.$ext;

        $sql ="INSERT INTO nouvelles(date, titre, description, lien, image, flux) VALUES ('$nouvelle->pubDate',$titre,
        $desc,'$nouvelle->link','$ext','$flux')";
        try {
            $req = $pdo->prepare($sql);
            $req->execute();
        } catch (PDOException $e) {
            die ("Impossible d'insérer la requête : ".$e->getMessage());
        }
    }


    //chargement des images, un peu long pour certains flux, à décommenter pour essayer
    //les fonctions getURLImage et extensionImage sont dans util.php


    if ($url_image != "") {
        $img = '../view/img/image' . $nbNouvelles .'.'.extensionImage($url_image);
        file_put_contents($img, file_get_contents($url_image));
    }

}

?>
