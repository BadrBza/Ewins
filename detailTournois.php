<?php
session_start();
require_once "inc/BD.php";
require_once "php/TournoiDAO.php";
require_once "php/Authentification.php";
require_once 'php/rencontre.php';

use TournoiDAO\TournoiDAO as TournoiDAO;
use Authentification\Authentification as Authentification;
use rencontre\rencontre as rencontre;
use inc\BD;

if (isset($_GET['tid']) && is_numeric($_GET['tid'])) {
	$tournoiId = intval($_GET['tid']);

	// Créer une instance de la classe Authentification
	$auth = new Authentification();
	$tournoiDAO = new TournoiDAO();
	$nomTournoi = $tournoiDAO->getTournoiNameByTid($tournoiId);

	// Récupérer les détails du tournoi correspondant à l'ID
	$tournoiDetails = $tournoiDAO->getTournoiDetails($tournoiId);

	// Récupérer les participants avec leurs photos de profil
	$participants = $auth->getPhotosProfilParticipants($tournoiId);
} else {
	// Afficher un message d'erreur si l'ID du tournoi n'est pas valide ou n'est pas passé dans l'URL
	echo "ID du tournoi invalide.";
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
	<section>
		<article>
			<header>
				<p class="h2Connexion">
					Participants
				</p>
			</header>
			<article id="articlePhotoProfil">
				<?php
				// Boucle pour afficher les photos de profil des participants
				foreach ($participants as $participant) {
					$urlPhoto = "uploads/" . $participant['urlPhoto'];

					// Remplacer "uploads/uploads/" par "uploads/" dans l'URL de la photo
					$urlPhoto = str_replace("uploads/uploads/", "uploads/", $urlPhoto);

					echo "<img src=\"$urlPhoto\" alt=\"photo\" width=\"50\" height=\"50\">";
				}
				?>
			</article>
			<article id="sizeul">
				<ul class="ulDetailTournoiJoueur">
					<?php
					// Boucle pour afficher les participants avec leur numéro et nom
					foreach ($participants as $index => $participant) {
						$pseudo = $participant['pseudo'];
						$uid = $participant['uid'];
						echo "<li>
                    <p>Participant " . ($index + 1) . ": $pseudo </p>
                    <form method='post'>
                        <input type='hidden' name='uid' value='$uid' />
                        <input type='hidden' name='tid' value='$tournoiId' />";
						if ($auth->estAdmin()) {
							echo "<button type='submit' name='supprimer'>Supprimer</button>";
						}
						echo "</form></li>";
					}


					?>
					<?php
					if (isset($_POST['supprimer'])) {
						$uid = $_POST['uid'];
						$tournoiId = $_POST['tid'];
						$pseudoParticipant = $auth->getUserNameById($uid);
						echo '<section class="container-validation">
						<h2>Voulez-vous vraiment supprimer le participant ' . $pseudoParticipant . ' du tournoi ' . $nomTournoi . '?</h2>
						<form method="post" class="formulaire">
							<input type="hidden" name="uid" value="' . $uid . '" />
							<input type="hidden" name="tid" value="' . $tournoiId . '" />
							<button type="submit" class="bouton" name="confirmer_suppression" style="width:200px;">Oui</button>
							<button type="submit" class="bouton" name="annuler_suppression" style="width:200px;">Non</button>
						</form>
						</section>';
					}
					?>

					<?php
					if (isset($_POST['confirmer_suppression'])) {
						$uid = $_POST['uid'];
						$tournoiId = $_POST['tid'];

						$mail = $auth->getEmailUser($uid);
						$result = $tournoiDAO->deleteParticipant($tournoiId, $uid);

						if ($result) {
							echo '<p class="result-message"><?php echo $result; ?></p>';
							$envoie = $auth->envoyerEmailGenerale($mail, 'suppression de participation', "Votre participation a été supprimée.");
						} else {
							echo "Erreur lors de la suppression du participant.";
						}
						header("refresh:2;url=detailTournois.php?tid={$tournoiId}");
					}

					if (isset($_POST['annuler_suppression'])) {
						$uid = $_POST['uid'];
						$tid = $_POST['tid'];
						header("location:detailTournois.php?tid=$tid");
						exit();
					}
					?>

					<?php
					if (isset($_POST['genererArbre'])) {
						echo '
						<section class="container-validation">
							<h2>Voulez-vous vraiment générer l\'arbre du tournoi ?</h2>
							<form method="post" class="formulaire">
								<input type="hidden" name="tid" value="" />
								<button type="submit" class="bouton" name="confirmer_generer" style="width:200px;">Oui</button>
								<button type="submit" class="bouton" name="annuler_generer" style="width:200px;">Non</button>
							</form>
						</section>';
					}
					?>

					<?php
					if (isset($_POST['supprimerArbre'])) {
						echo '
						<section class="container-validation">
							<h2>Voulez-vous vraiment générer l\'arbre du tournoi ?</h2>
							<form method="post" class="formulaire">
								<input type="hidden" name="tid" value="" />
								<button type="submit" class="bouton" name="supprimer_arbre" style="width:200px;">Oui</button>
								<button type="submit" class="bouton" name="annuler_supprimerArbre" style="width:200px;">Non</button>
							</form>
						</section>';
					}
					?>

					<?php
					if (isset($_POST['editerScore'])) {
						echo '
					<section class="container-validation">
						<h2>Entrez les scores pour les joueurs</h2>
						<form method="post" class="formulaire">
							<input type="hidden" name="tid" value="" />
							
							<label for="scoreJoueur1">Score du joueur 1:</label>
							<input type="number" id="scoreJoueur1" name="scoreJoueur1" required>
							
							<label for="scoreJoueur2">Score du joueur 2:</label>
							<input type="number" id="scoreJoueur2" name="scoreJoueur2" required>
							
							<button type="submit" class="bouton" name="enregistrer_scores" style="width:200px;">Enregistrer</button>
							<button type="submit" class="bouton" name="annuler_editionScore" style="width:200px;">Annuler</button>
						</form>
					</section>';
					}

					?>

				</ul>
			</article>
		</article>
	</section>
	<article>
		<article class="detail">
			<header>
				<p>
					<?php echo $tournoiDetails['nomTournoi']; ?>
				</p>
			</header>
			<p>
				Sport : <?php echo $tournoiDetails['nomSport']; ?>
			</p>
			<p>
				Nombre de joueurs inscrits : <?php echo $tournoiDetails['nbInscrits']; ?>
			</p>
			<p>
				Les places disponibles : <?php echo $tournoiDetails['placesDisponibles']; ?>
			</p>
			<p>
				Statut : <?php echo $tournoiDetails['nomStatut']; ?>
			</p>
			<p>
				La date du tournoi : <?php echo $tournoiDetails['dateTournois']; ?>
			</p>
			<p>
				La date de fin des inscriptions : <?php echo $tournoiDetails['dateFininscription']; ?>
			</p>
		</article>
		<p id="aSuppModif">
			<?php if ($auth->estAdmin()) { ?>
				<a class=".boutonArbre" href="editerTournoi.php?tid=<?php echo $tournoiId; ?>">Editer le tournoi</a>
		<form method="post" class="boutonArbre-container">
			<button type="submit" name="supprimerArbre" class="boutonArbre">supprimer arbre</button>
			<button type="submit" name="genererArbre" class="boutonArbre">Générer arbre</button>
		</form>
	<?php } ?>

	</p>
	</article>
	<section class="sectionArbre">
		<header>
			<p class="h2Connexion">
				Arbre du tournoi
			</p>
		</header>
		<h3 class="h3">Tournoi : <?php echo htmlspecialchars($nomTournoi); ?></h3>
		<article class="articlePoule">
			<?php
			if (isset($_POST['confirmer_generer'])) {

                $tournoiDAO->updateStatut($tournoiId, 5);

				$participant = new rencontre();
				$listeParticipants = $participant->getAllTournoiParticipant($tournoiId, $message);

				$nombreParticipants = count($listeParticipants);

				if ($nombreParticipants % 2 != 0) {
					// Réservation du dernier participant pour le prochain tour
					$joueurReserve = array_pop($listeParticipants);
					$message .= "Le joueur {$joueurReserve['pseudo']} est réservé pour le prochain tour en raison d'un nombre impair de participants.";
				}

				// Créer des matchs pour tous les participants restants
				for ($i = 0; $i < count($listeParticipants); $i += 2) {
					$joueur1 = $listeParticipants[$i];
					$joueur2 = $listeParticipants[$i + 1];

					$participant->creerRencontre($tournoiId, $joueur1['id'], $joueur2['id']);
			?>
					<article class="articlePoule">
						<article>
							<ul>
								<li>
									<p>Participants : <?php echo $joueur1['pseudo']; ?> vs <?php echo $joueur2['pseudo']; ?></p>
								</li>
								<li>
									<p>Score : </p>
								</li>
								<?php if ($auth->estAdmin()) { ?>
									<li><button type="submit" name="editerScore">editer le score</button></li>
								<?php } ?>
							</ul>
						</article>
					</article>
			<?php

				}
			}
			?>
		</article>
		<h3 class="h3">.</h3>
		<article class="articlePoule">
			<article>
				<ul>
					<li>
						<p>: </p>
					</li>
					<li>
						<p>: </p>
					</li>
					<li>
						<p>:</p>
					</li>
					<?php if ($auth->estAdmin()) { ?>
						<?php if ($auth->estAdmin()) { ?>
							<li><button type="submit" name="editerScore">editer le score</button></li>
						<?php } ?>
					<?php } ?>
				</ul>
			</article>
			<article>
				<ul>
					<li>
						<p>: </p>
					</li>
					<li>
						<p>: </p>
					</li>
					<li>
						<p>: </p>
					</li>
					<?php if ($auth->estAdmin()) { ?>
						<li><button type="submit" name="editerScore">editer le score</button></li>
					<?php } ?>
				</ul>
			</article>
		</article>
		<h3 class="h3">.</h3>
		<article class="articlePoule">
			<article>
				<ul>
					<li>
						<p> : </p>
					</li>
					<li>
						<p> : </p>
					</li>
					<li>
						<p>: </p>
					</li>
					<?php if ($auth->estAdmin()) { ?>
						<li><button type="submit" name="editerScore">editer le score</button></li>
					<?php } ?>
				</ul>
			</article>
		</article>
		<h3 class="h3">Vainqueur</h3>
		<article class="articlePoule">
			<article>
				<ul>
					<li>
						<p> : </p>
					</li>
					<?php if ($auth->estAdmin()) { ?>
						<?php if ($auth->estAdmin()) { ?>
							<li><button type="submit" name="editerScore">editer le score</button></li>
						<?php } ?>
					<?php } ?>
				</ul>
			</article>
		</article>
	</section>
	<?php
	include "inc/footer.inc.php";
	?>
</body>

</html>