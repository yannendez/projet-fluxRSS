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

    <div id="flux">
    <div id="fluxuser">
      <h2>Les flux que vous suivez</h2>
      <ul>
          <?php foreach ($this->flux as $flux): ?>
            <li><a href="../controler/nouvellesflux.ctrl.php?flux=<?=$flux->getUrl()?>"><?=$flux->getUrl()?></a></li>
          <?php endforeach ?>
      </ul>
    </div>
          <div id="key">
            <form action='../view/fonctionnalite/afficheNouvellesKey.php' method="GET">
              <h4>Chercher des nouvelles par mots clé</h4>
              <input id="Flux"  name="keyWord" required>
              <input type="submit" value="Chercher Nouvelles">
            </form>
          </div>
          <div id="choix">
            <form action="../view/fonctionnalite/afficheInfosSelectionne.php" method="GET">
              <legend>Selectionnez les informations que vous souhaitez afficher</legend>
              <label for="titre">Titre</label>
              <input type="checkbox" id="titre" name="titre"><br>
              <label for="image">Image</label>
              <input type="checkbox" id="image" name="image"><br>
              <label for="lien">Lien</label>
              <input type="checkbox" name="lien" id="lien"><br>
              <label for="description">Description</label>
              <input type="checkbox" name="description" id="description"><br>
              <input type="submit" value="afficher">
            </form>
          </div>
          <div id="delete">
            <form action='../view/fonctionnalite/supprimer_flux.php' method="GET">
              <legend>Supprimer un flux</legend>
              <label for="Flux">Veuillez insérer l'url</label>
              <input type="text" id="Flux" name="Flux">
              <input type="submit" value="supprimer le flux">
            </form>


          </div>
    </div>


    <div id="nouvelles">
      <h2>Les dernières News du quotidien :</h2>
      <ol>
        <?php foreach($this->nouvelles as $abc):?>
            <?php foreach ($abc as $nouvelle): ?>

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
          <?php endforeach ?>
      </ol>
    </div>

  </div>

</body>
</html>
