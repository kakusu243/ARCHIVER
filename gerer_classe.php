<?php
include 'config.php';

// Récupérer les sections pour la liste déroulante
$sections = $pdo->query("SELECT * FROM section")->fetchAll();

// Ajout d'une classe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nomclasse"])) {
    $nomclasse = $_POST["nomclasse"];
    $idsection = $_POST["idsection"];
    $pdo->prepare("INSERT INTO classe (nomclasse, idsection) VALUES (?, ?)")->execute([$nomclasse, $idsection]);
    echo "<div class='alert alert-success'>Classe ajoutée !</div>";
}

// Suppression d'une classe
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    $pdo->prepare("DELETE FROM classe WHERE idclasse = ?")->execute([$id]);
    echo "<div class='alert alert-success'>Classe supprimée !</div>";
}

// Liste des classes
$classes = $pdo->query("SELECT classe.*, section.nomsection FROM classe JOIN section ON classe.idsection = section.idsection")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gérer les classes</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="main-content">
    <div class="container mt-4">
        <h2 class="text-center">Gérer les classes</h2>
        <form method="POST" class="mb-4 w-50 mx-auto p-4 shadow bg-white">
            <div class="mb-3">
                <label class="form-label">Nom de la classe</label>
                <input type="text" name="nomclasse" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Section</label>
                <select name="idsection" class="form-control" required>
                    <?php foreach ($sections as $section) { ?>
                        <option value="<?= $section['idsection'] ?>"><?= htmlspecialchars($section['nomsection']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ajouter</button>
        </form>
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Section</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $classe) { ?>
                    <tr>
                        <td><?= $classe["idclasse"] ?></td>
                        <td><?= htmlspecialchars($classe["nomclasse"]) ?></td>
                        <td><?= htmlspecialchars($classe["nomsection"]) ?></td>
                        <td>
                            <a href="modifier_classe.php?idclasse=<?= $classe["idclasse"] ?>" class="btn btn-warning btn-sm me-2">Modifier</a>
                            <a href="?delete=<?= $classe["idclasse"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette classe ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
</body>
</html>