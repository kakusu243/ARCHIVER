<?php
include 'config.php';

// Récupération des élèves pour affichage dans la liste déroulante
$eleves_stmt = $pdo->prepare("SELECT ideleve, nom, postnom FROM eleves");
$eleves_stmt->execute();
$eleves = $eleves_stmt->fetchAll();

// Récupération des classes pour la liste déroulante
$classes_stmt = $pdo->prepare("SELECT idclasse, nomclasse FROM classe");
$classes_stmt->execute();
$classes = $classes_stmt->fetchAll();

$categories = ['Bulletins', 'Certificat', 'Attestation', 'CV', 'Lettre'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classe = $_POST["classe"];
    $nompiece = $_FILES["bulletin"]["name"];
    $ideleve = $_POST["ideleve"];
    $categorie = $_POST["categorie"];
    $target_dir = "bulletins/";
    $target_file = $target_dir . basename($nompiece);

    if (move_uploaded_file($_FILES["bulletin"]["tmp_name"], $target_file)) {
        $stmt = $pdo->prepare("INSERT INTO archives (classe, nompiece, ideleve, categorie) VALUES (?, ?, ?, ?)");
        $stmt->execute([$classe, $target_file, $ideleve, $categorie]);
        echo "<div class='alert alert-success'>Pièce jointe archivée avec succès !</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de l'upload de la pièce jointe.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Archiver un bulletin</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="container mt-4">
        <h2 class="text-center">Archiver un document</h2>
        <form method="POST" enctype="multipart/form-data" class="w-50 mx-auto p-4 shadow bg-white mb-5">
            <div class="mb-3">
                <label class="form-label">Élève</label>
                <select name="ideleve" class="form-control" required>
                    <?php foreach ($eleves as $eleve) { ?>
                        <option value="<?= $eleve['ideleve'] ?>">
                            <?= htmlspecialchars($eleve['nom'] . ' ' . $eleve['postnom']) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Classe</label>
                <select name="classe" class="form-control" required>
                    <?php foreach ($classes as $classe) { ?>
                        <option value="<?= $classe['nomclasse'] ?>">
                            <?= htmlspecialchars($classe['nomclasse']) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="categorie" class="form-control" required>
                    <?php foreach ($categories as $cat) { ?>
                        <option value="<?= $cat ?>"><?= $cat ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Bulletin (fichier PDF)</label>
                <input type="file" name="bulletin" class="form-control" accept=".pdf" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Archiver</button>
        </form>
    </div>
</body>
</html>