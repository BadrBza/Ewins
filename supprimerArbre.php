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
	<section>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
			<p>
				Voulez-vous supprimer cette arbre ?
			</p>
			<button type="submit" name="rejoindreTournoi" value="oui">Supprimer</button>
			<button type="submit" name="annulerRejoindreTournoi" value="non">Annuler</button>
		</form>
	</section>
	<?php
	include "inc/footer.inc.php";
	?>
</body>

</html>