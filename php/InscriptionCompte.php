<?php
namespace InscriptionCompte;
use inc\BD;

class InscriptionCompte {

    private $db;

    const TAILLE = 5242880; // pas utilisé car sur dartagnan la limite de 5ko a été levée.
    const REPERTOIRE_SCAN = '../uploads/';

    public function __construct(BD $db) {
        $this->db = $db;
    }

    public function inscrire($data, $file) {

        $courriel = $data["Courriel"];
        $nom = $data["Nom"];
        $prenom = $data["Prénom"];
        $pseudo = $data["Pseudo"];
        $mdp = $data["motDePasse"];
        $confirmerMdp = $data["confirmezmotDePasse"];
        
    
        if (empty($courriel) || empty($nom) || empty($prenom) || empty($pseudo) || empty($mdp) || empty($confirmerMdp)) {
            header("Location:inscription.php?inscription_err=missingValue");
            return;
        }
    
        if (!filter_var($courriel, FILTER_VALIDATE_EMAIL)) {
            header("Location:inscription.php?inscription_err=invalideEmail");
            return;
        }

        if ($this->checkEmail($courriel) > 0) {
            header("Location:inscription.php?inscription_err=notUniqueEmail");
            return;
        }

        if ($this->checkUnicityPseudo($pseudo) > 0) {
            header("Location:inscription.php?inscription_err=notUniquePseudo");
            return;
        }

        if ($this->checkUnicityMail($courriel) > 0) {
            header("Location:inscription.php?inscription_err=notUniqueMail");
            return;
        }

        if ($mdp != $confirmerMdp) {
            header("Location:inscription.php?inscription_err=notEqualsMdp");
            return;
        }
    
        if (isset($file['Photodeprofil']) && $file['Photodeprofil']['size'] > 0) {
            $uploads_dir = 'uploads/';
            $nomFichier = $file['Photodeprofil']['name'];
            $nomTemporaire = $file['Photodeprofil']['tmp_name'];
            $urlPhoto = $uploads_dir . $nomFichier;
            move_uploaded_file($nomTemporaire, $urlPhoto);
        } else {
            $urlPhoto = 'uploads/imagenotfind.png';
        }
    
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $estActif = true;
        $estOrganisateur = false;
        echo $urlPhoto; 
        $this->insertIntoUtilisateur($courriel, $pseudo, $nom, $prenom, $mdp, $estActif, $estOrganisateur, $urlPhoto);
    
        $_SESSION['uid'] = $data['uid'];
        $_SESSION['nom'] = $data['nom'];
        $_SESSION['prenom'] = $data['prenom'];
        $_SESSION['pseudo'] = $data['pseudo'];
        $_SESSION['courriel'] = $data['courriel'];
        $_SESSION['admin'] = $data['estOrganisateur'];
        $_SESSION['pdp'] = $data['urlPhoto'];
        setcookie('nom', $data['nom'], time() + 3600); 
        setcookie('prenom', $data['prenom'], time() + 3600);
        header("Location:index.php?admin=" . $data['estOrganisateur']);
        header("Location:index.php");
    }
    

    private function checkEmail($courriel) {
        $requete = "SELECT COUNT(*) as nbEmails FROM utilisateur WHERE courriel = ?";
        $stmt = $this->db->conn->prepare($requete);
        $stmt->bind_param("s", $courriel);
        $stmt->execute();
        $resultat = $stmt->get_result();
        $row = $resultat->fetch_assoc();
        return $row['nbEmails'];
    }

    private function checkUnicityPseudo($pseudo) {
        $requete = "SELECT COUNT(*) as nbPseudos FROM utilisateur WHERE pseudo = ?";
        $stmt = $this->db->conn->prepare($requete);
        $stmt->bind_param("s", $pseudo);
        $stmt->execute();
        $resultat = $stmt->get_result();
        $row = $resultat->fetch_assoc();
        return $row['nbPseudos'];
    }

    private function checkUnicityMail($courriel) {
        $requete = "SELECT COUNT(*) as nbEmails FROM utilisateur WHERE courriel = ?";
        $stmt = $this->db->conn->prepare($requete);
        $stmt->bind_param("s", $courriel);
        $stmt->execute();
        $resultat = $stmt->get_result();
        $row = $resultat->fetch_assoc();
        return $row['nbEmails'];
    }
    

    private function insertIntoUtilisateur($courriel, $pseudo, $nom, $prenom, $mdp, $estActif, $estOrganisateur, $urlPhoto) {
        $requete = "INSERT INTO utilisateur (courriel, pseudo, nom, prenom, mdp, estActif, estOrganisateur, urlPhoto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->conn->prepare($requete);
        $stmt->bind_param("sssssiis", $courriel, $pseudo, $nom, $prenom, $mdp, $estActif, $estOrganisateur, $urlPhoto);
        return $stmt->execute();  
    }
    
    

}
?>
