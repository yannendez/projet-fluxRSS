<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <Link rel="StyleSheet" href="../view/design/design.css" type="text / css" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

<div id="ajout">
<form  action='../controler/suivreFlux.ctrl.php' method="GET">
    <label for="flux">Quel flux voulez vous ajouter ?</label>
    <input type="text" id="flux"  name="flux">
    <input type="submit" value="Ajouter l'url du flux">
</form>
</div>

<div id="defaut">
  <h3>Voici des flux par défauts auxquels vous pouvez vous abonner :</h3>
  <ul>
    <?php foreach ($this->flux as $flux): ?>
      <li><a href="../controler/suivreFlux.ctrl.php?flux=<?=$flux->getUrl()?>"><?=$flux->getUrl()?></a></li>
    <?php endforeach ?>
  </ul>
</div>
</body>
</html>
