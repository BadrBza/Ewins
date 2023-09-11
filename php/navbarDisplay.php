<?php
namespace navbarDisplay;
require_once __DIR__ . "/../inc/BD.php";

use inc\BD;

class navbarDisplay {
    private $bd;

    public function __construct() {
        $this->bd = new BD();
        
    }

    public function getUserId() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['uid']) ? $_SESSION['uid'] : null;
    }

    public function fetchUser($id) {
        $sql = "SELECT nom, prenom, urlPhoto FROM utilisateur WHERE uid= '$id'";
        $result = $this->bd->query($sql);
        return mysqli_fetch_assoc($result);
    }

    public function displayUser($user) {
        if($user) {
            $nom = $user["nom"];
            $prenom = $user["prenom"];
            $urlPhoto = $user["urlPhoto"];
            
            echo '<li><a href="monProfil.php" class="image-link"><img src="uploads/' . basename($urlPhoto) . '" alt="Photo" width="50" height="50"></a>' . $nom . ' ' . $prenom . '</li>';

        } else {
            echo "Profil";
        }
    }
}


?>