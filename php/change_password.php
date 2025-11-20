<?php
session_start();

// Connexion à la base de données
$dbHost = 'localhost';
$dbName = 'hote_maison_donnee';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO(
        "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('Erreur DB : ' . $e->getMessage());
}

// Vérifie si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!$current_password || !$new_password || !$confirm_password) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Le nouveau mot de passe et la confirmation ne correspondent pas.";
    } else {
        $stmt = $pdo->query("SELECT mot_de_passe_hash FROM MOT_DE_PASSE LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $error = "Mot de passe introuvable dans la base de données.";
        } else {
            $hash = $row['mot_de_passe_hash'];

            if (!password_verify($current_password, $hash)) {
                $error = "Mot de passe actuel incorrect.";
            } else {
                $new_hash = password_hash($new_password, PASSWORD_BCRYPT);
                $update = $pdo->prepare("UPDATE MOT_DE_PASSE SET mot_de_passe_hash = :hash LIMIT 1");
                $update->execute([':hash' => $new_hash]);
                $success = "Mot de passe changé avec succès ! Redirection en cours...";
                $redirect = true; // variable pour déclencher la redirection
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Changer le mot de passe - L'Hôte Maison</title>
<link rel="icon" href="../Images/logo.webp" type="image/webp">
<link rel="stylesheet" href="../Css/formulaire.css">
<link rel="stylesheet" href="../Css/darkmode.css">
<link rel="stylesheet" href="../Css/Affichage.css">
<link rel="stylesheet" href="../Css/en-tete.css">
<link rel="stylesheet" href="../Css/mot_de_passe.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<script src="..\Javascript\darkmode.js" defer></script>
<script src="..\Javascript\script.js" defer></script>
<script src="..\Javascript\mot_de_passe.js" defer></script>
<?php if(!empty($redirect)): ?>
<script>
// Redirection automatique après 5 secondes
setTimeout(() => {
    window.location.href = "afficher_utilisateur.php";
}, 5000);
</script>
<?php endif; ?>
</head>
<body>
      <!-- Haut de la Page -->
<header class="site-header">
    <!-- Diaporama -->
    <div class="slideshow">
      <img src="../Images/slide/IMG_5218.png" alt="Slide 1" class="slide active">
      <img src="../Images/slide/IMG_5217.png" alt="Slide 2" class="slide">
      <img src="../Images/slide/IMG_2552.jpeg" alt="Slide 3" class="slide">
      <img src="../Images/slide/IMG_5251.png" alt="Slide 4" class="slide">
      <img src="../Images/slide/IMG_2446.jpeg" alt="Slide 5" class="slide">
      <img src="../Images/slide/IMG_8517.jpeg" alt="Slide 6" class="slide">
      <img src="../Images/slide/IMG_8516.jpeg" alt="Slide 7" class="slide">
    </div>
    <div class="logo-titre">
      <a href="../Vue/Jimmy.html" style="padding-right: 20px;"><img src="..\Images\logo.webp" alt="Logo L'hote Maison"></a>
      <div class="texte-titre">
        <a href="../Vue/accueil.html" style="color: #ffd700; text-decoration: none;">
        <h1>L'HÔTE MAISON - MAISON DE JEUNES</h1>
        <div>Pour les jeunes de 12 à 17 ans dans Rosemont-La Petite-Patrie</div>
        </a>
      </div>
    </div>


    <nav id="main-nav" class="nav-bar">
        <button class="menu-toggle" aria-label="Menu mobile" style="text-align: center;">
          <i class="fa-solid fa-bars"></i>
        </button>
      <ul>
        <li><a href="../Vue/accueil.html">Accueil</a></li>
        <li><a href="../Vue/apropos.html">À propos</a>
          <!-- Premier menu -->
          <div class="dropdown">
            <span class="dropdown-button" onclick="toggleMenu()">
              <span id="arrow" class="arrow">▼</span>
            </span>
            <div id="myDropdown" class="dropdown-content">
              <a href="../Vue/Conseil_dadministration.html">Conseil d’administration</a>
              <a href="../Vue/équipe.html">Équipe</a>
              <a href="../Vue/partenaires.html">Partenaires</a>
              <a href="../Vue/Bilans_annuels.html">Bilans annuels</a>
            </div>
          </div>
        </li>
        <li><a href="../Vue/bourse_jjr.html">Bourse JJR</a></li>
        <li><a href="../Vue/Activités_projets.html">Activités et projets</a>
          <div class="dropdown">
            <!-- Deuxième menu -->
            <div class="dropdown">
              <span class="dropdown-button" onclick="toggleMenu2()">
                <span id="arrow2" class="arrow">▼</span>
              </span>
              <div id="myDropdown2" class="dropdown-content">
                <a href="../Vue/Activités_sportives.html">Activités sportives</a>
                <a href="../Vue/Ateliers_dimprovisation.html">Ateliers d’improvisation</a>
                <a href="../Vue/Page erreur.html">Camp d’accueil PPS</a>
                <a href="../Vue/Conseil_des_jeunes.html">Conseil des jeunes</a>
                <a href="../Vue/Périodes libres.html">Périodes libres</a>
                <a href="../Vue/sérigraphie.html">Projet de sérigraphie</a>
                <a href="../Vue/Projet Musical.html">Projet Musical</a>
                <a href="../Vue/Projet Naos.html">Projet Naos</a>
                <a href="../Vue/sexo.html">Soirées sexo</a>
              </div>
            </div>
        </li>
        <li><a href="../Vue/jeunes.html">Jeunes</a>
        <div class="dropdown">
            <span class="dropdown-button" onclick="toggleMenu3()">
              <span id="arrow3" class="arrow">▼</span>
            </span>
          <div id="myDropdown3" class="dropdown-content">
            <a href="../Vue/ressources_jeunes.html">Ressources jeunes</a>
            <a href="../Vue/fiche_didentification.php">Fiche d’identification</a>
          </div>
        </div>
        </li>
        <li><a href="../Vue/parents_ressources.html">Parents et Ressources</a></li>
        <li><a href="../Vue/emplois.html">Emplois</a></li>
    <div class="nav-right">
      <i id="toggleIcon" class="fa-solid fa-sun" onclick="toggleDarkMode()" title="Changer le mode"></i>
    </div>
</div>
    </nav>
  </header>
  <!-- fin Haut de la Page -->

<div>
<h2 class="text-note">Changer le mot de passe</h2><br>

<?php if(!empty($error)) echo "<p class='message error'>$error</p>"; ?>
<?php if(!empty($success)) echo "<p class='message success'>$success</p>"; ?>

<form method="POST">
    <div>
        <label>Mot de passe actuel :</label>
        <div class="input-oeil">
            <input type="password" name="current_password" placeholder="Mot de passe actuel" required>
            <i class="fa-solid fa-eye" onclick="togglePassword(this)"></i>
        </div>
    </div>

    <div>
        <label>Nouveau mot de passe :</label>
        <div class="input-oeil">
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
            <i class="fa-solid fa-eye" onclick="togglePassword(this)"></i>
        </div>
    </div>

    <div>
        <label>Confirmer nouveau mot de passe :</label>
        <div class="input-oeil">
            <input type="password" name="confirm_password" placeholder="Confirmer nouveau mot de passe" required>
            <i class="fa-solid fa-eye" onclick="togglePassword(this)"></i>
        </div>
    </div>
    <button type="submit" class="bouton_a">Changer le mot de passe</button>
</form>


</div>
    <!-- bas de la Page -->
     <br><br><hr>

<div class="contact-grid">
  <div class="texte-accueil text-link">
    <h2 class="text-note">Nous contacter</h2>
    <div><b>Adresse:</b> 1555 rue de Bellechasse, Montréal (QC), H2G 1N9</div>
    <div><b>Téléphone:</b> <a href="tel:+15142730805">(514) 273-0805</a></div>
    <ul>
      <li>Ext. 101: Étienne Vézina, directeur par intérim</li>
      <li>Ext. 103: Intervenants – Espace des Jeunes</li>
    </ul>
    <div><b>Courriel:</b> 
      <a href="mailto:info@lhotemaison.org">info@lhotemaison.org</a>
    </div>
    <br>
  </div>

  <div class="texte-accueil">
    <h2 class="text-note">Heures d’ouverture (année scolaire 2025-2026)</h2>
    <ul>
      <li>Lundi au mercredi : 15h00 à 20h00</li>
      <li>Jeudi et vendredi : 15h00 à 21h00</li>
      <li>Ces heures sont sujettes à changements.<br>Consultez notre Instagram pour les détails.</li>
    </ul>
  </div>
</div>  
            <br>
            <h2 class="text-note">Suivez-nous !</h2>
            <p style="text-align: center;">
            <a href="https://fr-ca.facebook.com/lhote.maison" target="_blank"><i id="linkIcon" class="fab fa-facebook facebook-icon"></i></a>
            <a href="https://www.youtube.com/channel/UCCoOsuuxjMWhZb6A9pXWagg" target="_blank"><i id="linkIcon" class="fab fa-youtube youtube-icon"></i></a>
            <a href="https://www.instagram.com/lhotemaison" target="_blank"><i id="linkIcon" class="fab fa-instagram instagram-icon"></i></a>
            <a href="https://www.tiktok.com/@lhotemaison?lang=fr"><i id="linkIcon_ticktok" class="fa-brands fa-tiktok tiktok-icon"></i></a>
          </p>
            <!-- fin bas de la Page -->

</body>
</html>
