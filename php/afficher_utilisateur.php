<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (empty($_SESSION['logged_in']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    header('Location: ../Vue/fiche_didentification.php');
    exit;
}

// Connexion à la base de données
$dbHost = 'localhost';
$dbName = 'hote_maison_donnee'; // vérifie l'orthographe
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

// Récupère tous les utilisateurs
$stmt = $pdo->query('SELECT * FROM utilisateurs_hote_maison ORDER BY created_at DESC');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr-CA">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Liste des fiches d’inscription - L'Hôte Maison</title>
<link rel="stylesheet" href="../Css/formulaire.css">
<link rel="icon" href="../Images/logo.webp" type="image/webp">
    <link rel="stylesheet" href="..\Css\Affichage.css">
    <link rel="stylesheet" href="..\Css\en-tete.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="..\Css\darkmode.css">
    <script src="..\Javascript\darkmode.js" defer></script>
    <script src="..\Javascript\script.js" defer></script>
<style>
.card { 
    background: rgb(237, 237, 237); 
    padding: 20px; 
    border-radius: 10px; 
    margin-bottom: 20px; 
    box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
}
.card-header { 
    font-weight: bold; 
    font-size: 1.2em; 
    display: flex; 
    justify-content: space-between; 
    cursor: pointer; 
}
.card-body { display: none; margin-top: 10px; }
.toggle-btn { background: none; border: none; color: #007BFF; cursor: pointer; font-size: 1em; }
</style>
<script>
function toggleDetails(id) {
    const el = document.getElementById('details' + id);
    el.style.display = el.style.display === 'block' ? 'none' : 'block';
}
</script>
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





<div class="texte-accueil">
<h1>Liste des fiches d’inscription</h1>
<br><br>

<?php foreach($users as $user): ?>
<div class="card" style="text-align: left;">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <!-- Nom + flèche à gauche, clic déclenche toggle -->
        <span onclick="toggleDetails(<?= $user['id'] ?>)" style="cursor:pointer; flex:1; text-align:left;">
            <?= htmlspecialchars($user['prenom_hash'] . ' ' . $user['nom_hash']) ?> 
            <span style="font-size:0.9em;">▼</span>
        </span>

        <!-- Date au centre -->
        <span style="flex:1; text-align:center; font-size:0.9em;">
            Créé le : <?= htmlspecialchars($user['created_at']) ?>
        </span>

        <!-- Bouton de suppression à droite -->
        <span style="flex:1; text-align:right;">
            <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                <i class="fa-solid fa-trash-can" style="color:red; cursor:pointer;"></i>
            </a>
        </span>
    </div>

    <div class="card-body" id="details<?= $user['id'] ?>"><br>
        <strong>Date de naissance :</strong> <?= htmlspecialchars($user['date_naissance_hash']) ?><br>
        <strong>Prénom naissance :</strong> <?= htmlspecialchars($user['prenom_naissance_hash']) ?><br>
        <strong>Pronoms :</strong> <?= htmlspecialchars($user['pronoms']) ?><br>
        <strong>Genre :</strong> <?= htmlspecialchars($user['genre']) ?><br><br>

        <strong>Adresse :</strong> <?= htmlspecialchars($user['adresse_hash']) ?>, <?= htmlspecialchars($user['ville_hash']) ?>, <?= htmlspecialchars($user['code_postal_hash']) ?><br>
        <?php if(!empty($user['adresse2_hash'])): ?>
            <strong>Adresse 2 :</strong> <?= htmlspecialchars($user['adresse2_hash']) ?>, <?= htmlspecialchars($user['ville2_hash']) ?>, <?= htmlspecialchars($user['code_postal2_hash']) ?><br>
        <?php endif; ?>

        <br>
        <?php if(!empty($user['contact1_nom_hash'])): ?>
        <strong>Contact 1 :</strong> <?= htmlspecialchars($user['contact1_nom_hash']) ?>
        <?php if(!empty($user['contact1_lien'])): ?> - <?= htmlspecialchars($user['contact1_lien']) ?><?php endif; ?><br>
        <?php if(!empty($user['contact1_tel_hash'])): ?>
            <strong>Tel du Contact 1 :</strong> <?= htmlspecialchars($user['contact1_tel_hash']) ?><br>
        <?php endif; ?>
        <?php if(!empty($user['contact1_autre_tel_hash'])): ?>
            <strong>Deuxième Tel du Contact 1 :</strong> <?= htmlspecialchars($user['contact1_autre_tel_hash']) ?><br>
        <?php endif; ?>
        <?php endif; ?>

        <?php if(!empty($user['contact2_nom_hash'])): ?>
        <br>
        <strong>Contact 2 :</strong> <?= htmlspecialchars($user['contact2_nom_hash']) ?>
        <?php if(!empty($user['contact2_lien'])): ?> - <?= htmlspecialchars($user['contact2_lien']) ?><?php endif; ?><br>
        <?php if(!empty($user['contact2_tel_hash'])): ?>
            <strong>Tel du Contact 1 :</strong> <?= htmlspecialchars($user['contact2_tel_hash']) ?><br>
        <?php endif; ?>
        <?php if(!empty($user['contact2_autre_tel_hash'])): ?>
            <strong>Deuxième Tel du Contact 2 :</strong> <?= htmlspecialchars($user['contact2_autre_tel_hash']) ?><br>
        <?php endif; ?>
        <?php endif; ?>

        
        <?php if(!empty($user['sante'])): ?>
          <br>
            <strong>Problème de Santé :</strong> <?= htmlspecialchars($user['sante']) ?>
        <?php endif; ?>
        <?php if(!empty($user['numero_rejoindre_hash'])): ?>
          <br>
            <strong>Numéro à rejoindre :</strong> <?= htmlspecialchars($user['numero_rejoindre_hash']) ?>
        <?php endif; ?>
        <?php if(!empty($user['moyen_contact'])): ?>
          <br>
            <strong>Moyen contact :</strong> <?= htmlspecialchars($user['moyen_contact']) ?>
        <?php endif; ?>
        <?php if(!empty($user['pseudos'])): ?>
          <br>
            <strong>Pseudos :</strong> <?= htmlspecialchars($user['pseudos']) ?>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>




<br><a href="logout.php" class="bouton_a">Déconnexion</a><a style="padding-left: 30px;"></a><a href="change_password.php" class="bouton_a">Changer de mot de passe</a>
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
