<?php
require_once "inc/bd.php";


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
	<main>
		<form>
			<section class="sectionScore">
				<h2>Participant x:</h2>
				<input class="EntrerPoint" name="score" required type="text" placeholder="Vainqueur">
				<span class="required-field">*</span>
				<button id="buttonScore" type="submit" name="Se connecter">Confirmer</button>
			</section>
		</form>
		<?php
		include "inc/footer.inc.php";
		?>


	</main>

</html>