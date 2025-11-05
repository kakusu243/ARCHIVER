<?php
session_start();
include 'config.php';

// Vérifier que seul le préfet peut accéder
if (!isset($_SESSION["typeuser"]) || $_SESSION["typeuser"] != "Préfet") {
    header("Location: index.php");
    exit();
}

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$user = $pdo->prepare("SELECT * FROM users WHERE iduser = ?");
$user->execute([$id]);
$user = $user->fetch();

if (!$user) {
    echo "<div class='alert alert-danger'>Utilisateur introuvable.</div>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $typeuser = $_POST["typeuser"];
    $password = $_POST["password"];

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET login = ?, typeuser = ?, password = ? WHERE iduser = ?");
        $stmt->execute([$login, $typeuser, $password, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET login = ?, typeuser = ? WHERE iduser = ?");
        $stmt->execute([$login, $typeuser, $id]);
    }
    echo "<div class='alert alert-success'>Utilisateur modifié avec succès !</div>";
    // Optionnel : redirection
    // header("Location: liste_users.php");
    // exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modifier utilisateur</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="container mt-4">
        <h2 class="text-center">Modifier un utilisateur</h2>
        <form method="POST" class="w-50 mx-auto p-4 shadow bg-white mb-5">
            <div class="mb-3">
                <label class="form-label">Login</label>
                <input type="text" name="login" class="form-control" value="<?= htmlspecialchars($user["login"]) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Type d'utilisateur</label>
                <select name="typeuser" class="form-control" required>
                    <option value="Préfet" <?= $user["typeuser"] == "Préfet" ? "selected" : "" ?>>Préfet</option>
                    <option value="Élève" <?= $user["typeuser"] == "Élève" ? "selected" : "" ?>>Élève</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Modifier</button>
        </form>
    </div>
</body>
</html>