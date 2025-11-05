<?php
include 'config.php';

// Récupération des classes et élèves pour les listes déroulantes
$classes = $pdo->query("SELECT nomclasse FROM classe")->fetchAll();
$eleves = $pdo->query("SELECT ideleve, nom, postnom FROM eleves")->fetchAll();

$categories = ['Bulletins', 'Certificat', 'Attestation', 'CV', 'Lettre'];

$resultats = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classe = $_POST["classe"];
    $ideleve = $_POST["ideleve"];
    $categorie = $_POST["categorie"];
    $stmt = $pdo->prepare("SELECT * FROM archives WHERE classe = ? AND ideleve = ? AND categorie = ?");
    $stmt->execute([$classe, $ideleve, $categorie]);
    $resultats = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Rechercher un archive</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light main-content">
    <?php require_once('header.php'); ?>
    <div class="container mt-4">
        <h2 class="text-center">Recherche de bulletins</h2>
        <form method="POST" class="w-50 mx-auto p-4 shadow bg-white mb-4">
            <div class="mb-3">
                <label class="form-label">Classe</label>
                <select name="classe" class="form-control" required>
                    <?php foreach ($classes as $classe) { ?>
                        <option value="<?= $classe['nomclasse'] ?>"><?= htmlspecialchars($classe['nomclasse']) ?></option>
                    <?php } ?>
                </select>
            </div>
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
                <label class="form-label">Catégorie</label>
                <select name="categorie" class="form-control" required>
                    <?php foreach ($categories as $cat) { ?>
                        <option value="<?= $cat ?>"><?= $cat ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Rechercher</button>
        </form>
        <?php if (!empty($resultats)) { ?>
            <div class="mt-4">
                <h4>Résultats :</h4>
                <ul class="list-group">
                    <?php foreach ($resultats as $bulletin) { ?>
                        <li class="list-group-item">
                            <a href="<?= $bulletin['nompiece'] ?>" target="_blank">Télécharger le document</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } elseif ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
            <div class="alert alert-warning mt-4">Aucun bulletin trouvé.</div>
        <?php } ?>
    </div>
</body>
</html>