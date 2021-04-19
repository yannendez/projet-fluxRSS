
<?php session_start();?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/master.css">
    <title>Supprimer flux</title>
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

//verification de connexion
if(isset($_SESSION['login'])){
//lien avec la base de donnée
try{
    $pdo = new PDO('sqlite:../../data/db/newsDB');
}
catch(PDOException $e){
    die("Erreur : ".$e->getMessage());
}

//recupère les informations
$login = $_SESSION['login'];
$flux = $_GET['Flux'];

//test si le flux existe
$nbFlux = count($pdo->query("SELECT * FROM flux_utilisateur WHERE flux = '$flux' AND login='$login'")->fetchAll());
if($nbFlux != 0){
    $req =$pdo->prepare("DELETE FROM flux_utilisateur where flux=:flux AND login=:login");
    $res = $req->execute(['flux'=>$flux, 'login'=>$login]);
    echo "<p> le flux".$flux." à bien été supprimée</p>";
    header('Location: ../../controler/main.ctrl.php');
}
else{
    echo "<p>le flux ".$flux." n'existe pas</p>";
    header('Location: ../../controler/main.ctrl.php');
}
}else{
    header('Location: ../index.html');
}
?>

</body>
</html>
