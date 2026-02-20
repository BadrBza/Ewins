# E-Wins

Site web de gestion de tournois (projet scolaire) en PHP/MySQL.

## Apercu

- Espace visiteur et utilisateur connecte
- Gestion de tournois (liste, details, inscription)
- Espace organisateur/admin (ajout, edition, suppression)
- Gestion de profil utilisateur
- Envoi d'emails (PHPMailer)

## Stack technique

- PHP 8.x
- MySQL / MariaDB
- HTML + CSS
- PHPMailer (inclus dans le dossier `PHPMailer/`)

## Pre-requis

- Windows + `cmd`
- MySQL/MariaDB demarre
- PHP CLI disponible

Dans ce projet, la connexion DB est configuree dans `inc/BD.php` :

- host: `127.0.0.1`
- user: `root`
- password: `` (vide)
- database: `Q220251`

## Installation et lancement en local (CMD)

### 1) Option conseillee sous Windows

Si un service `MySQL80` tourne deja et bloque ton setup XAMPP, arrete-le (CMD en admin):

```cmd
net stop MySQL80
```

Puis lance MySQL de XAMPP (dans une fenetre CMD separee, a laisser ouverte):

```cmd
cd /d C:\xampp
mysql_start.bat
```

### 2) Initialiser la base

Dans une autre fenetre CMD:

```cmd
cd /d "C:\votreCheminDuProjet"

"C:\xampp\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS Q220251 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
"C:\xampp\mysql\bin\mysql.exe" -u root Q220251 < bd.sql
```

### 3) Lancer le serveur PHP local

```cmd
cd /d "C:\votreCheminDuProjet"
"C:\xampp\php\php.exe" -S 127.0.0.1:8000
```

Ouvre ensuite:

- `http://127.0.0.1:8000/index.php`

## Comptes de test

- Admin
  - email: `admin@gmail.com`
  - mot de passe: `Admin`
- Utilisateur
  - email: `isagi@gmail.com`
  - mot de passe: `isagi`

(Source: `acces.txt`)

## Pages principales

- `index.php` : accueil
- `listeTournois3.php` : liste des tournois
- `detailTournois.php` : detail d'un tournoi
- `inscription.php` : creation de compte
- `seConnecter.php` : connexion
- `monProfil.php` : profil utilisateur
- `ajouterTournoi.php` / `editerTournoi.php` / `supprimerTournoi.php` : gestion tournois

## Arborescence utile

- `inc/` : config DB + fragments communs
- `php/` : logique metier (DAO, auth, etc.)
- `css/` : styles
- `images/` : assets
- `uploads/` : fichiers envoyes
- `bd.sql` : dump de la base

## Depannage

- `'mysql' n'est pas reconnu`
  - utilise le chemin complet: `"C:\xampp\mysql\bin\mysql.exe"`
- `'php' n'est pas reconnu`
  - utilise le chemin complet: `"C:\xampp\php\php.exe"`
- `Access denied for user 'root'@'localhost'`
  - verifie `inc/BD.php` (mot de passe root vide ici)
  - assure-toi d'utiliser la meme instance MySQL que celle de XAMPP
- `Table '...' already exists` pendant import
  - la base est deja partiellement importee
  - pour repartir propre:

```cmd
"C:\xampp\mysql\bin\mysql.exe" -u root -e "DROP DATABASE IF EXISTS Q220251; CREATE DATABASE Q220251 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
"C:\xampp\mysql\bin\mysql.exe" -u root Q220251 < bd.sql
```

## Notes

- Certaines fonctionnalites d'email peuvent dependre de la configuration mail locale/serveur.
- Si certaines infos ne se mettent pas a jour immediatement, rafraichir la page.
