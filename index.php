<?php
session_start();
include 'config.php';

// Vérifier s'il existe déjà un préfet
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE typeuser = 'Préfet'");
$stmt->execute();
$nb_prefet = $stmt->fetchColumn();

if ($nb_prefet == 0) {
    header("Location: inscription_prefet.php");
    exit();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Récupérer les informations de l'utilisateur
$user_type = $_SESSION["typeuser"];

// Récupération des élèves
$eleves_stmt = $pdo->prepare("SELECT * FROM eleves");
$eleves_stmt->execute();
$eleves = $eleves_stmt->fetchAll();

// Récupération des bulletins archivés
$bulletins_stmt = $pdo->prepare("SELECT * FROM archives");
$bulletins_stmt->execute();
$bulletins = $bulletins_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('bg.webp') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
        .welcome-container {
            background: rgba(255,255,255,0.92);
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            max-width: 600px;
            margin: 60px auto 0 auto;
            padding: 40px 32px 32px 32px;
        }
        .welcome-title {
            font-family: 'Segoe UI',sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        .welcome-desc {
            font-size: 1.18rem;
            color: #333;
            margin-bottom: 30px;
        }
        .modern-btn {
            font-size: 1.1rem;
            padding: 12px 28px;
            border-radius: 8px;
            margin: 0 8px 16px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            transition: transform 0.15s, box-shadow 0.15s;
        }
        .modern-btn:hover {
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(0,0,0,0.13);
        }
    </style>
</head>
<body>
    <?php require_once('header.php'); ?>
    <div class="welcome-container">
        <div class="text-center">
            <div class="welcome-title">Bienvenue dans notre plateforme d'archivage</div>
            <div class="welcome-desc">
                Cette application web moderne permet la gestion, l’archivage et la consultation sécurisée des documents scolaires, des élève. Simplifiez l’administration, accédez rapidement aux documents, et offrez un espace numérique efficace à votre établissement.
            </div>
            <?php if ($user_type == 'Directeur') { ?>
                <a href="enregistrer.php" class="btn btn-success modern-btn">Ajouter un élève</a>
                <a href="archiver.php" class="btn btn-primary modern-btn">Archiver un bulletin</a>
            <?php } ?>
            <a href="recherche.php" class="btn btn-info modern-btn text-white">Rechercher un document</a>
            <a href="dashboard.php" class="btn btn-warning modern-btn text-dark">Voir le Dashboard</a>
            <a href="logout.php" class="btn btn-danger modern-btn">Déconnexion</a>
        </div>
    </div>
</body>
</html>