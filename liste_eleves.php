<?php
include 'config.php';

// Récupérer tous les élèves
$eleves = $pdo->query("SELECT * FROM eleves")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Liste des élèves</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .print-table, .print-table * {
        visibility: visible;
    }
    .print-table {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }
}
</style>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="main-content">
    <div class="container mt-4">
        <h2 class="text-center">Liste des élèves inscrits</h2>
        <table  class="table table-bordered bg-white print-table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom Elève</th>
                    <th>Postnom Elève</th>
                    <th>Prénom Elève</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eleves as $eleve) { ?>
                    <tr>
                        <td><?= $eleve['ideleve'] ?></td>
                        <td><a href="profil_eleve.php?ideleve=<?= $eleve['ideleve'] ?>" class="text-primary"><?= htmlspecialchars($eleve['nom']) ?></a></td>
                        <td><?= htmlspecialchars($eleve['postnom']) ?></td>
                        <td><?= htmlspecialchars($eleve['prenom'] ?? '') ?></td>
                        <td>
                            <a href="profil_eleve.php?ideleve=<?= $eleve['ideleve'] ?>" class="btn btn-info btn-sm">Voir profil</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button class="btn btn-secondary" onclick="window.history.back();">Retour</button>
        <button class="btn btn-primary ms-2" onclick="window.print();">
    <i class="bi bi-printer"></i> Imprimer
</button>
    </div>
    </div>
</body>
</html>
