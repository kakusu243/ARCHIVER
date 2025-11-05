<?php
session_start();
include 'config.php';

// Vérifier que l'utilisateur est connecté et est un élève
if (!isset($_SESSION["user_id"]) || $_SESSION["typeuser"] != "Élève") {
    header("Location: login.php");
    exit();
}

// Récupérer le login de l'utilisateur connecté
$login = $_SESSION["login"] ?? null;
if (!$login) {
    // Si le login n'est pas en session, le récupérer depuis la table users
    $stmt = $pdo->prepare("SELECT login FROM users WHERE iduser = ?");
    $stmt->execute([$_SESSION["user_id"]]);
    $login = $stmt->fetchColumn();
    $_SESSION["login"] = $login;
}

// Récupérer l'id de l'élève correspondant à ce login
$stmt = $pdo->prepare("SELECT ideleve FROM eleves WHERE login = ?");
$stmt->execute([$login]);
$ideleve = $stmt->fetchColumn();

// Récupérer les archives de l'élève
$stmt = $pdo->prepare("SELECT a.numpiece, a.nompiece, a.categorie, a.classe, a.numpiece, e.nom FROM archives a JOIN eleves e ON a.ideleve = e.ideleve WHERE a.ideleve = ?");
$stmt->execute([$ideleve]);
$archives = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mes archives</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/archives-table.css">
</head>
<body class="bg-light main-content">
    <?php require_once('header.php'); ?>
    <div class="container mt-4">
        <h2 class="text-center">Mes archives</h2>
        <!-- Style du tableau déplacé dans archives-table.css -->
        <table class="custom-table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th><b>Intitule</b></th>
                    <th><b>Type Document</b></th>
                    <th><b>Classe</b></th>
                    <th><b>Nom Eleve</b></th>
                    <th><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($archives as $archive) { ?>
                    <tr>
                        <td><b><?= $archive["numpiece"] ?></b></td>
                        <td><?= htmlspecialchars($archive["categorie"]) ?></td>
                        <td>
                            <a href="<?= htmlspecialchars($archive["nompiece"]) ?>" target="_blank" onclick="event.preventDefault(); openAndPrint(this.href);">
                                <?= htmlspecialchars(basename($archive["nompiece"])) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($archive["classe"]) ?></td>
                        <td><?= isset($archive["nom"]) ? htmlspecialchars($archive["nom"]) : '' ?></td>
                        <td>
                            <a href="telecharger.php?numpiece=<?= $archive["numpiece"] ?>">Télécharger</a>
                            <!-- |
                            <a href="supprimer_document.php?numpiece=<?= $archive["numpiece"] ?>" class="text-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce document ?');">Supprimer</a> -->
                        </td>
                    </tr>
                <?php } ?>
                <script>
                function openAndPrint(url) {
                    var printWindow = window.open(url, '_blank');
                    var timer = setInterval(function() {
                        if (printWindow.document.readyState === 'complete') {
                            clearInterval(timer);
                            printWindow.focus();
                            printWindow.print();
                        }
                    }, 500);
                }
                </script>
            </body>
    </div>
</body>
</html>