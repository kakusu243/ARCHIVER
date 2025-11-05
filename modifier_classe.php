<?php
include 'config.php';

// Vérifier si l'ID de la classe est fourni
if (!isset($_GET['idclasse'])) {
    header('Location: gerer_classe.php');
    exit();
}

$idclasse = intval($_GET['idclasse']);
$message = '';

// Récupérer les infos de la classe
$stmt = $pdo->prepare('SELECT * FROM classe WHERE idclasse = ?');
$stmt->execute([$idclasse]);
$classe = $stmt->fetch();

if (!$classe) {
    header('Location: gerer_classe.php');
    exit();
}

// Récupérer les sections pour la liste déroulante
$sections = $pdo->query('SELECT * FROM section')->fetchAll();

// Traitement de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nomclasse'], $_POST['idsection'])) {
    $nouveauNom = $_POST['nomclasse'];
    $nouvelleSection = $_POST['idsection'];
    $update = $pdo->prepare('UPDATE classe SET nomclasse = ?, idsection = ? WHERE idclasse = ?');
    $update->execute([$nouveauNom, $nouvelleSection, $idclasse]);
    $message = "<div class='alert alert-success'>Classe modifiée avec succès !</div>";
    // Rafraîchir les données
    $classe['nomclasse'] = $nouveauNom;
    $classe['idsection'] = $nouvelleSection;
    header('Location: gerer_classe.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modifier la classe</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="main-content">
    <div class="container mt-4">
        <h2 class="text-center">Modifier la classe</h2>
        <?= $message ?>
        <form method="POST" class="w-50 mx-auto p-4 shadow bg-white">
            <div class="mb-3">
                <label class="form-label">Nom de la classe</label>
                <input type="text" name="nomclasse" class="form-control" value="<?= htmlspecialchars($classe['nomclasse']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Section</label>
                <select name="idsection" class="form-control" required>
                    <?php foreach ($sections as $section) { ?>
                        <option value="<?= $section['idsection'] ?>" <?= $classe['idsection'] == $section['idsection'] ? 'selected' : '' ?>><?= htmlspecialchars($section['nomsection']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
            <button type="button" class="btn btn-secondary w-100 mt-2" onclick="window.history.back();">Annuler</button>
        </form>
    </div>
    </div>
</body>
</html>
