<?php
include 'config.php';

// Vérifier s'il existe déjà un préfet
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE typeuser = 'Préfet'");
$stmt->execute();
$nb_prefet = $stmt->fetchColumn();

if ($nb_prefet > 0) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (login, password, typeuser) VALUES (?, ?, 'Préfet')");
    $stmt->execute([$login, $password]);
    echo "<div class='alert alert-success'>Préfet inscrit avec succès !</div>";
    // Redirection vers la connexion
    header("Refresh:2; url=login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Inscription du préfet</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="text-center">Inscription du préfet</h2>
        <form method="POST" class="w-50 mx-auto p-4 shadow bg-white mb-5">
            <div class="mb-3">
                <label class="form-label">Login</label>
                <input type="text" name="login" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </form>
    </div>
</body>
</html>