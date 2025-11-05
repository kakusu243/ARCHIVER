<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivage Documents</title>
    <link href="./bootstrap-5.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<style>
    .sidebar-left {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 250px;
        background: #212936;
        color: #fff;
        z-index: 1040;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        padding-top: 2rem;
        box-shadow: 2px 0 8px rgba(0,0,0,0.08);
    }
    .sidebar-left .navbar-brand {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 2.5rem;
        color: #fff;
        text-align: left;
        padding-left: 1.5rem;
    }
    .sidebar-left .nav {
        flex-direction: column;
        width: 100%;
    }
    .sidebar-left .nav-link {
        color: #cbd5e1;
        margin-bottom: 0.3rem;
        border-radius: 0.375rem;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        transition: background 0.2s, color 0.2s;
        display: flex;
        align-items: center;
    }
    .sidebar-left .nav-link.active, .sidebar-left .nav-link:hover {
        background: #2e3748;
        color: #fff;
    }
    .sidebar-left .btn-danger {
        margin-top: 2rem;
        margin-left: 1.5rem;
        margin-right: 1.5rem;
    }
    @media (max-width: 991.98px) {
        .sidebar-left {
            width: 100vw;
            height: auto;
            position: static;
            flex-direction: row;
            padding: 0.5rem 0;
            box-shadow: none;
        }
        .sidebar-left .navbar-brand {
            margin-bottom: 0;
            margin-right: 1rem;
            padding-left: 0.5rem;
        }
        .sidebar-left ul {
            flex-direction: row;
        }
        .sidebar-left .nav-link {
            margin-bottom: 0;
            margin-right: 0.5rem;
            padding: 0.5rem 0.8rem;
        }
        .sidebar-left .btn-danger {
            margin: 0.5rem 0.5rem 0 0.5rem;
        }
    }
</style>
<nav class="sidebar-left mr-3">
    <a class="navbar-brand" href="dashboard.php">Archivage <br>des documents</a>
    <ul class="nav">
        <?php if (!isset($_SESSION['typeuser']) || $_SESSION['typeuser'] != 'Élève') { ?>
            <li class="nav-item"><a class="nav-link fw-bold" href="dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="enregistrer.php">Ajouter Élève</a></li>
            <li class="nav-item"><a class="nav-link" href="archiver.php">Archiver Document</a></li>
            <li class="nav-item"><a class="nav-link" href="gerer_section.php">Gérer Section</a></li>
            <li class="nav-item"><a class="nav-link" href="gerer_classe.php">Gérer Classe</a></li>
            <li class="nav-item"><a class="nav-link" href="liste_archives.php">Tous les archives</a></li>
        <?php } ?>
        <!-- <li class="nav-item"><a class="nav-link" href="mon_profil.php">Mon profil</a></li> -->
    </ul>
    <a class="btn btn-danger text-white" href="logout.php">Déconnexion</a>
</nav>


<script src="./bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js"></script>
<style>
    .main-content {
        margin-left: 250px;
        padding: 2rem 1rem 1rem 1rem;
        min-height: 100vh;
        background: #f8fafc;
    }
    @media (max-width: 991.98px) {
        .main-content {
            margin-left: 0;
            padding: 1rem;
        }
    }
</style>
</body>
</html>