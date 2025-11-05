<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $typeuser = $_POST["typeuser"];

    $stmt = $pdo->prepare("INSERT INTO users (login, password, typeuser) VALUES (?, ?, ?)");
    $stmt->execute([$login, $password, $typeuser]);
    echo "<div class='alert alert-success'>Utilisateur ajouté avec succès !</div>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="container mt-4">
        <h2 class="text-center">Ajouter un utilisateur</h2>
        <form method="POST" class="w-50 mx-auto p-4 shadow bg-white mb-5">
            <div class="mb-3">
                <label class="form-label">Login</label>
                <input type="text" name="login" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Type d'utilisateur</label>
                <select name="typeuser" class="form-control" required>
                    <option value="Préfet">Préfet</option>
                    <option value="Élève">Élève</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ajouter</button>
        </form>
    </div>
</body>
</html>