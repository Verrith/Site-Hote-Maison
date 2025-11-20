<?php
session_start();

// --- CONFIGURATION MYSQL ---
$dbHost = 'localhost';
$dbName = 'hote_maison_donnee';
$dbUser = 'root';   // utilisateur MySQL
$dbPass = '';       // mot de passe MySQL (vide sur XAMPP par défaut)

try {
    $pdo = new PDO(
        "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    if ($password === '') {
        header('Location: ../Vue/fiche_didentification.php?error=empty');
        exit;
    }

    $stmt = $pdo->prepare('SELECT mot_de_passe_hash FROM MOT_DE_PASSE LIMIT 1');
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        header('Location: ../Vue/fiche_didentification.php?error=nouser');
        exit;
    }

    $hash = $row['mot_de_passe_hash'];

    if (password_verify($password, $hash)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        header('Location: afficher_utilisateur.php');
        exit;
    } else {
        header('Location: ../Vue/fiche_didentification.php?error=badpass');
        exit;
    }
} else {
    header('Location: ../Vue/fiche_didentification.php');
    exit;
}
