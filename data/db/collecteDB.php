<?php

require_once("../../framework/util.php");

$dsn = 'sqlite:newsDB';

try {
    $pdo = new PDO($dsn);
} catch (PDOException $e) {
    die ("Erreur : ".$e->getMessage());
}


$urls = array(
    "https://www.lemonde.fr/rss/une.xml",
    "https://www.lemonde.fr/sciences/rss_full.xml",
    "https://www.lemonde.fr/sport/rss_full.xml",
    "https://www.lemonde.fr/campus/rss_full.xml",
    "https://www.francetvinfo.fr/sports.rss",
    "https://www.telerama.fr/rss/television.xml",
    //"https://www.lefigaro.fr/rss/figaro_politique.xml",
    "https://www.courrierinternational.com/feed/category/6681/rss.xml",
    "http://rss.allocine.fr/ac/actualites/cine?format=xml",
    "https://www.usine-digitale.fr/informatique/rss"
    //"http://radiofrance-podcast.net/podcast09/rss_10212.xml"
);


// sélection d'un flux au hasard
$url = $urls[rand(0, 8)];

//récupération de la totalité du flux
//lire https://www.php.net/manual/fr/function.simplexml-load-file.php
$xml = simplexml_load_file($url);
$titre_flux = $xml->channel->title;

// on récupère les nouvelles du flux
// lire https://www.php.net/manual/fr/simplexmlelement.xpath.php
$nouvelles = $xml->xpath("//item");



// Test si le flux est déjà présent dans la table flux de la base de donnée

$query = $pdo->exec("SELECT * FROM flux WHERE url= '$url'");

if ($query == 0) {

    //Faire un INSERT du flux dans la table flux

    $sql ="INSERT INTO flux VALUES ('$url')";
    try {
        $req = $pdo->prepare($sql);
        $req->execute();
    } catch (PDOException $e) {
        die ("Impossible d'insérer la requête : ".$e->getMessage());
    }

}

foreach ($nouvelles as $nouvelle) {  // On parcourt toutes les nouvelles du flux récupéré au hasard

    // Test si la nouvelle est déjà présente dans la table nouvelles de la base de donnée
    $titre = $pdo->quote($nouvelle->title);
    $verifNom = $pdo->query("SELECT * FROM nouvelles WHERE titre = $titre");
    $desc = $pdo->quote($nouvelle->description);;
    $verifDesc = $pdo->query("SELECT * FROM nouvelles WHERE description = $desc");

    $result1 = $verifNom->fetch();
    $result2 = $verifDesc->fetch();

    $urlImage = getURLImage($nouvelle);
    $ext = extensionImage($urlImage);

    $nbNouvelles = count($pdo->query("SELECT * FROM nouvelles")->fetchAll());

    if(empty($result1 || $result2)){

        // var_dump($nbNouvelles);
        // die();
        $chemin = 'image'.$nbNouvelles.'.'.$ext;
        $sql ="INSERT INTO nouvelles(date, titre, description, lien, image, flux) VALUES ('$nouvelle->pubDate',$titre,
        $desc,'$nouvelle->link','$chemin','$url')";
        try {
            $req = $pdo->prepare($sql);
            $req->execute();
        } catch (PDOException $e) {
            die ("Impossible d'insérer la requête : ".$e->getMessage());
        }

        $url_image = getURLImage($nouvelle);
        if ($url_image != "") {
            $img = '../../view/img/image' . $nbNouvelles .'.'.extensionImage($url_image);
            file_put_contents($img, file_get_contents($url_image));

        }

    }


    //chargement des images, un peu long pour certains flux, à décommenter pour essayer
    //les fonctions getURLImage et extensionImage sont dans util.php



}
