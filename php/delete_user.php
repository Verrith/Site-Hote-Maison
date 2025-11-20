<?php
session_start();
if (empty($_SESSION['logged_in']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    header('Location: ../Vue/fiche_didentification.php');
    exit;
}

if (!isset($_GET['id'])) {
    die("ID utilisateur manquant.");
}

$id = (int)$_GET['id'];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=hote_maison_donnee;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->prepare("DELETE FROM utilisateurs_hote_maison WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header('Location: afficher_utilisateur.php'); // redirige vers la page de liste
    exit;
} catch (PDOException $e) {
    die("Erreur lors de la suppression : " . $e->getMessage());
}
?>
