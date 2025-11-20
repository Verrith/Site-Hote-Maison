<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (empty($_SESSION['logged_in']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    header('Location: ../Vue/fiche_didentification.php');
    exit;
}

// Connexion à la base de données
$dbHost = 'localhost';
$dbName = 'hote_maison_donnee';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die('Erreur DB : ' . $e->getMessage());
}

// Récupère les infos du formulaire
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Vérifie si les mots de passe correspondent
if ($new_password !== $confirm_password) {
    $_SESSION['password_message'] = "Le nouveau mot de passe et sa confirmation ne correspondent pas.";
    header('Location: change_password.php');
    exit;
}

// Récupère le mot de passe actuel dans la base
$user_id = $_SESSION['user_id']; // Assure-toi que l'ID de l'utilisateur est stocké en session
$stmt = $pdo->prepare("SELECT mot_de_passe FROM utilisateurs WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($current_password, $user['mot_de_passe'])) {
    $_SESSION['password_message'] = "Mot de passe actuel incorrect.";
    header('Location: change_password.php');
    exit;
}

// Hash le nouveau mot de passe
$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Met à jour le mot de passe dans la base
$update = $pdo->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?");
$update->execute([$new_hashed_password, $user_id]);

$_SESSION['password_message'] = "Mot de passe changé avec succès !";
header('Location: change_password.php');
exit;
