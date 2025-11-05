<?php
include 'config.php';

if (!isset($_GET['ideleve'])) {
    echo "Élève non spécifié.";
    exit();
}
$ideleve = intval($_GET['ideleve']);
$stmt = $pdo->prepare("SELECT * FROM eleves WHERE ideleve = ?");
$stmt->execute([$ideleve]);
$eleve = $stmt->fetch();
if (!$eleve) {
    echo "Élève introuvable.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Profil élève</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="main-content">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <img src="<?= htmlspecialchars($eleve['photo']) ?>" class="rounded-circle mx-auto d-block" style="width:120px;height:120px;object-fit:cover;" alt="Photo élève">
                    <h4 class="text-center mt-2"><?= htmlspecialchars($eleve['nom']) ?> <?= htmlspecialchars($eleve['postnom']) ?></h4>
                    <ul class="list-unstyled mt-3">
                        <li><b>Sexe :</b> <?= htmlspecialchars($eleve['sexe']) ?></li>
                        <li><b>Date de naissance :</b> <?= htmlspecialchars($eleve['datenaissance']) ?></li>
                        <li><b>Login :</b> <?= htmlspecialchars($eleve['login']) ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-4">
                    <h5>Informations complémentaires</h5>
                    <p><b>Section :</b> <?php
                        $section = $pdo->prepare("SELECT nomsection FROM section WHERE idsection = ?");
                        $section->execute([$eleve['idsection']]);
                        echo htmlspecialchars($section->fetchColumn());
                    ?></p>
                    <p><b>Classe :</b> <?php
                        $classe = $pdo->prepare("SELECT nomclasse FROM classe WHERE idclasse = ?");
                        $classe->execute([$eleve['idclasse']]);
                        echo htmlspecialchars($classe->fetchColumn());
                    ?></p>
                </div>
            </div>
        </div>
        <a href="liste_eleves.php" class="btn btn-secondary mt-3">Retour à la liste</a>
    </div>
    </div>
</body>
</html>
