<?php
session_start();
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["iduser"];
        $_SESSION["typeuser"] = $user["typeuser"];
        $_SESSION["iduser"] = $user["iduser"];
        if ($user["typeuser"] == "Préfet") {
            header("Location: index.php");
        } else {
            header("Location: mes_archives.php");
        }
        exit();
    } else {
        echo "<div class='alert alert-danger'>Login ou mot de passe incorrect.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <h2 class="text-center mt-5">Connexion</h2>
        <form method="POST" class="w-50 mx-auto p-4 shadow bg-white">
            <div class="mb-3">
                <label class="form-label">Login</label>
                <input type="text" name="login" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            <a href="inscription_prefet.php">vous n'avez pas un compte? inscrivez-vous!!</a>
        </form>
    </div>
</body>
</html>