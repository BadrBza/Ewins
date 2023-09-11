<?php

namespace rencontre;

use inc\BD;
use Exception;

class rencontre
{
    private $connexion;

    function __construct() {
        $this->connexion = new BD();
    }


    public function getAllTournoiParticipant($tid, &$message)  {
        $participants = array();
        $link = $this->connexion->conn;

        if ($link->connect_error) {
            $message .= 'Connect Error (' . $link->connect_errno . ') ' . $link->connect_error;
        } else {
            $query = "SELECT u.uid, u.pseudo FROM participer p JOIN utilisateur u ON p.uid = u.uid WHERE p.tid = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("i", $tid);

            if ($stmt->execute()) {
                $res = $stmt->get_result();
                while ($row = $res->fetch_assoc()) {
                    array_push($participants, ['id' => $row['uid'], 'pseudo' => $row['pseudo']]);
                }
            } else {
                $message .= $stmt->error;
            }

            $stmt->close();
        }

        return $participants;
    }


    public function creerRencontre($tid, $joueur1, $joueur2) {
        $link = $this->connexion->conn;

        $query = "INSERT INTO rencontre (tid, joueur1, joueur2, scoreJ1, scoreJ2, rid_suivant) VALUES (?, ?, ?, NULL, NULL, NULL)";
        $stmt = $link->prepare($query);
        $stmt->bind_param("iii", $tid, $joueur1, $joueur2);

        if (!$stmt->execute()) {
            return false;
        }

        $stmt->close();
        return true;
    }

    public function enregistrerScore($rid, $scoreJ1, $scoreJ2, $gagnant)   {
        try {
            $stmt = $this->connexion->conn->prepare("UPDATE rencontre SET scoreJ1 = ?, scoreJ2 = ?, id_vainqueur = ? WHERE rid = ?");
            $stmt->bind_param("iiii", $scoreJ1, $scoreJ2, $gagnant, $rid);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function tousLesScoresEntres($tournoiId) {
        try {
            $stmt = $this->connexion->conn->prepare("SELECT * FROM rencontre WHERE tid = ? AND (scoreJ1 IS NULL OR scoreJ2 IS NULL)");
            $stmt->bind_param("i", $tournoiId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows === 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function genererProchainTour($tournoiId)  {
        $gagnants = [];
        try {
            $stmt = $this->connexion->conn->prepare("SELECT id_vainqueur FROM rencontre WHERE tid = ?");
            $stmt->bind_param("i", $tournoiId);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $gagnants[] = $row['id_vainqueur'];
            }

            for ($i = 0; $i < count($gagnants); $i += 2) {
                $joueur1 = $gagnants[$i];
                $joueur2 = isset($gagnants[$i + 1]) ? $gagnants[$i + 1] : NULL;
                // Si un nombre impair de gagnants, le second joueur peut être NULL

                $stmtInsert = $this->connexion->conn->prepare("INSERT INTO rencontre (tid, joueur1, joueur2) VALUES (?, ?, ?)");
                $stmtInsert->bind_param("iii", $tournoiId, $joueur1, $joueur2);
                $stmtInsert->execute();
            }

            return true;
        } catch (Exception $e) {
            // Gérer l'exception comme vous le souhaitez
            return false;
        }
    }
}
