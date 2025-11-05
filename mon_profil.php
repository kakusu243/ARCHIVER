<?php
session_start();
include 'config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['iduser'])) {
    header('Location: login.php');
    exit();
}

$iduser = $_SESSION['iduser'];
$typeuser = $_SESSION['typeuser'] ?? '';

// Suppression du compte (doit être AVANT toute récupération d'utilisateur)
if (isset($_POST['delete_account'])) {
    $delete = $pdo->prepare('DELETE FROM users WHERE iduser = ?');
    $delete->execute([$iduser]);
    session_destroy();
    header('Location: login.php');
    exit();
}

// Récupérer les infos de l'utilisateur
$stmt = $pdo->prepare('SELECT * FROM users WHERE iduser = ?');
$stmt->execute([$iduser]);
$user = $stmt->fetch();

if (!$user) {
    echo "<div class='alert alert-danger'>Utilisateur introuvable.</div>";
    exit();
}

$message = '';
// Traitement de la modification du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_account'])) {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mdp'] ?? '';
    if (!empty($mdp)) {
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
        $update = $pdo->prepare('UPDATE users SET nom = ?, email = ?, mdp = ? WHERE iduser = ?');
        $update->execute([$nom, $email, $mdp_hash, $iduser]);
    } else {
        $update = $pdo->prepare('UPDATE users SET nom = ?, email = ? WHERE iduser = ?');
        $update->execute([$nom, $email, $iduser]);
    }
    $message = "<div class='alert alert-success'>Profil mis à jour !</div>";
    // Rafraîchir les données
    $stmt = $pdo->prepare('SELECT * FROM users WHERE iduser = ?');
    $stmt->execute([$iduser]);
    $user = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mon profil</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="main-content">
        <div class="container mt-4">
            <h2 class="text-center mb-4">Mon profil</h2>
            <?= $message ?>

            <div id="infos-profil" class="w-50 mx-auto p-4 shadow bg-white" style="display: <?= isset($_POST['edit']) ? 'none' : 'block' ?>;">
                <p><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Type d'utilisateur :</strong> <?= htmlspecialchars($user['typeuser']) ?></p>
                <form method="post" style="display:inline;">
                    <button type="submit" name="edit" class="btn btn-warning">Modifier les informations</button>
                </form>
                <form method="post" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                    <button type="submit" name="delete_account" class="btn btn-danger ms-2">Supprimer le compte</button>
                </form>
            </div>

            <?php if (isset($_POST['edit'])) { ?>
            <form method="POST" class="w-50 mx-auto p-4 shadow bg-white">
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($user['nom']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nouveau mot de passe</label>
                    <input type="password" name="mdp" class="form-control" placeholder="Laisser vide pour ne pas changer">
                </div>
                <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
            </form>
            <?php } ?>
        </div>
    </div>

</body>
</html>
