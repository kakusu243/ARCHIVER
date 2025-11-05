<?php
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET["numpiece"])) {
    $numpiece = intval($_GET["numpiece"]);
    $typeuser = $_SESSION["typeuser"] ?? null;
    if ($typeuser === "Élève") {
        // L'élève ne peut télécharger que ses propres fichiers
        $stmt = $pdo->prepare("SELECT ideleve FROM eleves WHERE login = (SELECT login FROM users WHERE iduser = ?)");
        $stmt->execute([$_SESSION["user_id"]]);
        $ideleve = $stmt->fetchColumn();
        $stmt = $pdo->prepare("SELECT nompiece FROM archives WHERE numpiece = ? AND ideleve = ?");
        $stmt->execute([$numpiece, $ideleve]);
    } else {
        // Admin, préfet, etc. peuvent télécharger tous les fichiers
        $stmt = $pdo->prepare("SELECT nompiece FROM archives WHERE numpiece = ?");
        $stmt->execute([$numpiece]);
    }
    $archive = $stmt->fetch();

    if ($archive) {
        $filepath = $archive["nompiece"];
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit();
        } else {
            echo "Fichier introuvable.";
        }
    } else {
        echo "Archive non trouvée ou accès refusé.";
    }
} else {
    echo "Paramètre manquant.";
}