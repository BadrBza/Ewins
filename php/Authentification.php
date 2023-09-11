<?php

namespace Authentification;

use inc\BD;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

class Authentification
{ // utilisateur 

    private $connexion;

    function __construct()
    {
        $this->connexion = new BD();
    }




    public function connecterUtilisateur($courriel, $motDePasse)
    {
        if (!filter_var($courriel, FILTER_VALIDATE_EMAIL)) {
            return "Adresse e-mail invalide";
        }

        $requete = "SELECT * FROM utilisateur WHERE courriel = ?";
        $stmt = $this->connexion->conn->prepare($requete);
        $stmt->bind_param("s", $courriel);
        $stmt->execute();
        $resultat = $stmt->get_result();

        if ($resultat->num_rows == 1) {
            $utilisateur = $resultat->fetch_assoc();

            if ($utilisateur['estActif'] == true) {
                if (password_verify($motDePasse, $utilisateur['mdp'])) {
                    $_SESSION['uid'] = $utilisateur['uid'];
                    $_SESSION['nom'] = $utilisateur['nom'];
                    $_SESSION['prenom'] = $utilisateur['prenom'];
                    $_SESSION['pseudo'] = $utilisateur['pseudo'];
                    $_SESSION['courriel'] = $utilisateur['courriel'];
                    $_SESSION['admin'] = $utilisateur['estOrganisateur'];
                    $_SESSION['pdp'] = $utilisateur['urlPhoto'];
                    setcookie('nom', $utilisateur['nom'], time() + 3600); // cookie valable 1 heure
                    setcookie('prenom', $utilisateur['prenom'], time() + 3600);
                    header("Location:index.php?admin=" . $utilisateur['estOrganisateur']);
                } else {
                    return "Adresse e-mail ou mot de passe incorrect";
                }
            } else {
                if (!$utilisateur['estActif']) {
                    $cleReactivation = self::generateToken(32);

                    $requete = "INSERT INTO token (courriel, cle) VALUES (?, ?)";
                    $stmt = $this->connexion->conn->prepare($requete);
                    $stmt->bind_param("ss", $courriel, $cleReactivation);
                    $stmt->execute();

                    $lienReactivation = "http://192.168.128.13/~q220251/EVAL_V5/compteReactiver.php?courriel=" . urlencode($courriel) . "&cle=" . urlencode($cleReactivation);

                    $mail = new PHPMailer(true);
                    try {
                        $mail->CharSet = 'UTF-8';
                        $mail->setFrom('b.bouzia@student.helmo.be');
                        $mail->addAddress($courriel);
                        $mail->addReplyTo('b.bouzia@student.helmo.be');
                        $mail->isHTML(false);
                        $mail->Subject = 'Réactivation de votre compte';
                        $mail->Body = "Bonjour " . $utilisateur['prenom'] . ",\n\n";
                        $mail->Body .= "Votre compte a été désactivé, mais vous pouvez le réactiver en cliquant sur le lien suivant :\n";
                        $mail->Body .= $lienReactivation . "\n\n";
                        $mail->Body .= "Si vous n'avez pas demandé la réactivation de votre compte, veuillez ignorer cet e-mail.\n\n";
                        $mail->Body .= "Cordialement,\n";
                        $mail->Body .= "L'équipe de Example";
                        $mail->send();
                    } catch (Exception $e) {
                        return "Erreur lors de l'envoi de l'e-mail de réactivation : {$mail->ErrorInfo}";
                    }

                    return "Votre compte est désactivé. Un e-mail de réactivation a été envoyé à votre adresse e-mail. Veuillez vérifier votre boîte de réception.";
                } else {
                    return "Adresse e-mail ou mot de passe incorrect";
                }
            }
        } else {
            return "Adresse e-mail ou mot de passe incorrect";
        }
    }

    public function insererToken($courriel, $cleReactivation)
    {
        $requete = "INSERT INTO token (courriel, cle) VALUES (?, ?)";
        $stmt = $this->connexion->conn->prepare($requete);
        $stmt->bind_param("ss", $courriel, $cleReactivation);
        return $stmt->execute();
    }

    public function EmailReactiverCompte($utilisateur, $lienReactivation)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('b.bouzia@student.helmo.be');
            $mail->addAddress($utilisateur['courriel']);
            $mail->addReplyTo('b.bouzia@student.helmo.be');
            $mail->isHTML(false);
            $mail->Subject = 'Réactivation de votre compte';
            $mail->Body = "Bonjour " . $utilisateur['prenom'] . ",\n\n";
            $mail->Body .= "Votre compte a été désactivé, mais vous pouvez le réactiver en cliquant sur le lien suivant :\n";
            $mail->Body .= $lienReactivation . "\n\n";
            $mail->Body .= "Si vous n'avez pas demandé la réactivation de votre compte, veuillez ignorer cet e-mail.\n\n";
            $mail->Body .= "Cordialement,\n";
            $mail->Body .= "L'équipe de Example";
            $mail->send();
        } catch (Exception $e) {
            return "Erreur lors de l'envoi de l'e-mail de réactivation : {$mail->ErrorInfo}";
        }
        return "Votre compte est désactivé. Un e-mail de réactivation a été envoyé à votre adresse e-mail. Veuillez vérifier votre boîte de réception.";
    }


    function generateToken($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $token;
    }


    public function verifierReactivationCompte()
    {
        if (isset($_GET['courriel']) && isset($_GET['cle'])) {
            $courriel = $_GET['courriel'];
            $cleReactivation = $_GET['cle'];

            $requete = "SELECT * FROM token WHERE courriel = ? AND cle = ?";
            $stmt = $this->connexion->conn->prepare($requete);
            $stmt->bind_param("ss", $courriel, $cleReactivation);
            $stmt->execute();
            $resultat = $stmt->get_result();

            if ($resultat->num_rows == 1) {
                $requete = "UPDATE utilisateur SET estActif = 1 WHERE courriel = ?";
                $stmt = $this->connexion->conn->prepare($requete);
                $stmt->bind_param("s", $courriel);
                if ($stmt->execute()) {
                    $requete = "DELETE FROM token WHERE courriel = ? AND cle = ?";
                    $stmt = $this->connexion->conn->prepare($requete);
                    $stmt->bind_param("ss", $courriel, $cleReactivation);
                    $stmt->execute();

                    header('Location: compteReactiver.php');
                    exit;
                } else {
                    header('Location: compteReactiver.php');
                }
            }
        }
    }




    public function afficherProfilCompte()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $id = $_SESSION['uid'];

        $requete = "SELECT nom, prenom, pseudo, courriel, mdp, urlPhoto FROM utilisateur WHERE uid = ?";
        $stmt = $this->connexion->conn->prepare($requete);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }

        $stmt->close();

        return $row;
    }

    public function verifierConnexion()
    {
        if (!isset($_SESSION['uid'])) {
            header('Location:seConnecter.php');
            exit();
        }
    }

    public function modifierProfil()
    {
        $id = $_SESSION['uid'];
        $errorMessage = '';
        $successMessage = '';

        if (isset($_POST['Valider'])) {
            if ($_FILES['Photodeprofil']['error'] == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['Photodeprofil']['tmp_name'];
                $name = basename($_FILES['Photodeprofil']['name']);
                move_uploaded_file($tmp_name, "uploads/" . $name);
                $urlPhoto = $name;
            } else {
                $urlPhoto = 'uploads/imagenotfind.png';
            }

            $courriel = $_POST['Courriel'];
            $pseudo = $_POST['Pseudo'];
            $nom = $_POST['Nom'];
            $prenom = $_POST['Prénom'];

            $stmt = $this->connexion->conn->prepare("UPDATE utilisateur SET courriel = ?, pseudo = ?, nom = ?, prenom = ?, urlPhoto = ? WHERE uid = ?");
            $stmt->bind_param("sssssi", $courriel, $pseudo, $nom, $prenom, $urlPhoto, $id);
            $stmt->execute();
            $stmt->close();

            $successMessage = "Les modifications du profil ont été effectuées.";
        }
        return array($errorMessage, $successMessage);
    }


    public function modifierMdp()
    {
        $id = $_SESSION['uid'];
        $errorMessage = '';
        $successMessage = '';

        if (isset($_POST['Valider'])) {
            $ancienMotDePasse = $_POST['AncienMotDePasse'];
            $nouveauMotDePasse = $_POST['newMotDePasse'];
            $confirmezNouveauMotDePasse = $_POST['confirmezNewMotDePasse'];

            $stmt = $this->connexion->conn->prepare("SELECT mdp FROM utilisateur WHERE uid = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($motDePasseBDD);
            $stmt->fetch();
            $stmt->close();

            if (!password_verify($ancienMotDePasse, $motDePasseBDD)) {
                $errorMessage = "L'ancien mot de passe est incorrect.";
            } else {
                if ($nouveauMotDePasse !== $confirmezNouveauMotDePasse) {
                    $errorMessage = "Les nouveaux mots de passe ne correspondent pas.";
                } else {
                    $nouveauMotDePasseHash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);

                    $stmt = $this->connexion->conn->prepare("UPDATE utilisateur SET mdp = ? WHERE uid = ?");
                    $stmt->bind_param("si", $nouveauMotDePasseHash, $id);
                    $stmt->execute();
                    $stmt->close();

                    $successMessage = "Le mot de passe a été modifié avec succès.";
                }
            }
        }

        return array($errorMessage, $successMessage);
    }


    public function getProfilInfo()
    {
        $id = $_SESSION['uid'];

        $stmt = $this->connexion->conn->prepare("SELECT nom, prenom, pseudo, courriel, urlPhoto FROM utilisateur WHERE uid = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }

        $stmt->close();

        return $row;
    }



    public function verifierParticipationTournoiActif($id)
    {
        $stmt = $this->connexion->conn->prepare("SELECT COUNT(*) AS count FROM participer p JOIN tournoi t ON p.tid = t.tid WHERE p.uid = ? AND t.estActif = 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        return $count > 0;
    }


    public function supprimerProfil($motDePasse)
    {
        if (!isset($_SESSION['uid'])) {
            return "Vous devez être connecté pour supprimer votre profil.";
        }

        $id = $_SESSION['uid'];

        if ($this->verifierParticipationTournoiActif($id)) {
            return "Vous ne pouvez pas supprimer votre profil car vous participez à un tournoi actif.";
        }

        $stmt = $this->connexion->conn->prepare("SELECT mdp FROM utilisateur WHERE uid = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (password_verify($motDePasse, $row['mdp'])) {
            $stmt = $this->connexion->conn->prepare("UPDATE utilisateur SET estActif = 0 WHERE uid = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            session_destroy();
            $_SESSION = array();

            return true;
        } else {
            return "Le mot de passe est incorrect. Veuillez réessayer.";
        }
    }

    public function estAdmin()
    {

        if (isset($_SESSION['uid'])) {

            $uid = $_SESSION['uid'];

            if (!$this->connexion->conn) {
                return false;
            }

            $requete = "SELECT estOrganisateur FROM utilisateur WHERE uid = ?";
            $stmt = $this->connexion->conn->prepare($requete);

            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("i", $uid);
            $stmt->execute();

            if (!$stmt->execute()) {
                $stmt->close();
                return false;
            }

            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $stmt->close();
                return $row['estOrganisateur'] === 1;
            }
            $stmt->close();
        }
        return false;
    }


    public function rejoindreTournoi($tid)
    {

        if (!isset($_SESSION['uid']) || empty($_SESSION['uid'])) {
            return "Vous devez être connecté pour rejoindre un tournoi.";
        }

        $uid = $_SESSION['uid'];

        $sql = "SELECT COUNT(*) AS nbInscriptions FROM participer WHERE uid = ? AND tid = ?";
        $stmt = $this->connexion->conn->prepare($sql);
        $stmt->bind_param("ii", $uid, $tid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $nbInscriptions = $row['nbInscriptions'];

        if ($nbInscriptions > 0) {
            return "Vous êtes déjà inscrit à ce tournoi.";
        }

        $sql = "SELECT placesDisponibles, estActif, (SELECT COUNT(*) FROM participer WHERE tid = ?) AS nbInscrits FROM tournoi WHERE tid = ?";
        $stmt = $this->connexion->conn->prepare($sql);
        $stmt->bind_param("ii", $tid, $tid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $placesDisponibles = $row['placesDisponibles'];
        $nbInscrits = $row['nbInscrits'];
        $estActif = $row['estActif'];

        if ($estActif != 1) {
            return "Le tournoi n'est pas actif, il n'est pas possible de le rejoindre.";
        }

        if ($nbInscrits >= $placesDisponibles && $placesDisponibles <= 0) {
            return "Le tournoi est plein, il n'est plus possible de s'inscrire.";
        }

        $sql = "SELECT id_statut FROM tournoi WHERE tid = ?";
        $stmt = $this->connexion->conn->prepare($sql);
        $stmt->bind_param("i", $tid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $id_statut = $row['id_statut'];

        if ($id_statut == 6) {
            return "Le tournoi est cloturé, l'inscription n'est pas possible.";
        }

        $sql = "INSERT INTO participer (uid, tid, dateParticipation) VALUES (?, ?, NOW())";
        $stmt = $this->connexion->conn->prepare($sql);
        $stmt->bind_param("ii", $uid, $tid);

        if ($stmt->execute()) {
            $placesDisponibles = max(0, $placesDisponibles - 1);
            $sql = "UPDATE tournoi SET placesDisponibles = ? WHERE tid = ?";
            $stmt = $this->connexion->conn->prepare($sql);
            $stmt->bind_param("ii", $placesDisponibles, $tid);
            $stmt->execute();

            return "Vous avez rejoint le tournoi avec succès.";
        } else {
            return "Une erreur est survenue, veuillez réessayer.";
        }
    }



    public function reinitialiserMotDePasseOublie($courriel)
    {
        if ($this->utilisateurExiste($courriel)) {

            $nouveauMotDePasse = $this->genererNouveauMotDePasse();

            $nouveauMotDePasseHash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);
            $stmt = $this->connexion->conn->prepare("UPDATE utilisateur SET mdp = ? WHERE courriel = ?");
            $stmt->bind_param("ss", $nouveauMotDePasseHash, $courriel);
            $stmt->execute();
            $stmt->close();

            $this->envoyerEmail($courriel, $nouveauMotDePasse);

            return true;
        } else {
            return false;
        }
    }

    private function utilisateurExiste($courriel)
    {

        $requete = "SELECT * FROM utilisateur WHERE courriel = ?";
        $stmt = $this->connexion->conn->prepare($requete);
        $stmt->bind_param("s", $courriel);
        $stmt->execute();
        $resultat = $stmt->get_result();
        $existe = $resultat->num_rows > 0;
        $stmt->close();
        return $existe;
    }

    private function genererNouveauMotDePasse()
    {
        $longueur = 10;
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $nouveauMotDePasse = '';
        for ($i = 0; $i < $longueur; $i++) {
            $nouveauMotDePasse .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        return $nouveauMotDePasse;
    }


    private function envoyerEmail($courriel, $motDePasse)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('b.bouzia@student.helmo.be');
            $mail->addAddress($courriel);
            $mail->addReplyTo('b.bouzia@student.helmo.be');
            $mail->isHTML(false);
            $mail->Subject = 'Réinitialisation du mot de passe';
            $mail->Body = "Votre nouveau mot de passe est : $motDePasse";
            $mail->send();
        } catch (Exception $e) {
            echo "Une erreur est survenue lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
        }
    }

    function envoyerEmailContact($email, $objet, $message)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($email);
            $mail->addAddress('b.bouzia@student.helmo.be');
            $mail->addCC($email);
            $mail->addReplyTo($email);
            $mail->isHTML(false);
            $mail->Subject = $objet;
            $mail->Body = $message;
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo 'Erreur survenue lors de l\'envoi de l\'email<br>' . $mail->ErrorInfo;
            return false;
        }
    }

    function envoyerEmailGenerale($courriel, $objet, $message)
    {
        $mail = new PHPMailer(true);
    
        try {
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('b.bouzia@student.helmo.be');
            $mail->addAddress($courriel);
            $mail->addReplyTo('b.bouzia@student.helmo.be');
            $mail->isHTML(false);
            $mail->Subject = $objet;
            $mail->Body = $message;
            $mail->send();
        } catch (Exception $e) {
            echo "Une erreur est survenue lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
        }
    }

    public function envoyerEmailSupprimerTournoi()
    {
        $mail = new PHPMailer(true);

        try {
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('b.bouzia@student.helmo.be');
            $mail->addAddress('b.bouzia@student.helmo.be');
            $mail->addReplyTo('b.bouzia@student.helmo.be');
            $mail->isHTML(false);
            $mail->Subject = 'Le tournoi a bien été supprimée';
            $mail->Body = "Tournoi supprimer.";
            $mail->send();
        } catch (Exception $e) {
            // Gérer les erreurs d'envoi de l'e-mail ici
            echo "Une erreur est survenue lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
        }
    }


    public function getPhotosProfilParticipants($tid)
    {
        $participants = [];

        $sql = "SELECT utilisateur.uid, utilisateur.pseudo, utilisateur.urlPhoto
            FROM utilisateur
            JOIN participer ON utilisateur.uid = participer.uid
            WHERE participer.tid = ?";
        $stmt = $this->connexion->conn->prepare($sql);
        $stmt->bind_param("i", $tid);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $participants[] = [
                'uid' => $row['uid'],
                'pseudo' => $row['pseudo'],
                'urlPhoto' => $row['urlPhoto']
            ];
        }

        $stmt->close();

        return $participants;
    }


    function getUserNameById($uid)
    {
        $query = "SELECT pseudo FROM utilisateur WHERE uid = ?";
        $stmt = $this->connexion->conn->prepare($query);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['pseudo'];
        } else {
            return null;
        }
    }

    public function getEmailUser($uid)
    {

        $stmt = $this->connexion->conn->prepare("SELECT courriel FROM utilisateur WHERE uid = ?");

        $stmt->bind_param("i", $uid);

        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return $row['courriel'];
    }


    function reactiverCompte($idUtilisateur)
    {

        $requete = "SELECT * FROM utilisateur WHERE uid = ?";
        $stmt = $this->connexion->conn->prepare($requete);
        $stmt->bind_param("i", $idUtilisateur);
        $stmt->execute();
        $resultat = $stmt->get_result();

        if ($resultat->num_rows == 1) {
            $requete = "UPDATE utilisateur SET estActif = 1 WHERE uid = ?";
            $stmt = $this->connexion->conn->prepare($requete);
            $stmt->bind_param("i", $idUtilisateur);
            $stmt->execute();

            return true;
        } else {
            return false;
        }
    }
}
