<?php
include 'config.php';

$stmt = $pdo->query("SELECT a.numpiece, a.nompiece, a.categorie, a.classe, e.nom, e.postnom FROM archives a JOIN eleves e ON a.ideleve = e.ideleve ORDER BY a.numpiece DESC");
$archives = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Toutes les archives</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="main-content">
    <div class="container mt-4">
        <h2 class="text-center mb-4">Liste de tous les archives</h2>
        <a classe="btn btn-primary" href="recherche.php" style="background-color: #0d6efd; color:azure; padding: 0.5em; border-radius: 6px; text-decoration:none; margin-bottom: 1rem;">rechercher un archive</a>
        <table class="table table-bordered bg-white mt-3">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Intitulé</th>
                    <th>Type Document</th>
                    <th>Classe</th>
                    <!-- <th>Date Archive</th> -->
                    <th>Nom Élève</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($archives as $archive) { ?>
                    <tr>
                        <td><?= $archive['numpiece'] ?></td>
                        <td><?= htmlspecialchars($archive['categorie']) ?></td>
                        <td><?= htmlspecialchars(basename($archive['nompiece'])) ?></td>
                        <td><?= htmlspecialchars($archive['classe']) ?></td>
                        <!-- <td><?= htmlspecialchars($archive['datearchive'] ?? '') ?></td> -->
                        <td><?= htmlspecialchars($archive['nom'] . ' ' . $archive['postnom']) ?></td>
                        <td>
                            <a href="<?= htmlspecialchars($archive['nompiece']) ?>" target="_blank" class="btn btn-sm btn-info text-white">Voir</a>
                            <a href="telecharger.php?numpiece=<?= $archive['numpiece'] ?>" class="btn btn-sm btn-primary">Télécharger</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
</body>
</html>
