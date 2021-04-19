<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <Link rel="StyleSheet" href="../view/design/design.css" type="text / css" />
  <title>FeedReader</title>
</head>
<body>

<header>
  <h1>FeedReader</h1>
		<p>L'actualité à la carte !</p>

		<nav>
			<ul>
				<li><a href="../controler/main.ctrl.php">Home</a></li>
				<li><a href="../controler/suivreFlux.ctrl.php">S'abonner à un flux</a></li>
				<li><a href="../controler/logout.ctrl.php">Déconnexion</a></li>

			</ul>
		</nav>
</header>

  <div id="container">



    <div id="nouvelles">
      <h2>Les nouvelles de  : <?=$_GET['flux']?></h2>
      <ol>
        <?php foreach ($this->nouvelles as $nouvelle): ?>

        <li>
          <details>
           <summary>
             <strong><?= $nouvelle->getTitre() ?></strong></summary>
            <section>
              <p><?=$nouvelle->getDate()?></p>
              <p> <img src='../view/img/<?= $nouvelle->getImage()?>' alt="Image Indisponible" width="300" heigth="150"></p>
              <p><?=$nouvelle->getDescription()?></p>
              <p><a href="<?=$nouvelle->getLien()?>">Voir Article Complet</a></p>
            </section>
            </details>
          </li>
          <?php endforeach ?>
      </ol>
    </div>

  </div>

</body>
</html>
