<?php
include 'config.php';

// Vérifier si l'ID de la section est fourni
if (!isset($_GET['idsection'])) {
    header('Location: gerer_section.php');
    exit();
}

$idsection = intval($_GET['idsection']);
$message = '';

// Récupérer les infos de la section
$stmt = $pdo->prepare('SELECT * FROM section WHERE idsection = ?');
$stmt->execute([$idsection]);
$section = $stmt->fetch();

if (!$section) {
    header('Location: gerer_section.php');
    exit();
}

// Traitement de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nomsection'])) {
    $nouveauNom = $_POST['nomsection'];
    $update = $pdo->prepare('UPDATE section SET nomsection = ? WHERE idsection = ?');
    $update->execute([$nouveauNom, $idsection]);
    $message = "<div class='alert alert-success'>Section modifiée avec succès !</div>";
    // Rafraîchir les données
    $section['nomsection'] = $nouveauNom;

    header("Location: gerer_section.php?success=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modifier la section</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="main-content">
    <div class="container mt-4">
        <h2 class="text-center">Modifier la section</h2>
        <?= $message ?>
        <form method="POST" class="w-50 mx-auto p-4 shadow bg-white">
            <div class="mb-3">
                <label class="form-label">Nom de la section</label>
                <input type="text" name="nomsection" class="form-control" value="<?= htmlspecialchars($section['nomsection']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
            <button type="button" class="btn btn-secondary w-100 mt-2" onclick="window.history.back();">Annuler</button>
        </form>
    </div>
    </div>
</body>
</html>
