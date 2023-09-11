<?php

session_start();

require_once "inc/BD.php";
require_once "php/Authentification.php";

use Authentification\Authentification as Authentification;

$auth = new Authentification();

if (isset($_POST['connecter'])) {

	$courriel = $_POST["Courriel"];
	$motDePasse = $_POST["MotDePasse"];

	$erreur = $auth->connecterUtilisateur($courriel, $motDePasse);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Projet</title>
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<?php
	include "inc/navbar.inc.php";
	?>

	<?php
	if (isset($erreur)) {
		echo '<div class="error-message">' . $erreur . '</div>';
	}
	?>

	<form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post" id="formConnexion">
		<p id="h1Connexion">
			Se connecter
		</p>
		<label for="Courriel">Courriel</label>
		<input id="Courriel" name="Courriel" type="email" placeholder="Adresse e-mail">
		<label for="MotDePasse">Mot De Passe</label>
		<input id="MotDePasse" name="MotDePasse" type="password" placeholder="Mot de passe">
		<a class="hoverConnexionInscription" href="inscription.php">Créer un compte</a>
		<a class="hoverConnexionInscription" href="motDePasseOublie.php">Mot de passe oublié ?</a>
		<button type="submit" name="connecter">Connexion</button>
	</form>
	<?php
	include "inc/footer.inc.php";
	?>
</body>

</html>