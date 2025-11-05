<?php
session_start();
include 'config.php';

// Vérifier que l'utilisateur est connecté et est un élève
if (!isset($_SESSION["user_id"]) || $_SESSION["typeuser"] != "Élève") {
    header("Location: login.php");
    exit();
}

if (isset($_GET["numpiece"])) {
    $numpiece = intval($_GET["numpiece"]);
    // Récupérer l'id élève à partir du login utilisateur
    $stmt = $pdo->prepare("SELECT login FROM users WHERE iduser = ?");
    $stmt->execute([$_SESSION["user_id"]]);
    $login = $stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT ideleve FROM eleves WHERE login = ?");
    $stmt->execute([$login]);
    $ideleve = $stmt->fetchColumn();

    // Vérifier que l'archive appartient bien à l'élève
    $stmt = $pdo->prepare("SELECT nompiece FROM archives WHERE numpiece = ? AND ideleve = ?");
    $stmt->execute([$numpiece, $ideleve]);
    $archive = $stmt->fetch();

    if ($archive) {
        $filepath = $archive["nompiece"];
        // Supprimer le fichier du disque si il existe
        if (file_exists($filepath)) {
            unlink($filepath);
        }
        // Supprimer l'entrée de la base de données
        $stmt = $pdo->prepare("DELETE FROM archives WHERE numpiece = ? AND ideleve = ?");
        $stmt->execute([$numpiece, $ideleve]);
        // Rediriger avec succès
        header("Location: mes_archives.php?msg=suppression_ok");
        exit();
    } else {
        echo "Suppression impossible : document non trouvé ou accès refusé.";
    }
} else {
    echo "Paramètre manquant.";
}
