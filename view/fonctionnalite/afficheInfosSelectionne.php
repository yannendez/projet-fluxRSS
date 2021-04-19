<?php session_start();?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>affiche infos selectionnées</title>
    <Link rel="StyleSheet" href="../design/design.css" type="text / css" />
  </head>
  <body>
    <header>
      <h1>FeedReader</h1>
    		<p>L'actualité à la carte !</p>

    		<nav>
    			<ul>
    				<li><a href="../../controler/main.ctrl.php">Home</a></li>
    				<li><a href="../../controler/suivreFlux.ctrl.php">S'abonner à un flux</a></li>
    				<li><a href="../../controler/logout.ctrl.php">Déconnexion</a></li>

    			</ul>
    		</nav>
    </header>
<?php


//lien avec la base de donnée
if(isset($_SESSION['login'])){
try{
    $pdo = new PDO('sqlite:../../data/db/newsDB');
}
catch(PDOException $e){
    die("Erreur : ".$e->getMessage());
}
//importe la class Nouvelle
require_once('../../model/Nouvelle.class.php');

//récuperer les infos
$login = $_SESSION['login'];


$req = $pdo->query("SELECT flux FROM flux_utilisateur where login='$login'");
$allFLux = $req->fetchAll(PDO::FETCH_ASSOC);
$FLUX = array();
foreach($allFLux as $flux){
    $string=$flux['flux'];

    $query = "SELECT * FROM nouvelles WHERE flux = '$string'";
    $req = $pdo->query($query);
    $FLUX["$string"] = $req->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Nouvelle');
    $verif = count($FLUX);
    if($verif == 0){
        echo "<p> Il n'y pas a pas de nouvelle pour le flux $string </p>";
    }

    else{
        foreach($FLUX as $nouvelles){
            foreach($nouvelles as $nouvelle){
                    echo "<section class=\"select\">";
                if(isset($_GET["titre"])){
                    echo "<H3>".$nouvelle->getTitre()."</H3>";
                }
                if(isset($_GET["image"])){
                    echo "<p><img src=\"../view/images/".$nouvelle->getImage()."\" alt=\"image random\"/></p>";
                }

                if(isset($_GET["lien"])){
                    echo "<a href='".$nouvelle->getLien()."'>".$nouvelle->getLien()."</a>";
                }

                if(isset($_GET["description"])){
                    echo "<p>".$nouvelle->getDescription()."</p>";
                }
                echo "</section>";
            }

        }
    }



}



//var_dump($nouvelles);


}else{
    header('Location: ../index.html');
}

?>

</body>
</html>
