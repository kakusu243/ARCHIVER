<?php
include 'config.php';

$message = "";

// Ajout d'une section
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nomsection"])) {
    $nomsection = $_POST["nomsection"];
    $pdo->prepare("INSERT INTO section (nomsection) VALUES (?)")->execute([$nomsection]);
    header("Location: gerer_section.php?success=1");
    exit();
}

// Suppression d'une section
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    $pdo->prepare("DELETE FROM section WHERE idsection = ?")->execute([$id]);
    header("Location: gerer_section.php?deleted=1");
    exit();
}

if (isset($_GET["success"])) {
    $message = "<div class='alert alert-success'>Section ajoutée !</div>";
}
if (isset($_GET["deleted"])) {
    $message = "<div class='alert alert-success'>Section supprimée !</div>";
}

// Liste des sections
$sections = $pdo->query("SELECT * FROM section")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gérer les sections</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="main-content">
    <div class="container mt-4">
        <h2 class="text-center">Gérer les sections</h2>
        <?= $message ?>
        <form method="POST" class="mb-4 w-50 mx-auto p-4 shadow bg-white">
            <div class="mb-3">
                <label class="form-label">Nom de la section</label>
                <input type="text" name="nomsection" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ajouter</button>
        </form>
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sections as $section) { ?>
                    <tr>
                        <td><?= $section["idsection"] ?></td>
                        <td><?= htmlspecialchars($section["nomsection"]) ?></td>
                        <td>
                            <a href="modifier_section.php?idsection=<?= $section["idsection"] ?>" class="btn btn-warning btn-sm me-2">Modifier</a>
                            <a href="?delete=<?= $section["idsection"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette section ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
</body>
</html>