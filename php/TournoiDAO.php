<?php

namespace TournoiDAO;

use inc\BD;
use Exception;

class TournoiDAO
{
	private $connexion;

	function __construct()
	{
		$this->connexion = new BD();
	}

	function getDerniersTournois()
	{
		$sql = "SELECT tournoi.tid, tournoi.nom, tournoi.sid, sport.nom AS sport, tournoi.placesDisponibles, statut.nom AS statut, tournoi.dateTournois, tournoi.dateFininscription, COUNT(participer.tid) AS nbInscrits 
				FROM tournoi 
				INNER JOIN sport ON tournoi.sid = sport.sid 
				INNER JOIN statut ON tournoi.id_statut = statut.id_statut
				LEFT JOIN participer ON tournoi.tid = participer.tid
				WHERE tournoi.estActif = 1 
				GROUP BY tournoi.tid
				ORDER BY tournoi.tid DESC LIMIT 5;";

		$result = $this->connexion->query($sql);
		$tournois = [];
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$tournois[] = $row;
			}
		}

		return $tournois;
	}

	public function getSportImage($sid)
	{
		$sportImages = array(
			1 => 'Echec.jpg',
			2 => 'Fifa.jpg',
			3 => 'Belotte.png',
			4 => 'Tennis.jpg',
			5 => 'Ping-Pong.jpg'
		);

		if (isset($sportImages[$sid])) {
			return $sportImages[$sid];
		} else {
			return 'imageNotFind.jpg';
		}
	}


	public function afficherTournoisFiltres($statut, $sport, $uid)
	{
		$connexion = new BD();

		if (isset($_POST['recherche'])) {
			$statut = $_POST['statut'];
			$sport = $_POST['sport'];
		}

		$sql = "SELECT t.tid, t.nom, t.placesDisponibles, t.dateTournois, t.dateFininscription, st.nom AS statut_nom, sp.nom AS sport_nom ,t.id_statut, t.sid 
		FROM tournoi t 
		JOIN statut st ON t.id_statut = st.id_statut 
		JOIN sport sp ON t.sid = sp.sid 
		WHERE st.nom LIKE '%$statut%' AND sp.nom LIKE '%$sport%' AND t.estActif = 1";

		if (!isset($_SESSION['uid'])) {
			header("Location: seConnecter.php");
			exit;
		}
		$result = $connexion->query($sql);
		$tournois = [];

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$tournois[] = $row;
			}
		}
		return $tournois;
	}


	public function afficherTournoisInscrit($uid)
	{

		$connexion = new BD();

		if (isset($_POST['rechercheMy'])) {

			$sql = "SELECT t.tid, t.nom, t.placesDisponibles, t.dateTournois, t.dateFininscription, 
               st.nom AS statut_nom, sp.nom AS sport_nom 
        FROM tournoi t 
        JOIN statut st ON t.id_statut = st.id_statut 
        JOIN sport sp ON t.sid = sp.sid 
        JOIN participer p ON t.tid = p.tid 
        JOIN utilisateur u ON p.uid = u.uid 
        WHERE (st.nom LIKE 'Terminé' 
           OR st.nom LIKE 'Ouvert' 
           OR st.nom LIKE 'Fermer'
           OR st.nom LIKE 'Clôturé' 
           OR st.nom LIKE 'Généré' 
           OR st.nom LIKE 'En cours') 
          AND p.uid = $uid 
          AND t.estActif = 1";
		}
		if (!isset($_SESSION['uid'])) {
			header("Location: seConnecter.php");
			exit;
		}
		$result = $connexion->query($sql);
		$tournois = [];

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$tournois[] = $row;
			}
		}

		return $tournois;
	}




	public function ajouterTournoi($nom, $sport, $placeDispo = 10, $statut, $dateTournoi, $dateFinInscription)
	{

		if (strtotime($dateFinInscription) >= strtotime($dateTournoi)) {
			return "La date de fin d'inscription doit être inférieure à la date du tournoi.";
		}

		if ($placeDispo < 2) {
			return "Le nombre de places disponibles ne peut pas être inférieur à 2.";
		}

		$requete_sport = "SELECT sid FROM sport WHERE nom = ?";
		$stmt_sport = $this->connexion->conn->prepare($requete_sport);
		$stmt_sport->bind_param("s", $sport);
		$stmt_sport->execute();
		$resultat_sport = $stmt_sport->get_result();

		$requete_statut = "SELECT id_statut FROM statut WHERE nom = ?";
		$stmt_statut = $this->connexion->conn->prepare($requete_statut);
		$stmt_statut->bind_param("s", $statut);
		$stmt_statut->execute();
		$resultat_statut = $stmt_statut->get_result();

		if ($resultat_sport && $resultat_sport->num_rows > 0 && $resultat_statut && $resultat_statut->num_rows > 0) {
			$ligne_sport = $resultat_sport->fetch_assoc();
			$sid = $ligne_sport["sid"];

			$ligne_statut = $resultat_statut->fetch_assoc();
			$id_statut = $ligne_statut["id_statut"];

			$requete = "INSERT INTO tournoi (nom, sid, placesDisponibles, id_statut, dateTournois, dateFininscription, estActif, id_organisateur) VALUES (?, ?, ?, ?, ?, ?, 1, 1)";
			$stmt = $this->connexion->conn->prepare($requete);
			$stmt->bind_param("siisss", $nom, $sid, $placeDispo, $id_statut, $dateTournoi, $dateFinInscription);

			if ($stmt->execute()) {
				return true;
			} else {
				return "Une erreur s'est produite : " . $stmt->error;
			}
		} else {
			return "Le sport ou le statut sélectionné n'existe pas.";
		}
	}



	public function afficherTousTournois()
	{
		$requete = "SELECT tournoi.*, sport.nom as sport_nom, statut.nom as statut_nom 
					FROM tournoi 
					INNER JOIN sport ON tournoi.sid = sport.sid
					INNER JOIN statut ON tournoi.id_statut = statut.id_statut
					WHERE tournoi.estActif = 1
					ORDER BY tournoi.dateTournois DESC"; // Tri par dateTournois en ordre décroissant (du plus récent au plus ancien)

		$resultat = $this->connexion->query($requete);
		$tournois = array();

		if ($resultat && $resultat->num_rows > 0) {
			while ($row = $resultat->fetch_assoc()) {
				$tournois[] = $row;
			}
		}
		return $tournois;
	}



	public function getNombreParticipants($tid)
	{
		$requete = "SELECT COUNT(*) AS nombreParticipants FROM participer WHERE tid = ?";
		$stmt = $this->connexion->conn->prepare($requete);
		$stmt->bind_param("i", $tid);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result && $result->num_rows === 1) {
			$row = $result->fetch_assoc();
			return $row['nombreParticipants'];
		}

		return 0; // Renvoie 0 si le tournoi n'a aucun participant
	}

	public function getTournoiDetails($tid)
	{

		$sql = "SELECT tournoi.tid, tournoi.nom AS nomTournoi, sport.nom AS nomSport, COUNT(participer.tid) AS nbInscrits, tournoi.placesDisponibles, 
        statut.nom AS nomStatut, tournoi.dateTournois, tournoi.dateFininscription, tournoi.estActif
        FROM tournoi 
        INNER JOIN sport ON tournoi.sid = sport.sid 
        INNER JOIN statut ON tournoi.id_statut = statut.id_statut
        LEFT JOIN participer ON tournoi.tid = participer.tid
        WHERE tournoi.tid = ?
        GROUP BY tournoi.tid, tournoi.nom, sport.nom, statut.nom, tournoi.placesDisponibles, tournoi.dateTournois, tournoi.dateFininscription, tournoi.estActif";

		$stmt = $this->connexion->conn->prepare($sql);

		if (!$stmt) {
			die("Erreur de préparation de la requête : " . $this->connexion->conn->error);
		}

		$stmt->bind_param("i", $tid);

		$stmt->execute();

		$result = $stmt->get_result();

		$row = $result->fetch_assoc();

		$stmt->close();

		return $row;
	}


	public function getTournoiById($tid)
	{

		$sql = "SELECT * FROM tournoi WHERE tid = ?";
		$stmt = $this->connexion->conn->prepare($sql);

		if ($stmt) {
			$stmt->bind_param("i", $tid);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$tournoi = $result->fetch_assoc();
				return $tournoi;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}


	public function modifierTournoi($tid, $nom, $sport, $placeDispo = 10, $statut, $dateDebut, $dateFin)
	{

		if (strtotime($dateFin) >= strtotime($dateDebut)) {
			return "La date de fin d'inscription doit être inférieure à la date du tournoi.";
		}

		if ($placeDispo < 2) {
			return "Le nombre de places disponibles ne peut pas être inférieur à 2.";
		}

		$requete_sport = "SELECT sid FROM sport WHERE nom = ?";
		$stmt_sport = $this->connexion->conn->prepare($requete_sport);
		$stmt_sport->bind_param("s", $sport);
		$stmt_sport->execute();
		$resultat_sport = $stmt_sport->get_result();

		$requete_statut = "SELECT id_statut FROM statut WHERE nom = ?";
		$stmt_statut = $this->connexion->conn->prepare($requete_statut);
		$stmt_statut->bind_param("s", $statut);
		$stmt_statut->execute();
		$resultat_statut = $stmt_statut->get_result();

		if ($resultat_sport && $resultat_sport->num_rows > 0 && $resultat_statut && $resultat_statut->num_rows > 0) {
			$ligne_sport = $resultat_sport->fetch_assoc();
			$sid = $ligne_sport["sid"];

			$ligne_statut = $resultat_statut->fetch_assoc();
			$id_statut = $ligne_statut["id_statut"];

			$requete = "UPDATE tournoi SET nom = ?, sid = ?, placesDisponibles = ?, id_statut = ?, dateTournois = ?, dateFininscription = ? WHERE tid = ?";
			$stmt = $this->connexion->conn->prepare($requete);
			$stmt->bind_param("siisssi", $nom, $sid, $placeDispo, $id_statut, $dateDebut, $dateFin, $tid);

			if ($stmt->execute()) {
				return "Le tournoi a été modifié avec succès.";
			} else {
				return "Une erreur s'est produite : " . $stmt->error;
			}
		} else {
			return "Le sport ou le statut sélectionné n'existe pas.";
		}
	}



	public function genererTournoi($tid)
	{

		$stmt = $this->connexion->conn->prepare('SELECT uid FROM participer WHERE tid = ?');
		$stmt->bind_param('i', $tid);
		$stmt->execute();
		$result = $stmt->get_result();
		$participants = $result->fetch_all(MYSQLI_ASSOC);

		$x = count($participants);
		$y = ceil(log($x, 2));

		$totalRencontres = pow(2, $y) - 1;

		$rencontresPremierTour = pow(2, $y - 1);
		for ($i = 0; $i < $rencontresPremierTour; $i++) {

			$joueur1 = array_shift($participants);

			$rid_suivant = ceil($i / 2) + pow(2, $y - 1);

			$stmt = $this->connexion->conn->prepare('INSERT INTO rencontre (tid, joueur1, rid_suivant) VALUES (?, ?, ?)');
			$stmt->bind_param('iii', $tid, $joueur1, $rid_suivant);
			$stmt->execute();
		}

		$stmt = $this->connexion->conn->prepare('SELECT rid FROM rencontre WHERE tid = ? AND joueur2 IS NULL');
		$stmt->bind_param('i', $tid);
		$stmt->execute();
		$result = $stmt->get_result();
		$rencontres = $result->fetch_all(MYSQLI_ASSOC);
		foreach ($rencontres as $rencontre) {
			$joueur2 = array_shift($participants);
			if ($joueur2 === null) {
				break;
			}
			$stmt = $this->connexion->conn->prepare('UPDATE rencontre SET joueur2 = ? WHERE rid = ?');
			$stmt->bind_param('ii', $joueur2, $rencontre['rid']);
			$stmt->execute();
		}
	}


	public function deleteParticipant($tid, $uid)
	{
		$requete = "SELECT id_statut FROM tournoi WHERE tid = ?";
		$stmt = $this->connexion->conn->prepare($requete);
		$stmt->bind_param("i", $tid);
		$stmt->execute();
		$resultat = $stmt->get_result();

		if ($resultat->num_rows == 1) {
			$row = $resultat->fetch_assoc();
			$id_statut = $row['id_statut'];

			if ($id_statut == 1) {
				$this->connexion->conn->begin_transaction();

				try {
					$stmt = $this->connexion->conn->prepare("DELETE FROM participer WHERE uid = ? AND tid = ?");

					$stmt->bind_param("ii", $uid, $tid);

					$result = $stmt->execute();

					$stmt->close();

					if ($result) {
						$stmt = $this->connexion->conn->prepare("UPDATE tournoi SET placesDisponibles = placesDisponibles + 1 WHERE tid = ?");
						$stmt->bind_param("i", $tid);
						$stmt->execute();
						$stmt->close();

						$this->connexion->conn->commit();

						return "Le participant a été supprimé avec succès du tournoi.";
					} else {
						$this->connexion->conn->rollback();
						return "Une erreur s'est produite lors de la suppression du participant du tournoi.";
					}
				} catch (Exception $e) {
					$this->connexion->conn->rollback();
					return "Une erreur s'est produite lors de la suppression du participant du tournoi : " . $e->getMessage();
				}
			} else {
				return "Impossible de supprimer le participant car le statut du tournoi n'est pas 'Ouvert'.";
			}
		} else {
			return "Le tournoi spécifié n'existe pas.";
		}
	}



	public function getNomTournoi($tid)
	{
		$requete = "SELECT nom FROM tournoi WHERE tid = ?";
		$stmt = $this->connexion->conn->prepare($requete);
		$stmt->bind_param("i", $tid);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			return $row['nom'];
		} else {
			return null; // Si aucun tournoi n'a été trouvé avec cet ID
		}
	}


	public function setTournoiInactive($tid)
	{
		$statusTerminated = 3;
		$statusInProgress = 4;

		// Vérifiez d'abord combien de participants sont inscrits à ce tournoi
		$checkParticipantsStmt = $this->connexion->conn->prepare("SELECT COUNT(*) AS nbParticipants FROM participer WHERE tid = ?");
		$checkParticipantsStmt->bind_param("i", $tid);
		$checkParticipantsStmt->execute();
		$resultParticipants = $checkParticipantsStmt->get_result();
		$participantsRow = $resultParticipants->fetch_assoc();
		$nbParticipants = $participantsRow['nbParticipants'];
		$checkParticipantsStmt->close();

		if ($nbParticipants > 0) {
			return "participantsExist";
		}

		$checkStatusStmt = $this->connexion->conn->prepare("SELECT id_statut FROM tournoi WHERE tid = ?");
		$checkStatusStmt->bind_param("i", $tid);
		if (!$checkStatusStmt->execute()) {
			error_log("Erreur lors de la vérification du statut: " . $checkStatusStmt->error);
			return false;
		}
		$resultStatus = $checkStatusStmt->get_result();

		if ($row = $resultStatus->fetch_assoc()) {
			$currentStatus = $row['id_statut'];
			$checkStatusStmt->close();

			if ($currentStatus == $statusInProgress) {
				return "inProgress";
			}

			if ($currentStatus != $statusTerminated) {
				return false;
			}
		} else {
			$checkStatusStmt->close();
			error_log("Tournoi avec tid = $tid non trouvé.");
			return false;
		}

		$updateStmt = $this->connexion->conn->prepare("UPDATE tournoi SET estActif = 0 WHERE tid = ?");
		$updateStmt->bind_param("i", $tid);
		if (!$updateStmt->execute()) {
			error_log("Erreur lors de la mise à jour du tournoi: " . $updateStmt->error);
			$updateStmt->close();
			return false;
		}
		$updateStmt->close();

		return true;
	}



	public function gererStatutTournoi($tid)
	{
		$tournoi = $this->getTournoiById($tid);
		$placesDisponibles = $tournoi['placesDisponibles'];
		$dateFinInscription = strtotime($tournoi['dateFininscription']);
		$dateActuelle = time();

		if ($placesDisponibles == 0) {
			$this->updateStatut($tid, 2);
			return;
		}

		if ($dateActuelle > $dateFinInscription) {
			$this->updateStatut($tid, 6);
			return;
		}
	}

	public function updateStatut($tid, $statut)
	{
		$requete = "UPDATE tournoi SET id_statut = ? WHERE tid = ?";
		$stmt = $this->connexion->conn->prepare($requete);
		$stmt->bind_param("si", $statut, $tid);

		$resultat = $stmt->execute();

		$stmt->close();

		return $resultat;
	}


	public function getListeTournoisActifs()
	{
		$requete = "SELECT * FROM tournoi WHERE estActif = 1";
		$resultat = $this->connexion->query($requete);

		$listeTournois = [];

		if ($resultat->num_rows > 0) {
			while ($row = $resultat->fetch_assoc()) {
				$listeTournois[] = $row;
			}
		}

		return $listeTournois;
	}


	public function gererStatutTournoisTous()
	{
		$listeTournois = $this->getListeTournoisActifs();

		foreach ($listeTournois as $tournoi) {
			$tid = $tournoi['tid'];
			$this->gererStatutTournoi($tid);
		}
	}

	public function getTournoiNameByTid($tid) {
		$requete = "SELECT nom FROM tournoi WHERE tid = ?";
		$stmt = $this->connexion->conn->prepare($requete);
		$stmt->bind_param("i", $tid);  // "i" signifie que $tid est un entier (integer)
		$stmt->execute();
		$resultat = $stmt->get_result();
		$row = $resultat->fetch_assoc();
		
		// Si un résultat est trouvé, renvoie le nom du tournoi, sinon renvoie null
		return $row ? $row['nom'] : null;
	}
	
}
