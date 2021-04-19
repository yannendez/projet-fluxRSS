<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <Link rel="StyleSheet" href="../design/design.css" type="text / css" />
  <title>Affiche nouvelle par mot clé</title>
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
if(isset($_SESSION['login'])){
//importer le modele nouvelle
  require_once('../../model/Nouvelle.class.php');

  $dsn = 'sqlite:../../data/db/newsDB';

  try {
      $pdo = new PDO($dsn);
  } catch (PDOException $e) {
      die("Erreur : ".$e->getMessage());
  }

  // SELECT * FROM nouvelles WHERE titre LIKE '%$keyWord%'"

  $login = $_SESSION['login'];
  $keyWord = $_GET["keyWord"];

  $req = $pdo->query("SELECT flux FROM flux_utilisateur WHERE login='$login'");
  $allFlux = $req->fetchAll(PDO::FETCH_ASSOC);


  foreach ($allFlux as $flux) {
      $string=$flux['flux'];

      $query = "SELECT * FROM nouvelles WHERE flux = '$string' AND titre LIKE '%$keyWord%'";
      $req = $pdo->query($query);
      $allNouvelles = $req->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Nouvelle');

  ?>
      <?php if (!empty($allNouvelles)): ?>
      <p id="titre">Voici les nouvelles trouvées pour <?=$keyWord?> pour le flux : <?=$string?> </p>
      <ol>
        <?php foreach ($allNouvelles as $nouvelle): ?>
        <li> <details> <summary> <strong><?= $nouvelle->getTitre() ?></strong></summary>
            <section>
            <p><?=$nouvelle->getDate()?></p>
            <p> <img src='../images/<?= $nouvelle->getImage()?>' alt="Image Indisponible" width="300" heigth="150"></p>
            <p><?=$nouvelle->getDescription()?></p>
            <p><a href="<?=$nouvelle->getLien()?>">Voir Article Complet</a></p>
            </section>
            </details></li>
        <?php endforeach ?>
      </ol>

    <?php endif; ?>

    <?php
  }else{
    header('Location: ../../index.html');
  }
    ?>

</body>
</html>
