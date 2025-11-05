<?php
session_start();
include 'config.php';

// Vérifier que seul le préfet peut accéder
if (!isset($_SESSION["typeuser"]) || $_SESSION["typeuser"] != "Préfet") {
    header("Location: index.php");
    exit();
}

// Suppression d'un utilisateur
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    $pdo->prepare("DELETE FROM users WHERE iduser = ?")->execute([$id]);
    echo "<div class='alert alert-success'>Utilisateur supprimé !</div>";
}

// Récupération des utilisateurs
$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="container mt-4">
        <h2 class="text-center">Liste des utilisateurs</h2>
        <a href="ajouter_user.php" class="btn btn-success mb-3">Ajouter un utilisateur</a>
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Login</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?= $user["iduser"] ?></td>
                        <td><?= htmlspecialchars($user["login"]) ?></td>
                        <td><?= $user["typeuser"] ?></td>
                        <td>
                            <a href="?delete=<?= $user["iduser"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
                            <a href="modifier_user.php?id=<?= $user["iduser"] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>