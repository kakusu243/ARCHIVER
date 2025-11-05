<?php
include 'config.php';

// Récupérer les sections et classes pour les listes déroulantes
$sections = $pdo->query("SELECT * FROM section")->fetchAll();
$classes = $pdo->query("SELECT * FROM classe")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $postnom = $_POST["postnom"];
    $sexe = $_POST["sexe"];
    $datenaissance = $_POST["datenaissance"];
    $idsection = $_POST["idsection"];
    $idclasse = $_POST["idclasse"];
    $login = $_POST["login"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $photo = $_FILES["photo"]["name"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo);

    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

    $stmt = $pdo->prepare("INSERT INTO eleves (nom, postnom, sexe, datenaissance, idsection, idclasse, login, password, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $postnom, $sexe, $datenaissance, $idsection, $idclasse, $login, $password, $target_file]);

    // Ajouter l'élève comme user
    $stmtUser = $pdo->prepare("INSERT INTO users (login, password, typeuser) VALUES (?, ?, 'Élève')");
    $stmtUser->execute([$login, $password]);

    echo "<div class='alert alert-success'>Élève enregistré avec succès !</div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Enregistrer un élève</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css.map">
</head>
<body class="bg-light ">
    <?php
    require_once('header.php'); 
    ?>
    
    <a href="index.php" class="btn btn-danger mt-2 ms-3">Retour</a>
    <a href="liste_eleves.php" class="btn btn-success mt-2 ms-3">Voir les élèves</a>
    <div class="container">
        <h2 class="text-center">Enregistrer un élève</h2>
        <form method="POST" enctype="multipart/form-data" class="w-50 mx-auto p-4 shadow bg-white mb-5">
            <div class="mb-2">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Postnom</label>
                <input type="text" name="postnom" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Sexe</label>
                <select name="sexe" class="form-control">
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Date de naissance</label>
                <input type="date" name="datenaissance" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Section</label>
                <select name="idsection" class="form-control" required>
                    <?php foreach ($sections as $section) { ?>
                        <option value="<?= $section['idsection'] ?>"><?= htmlspecialchars($section['nomsection']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Classe</label>
                <select name="idclasse" class="form-control" required>
                    <?php foreach ($classes as $classe) { ?>
                        <option value="<?= $classe['idclasse'] ?>"><?= htmlspecialchars($classe['nomclasse']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Login</label>
                <input type="text" name="login" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Photo</label>
                <input type="file" name="photo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
        </form>
    </div>
</body>
</html>