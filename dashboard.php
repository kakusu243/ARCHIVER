<?php
include 'config.php';

// Comptages
$nb_eleves = $pdo->query("SELECT COUNT(*) FROM eleves")->fetchColumn();
$nb_archives = $pdo->query("SELECT COUNT(*) FROM archives")->fetchColumn();
$nb_sections = $pdo->query("SELECT COUNT(*) FROM section")->fetchColumn();
$nb_classes = $pdo->query("SELECT COUNT(*) FROM classe")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="./bootstrap-5.3.6-dist/css/bootstrap.min.css">
    <style>
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            transition: transform 0.2s;
            color: #fff;
            overflow: hidden;
        }
        .dashboard-card .card-body {
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }
        .dashboard-card .card-title {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .dashboard-card .card-text {
            font-size: 1.2rem;
        }
        .dashboard-card .more-info {
            border-radius: 0 0 10px 10px;
            padding: 12px 0;
            text-align: center;
            font-weight: 500;
            text-decoration: none;
            display: block;
            transition: background 0.2s;
            color: inherit;
            background: rgba(0,0,0,0.08);
        }
        .dashboard-card .more-info:hover {
            background: rgba(0,0,0,0.18);
            text-decoration: underline;
        }
        #card-eleves {
            background: #16a2b8;
            color: #fff;
        }
        #card-eleves .more-info {
            color: #fff;
            background: rgba(0,0,0,0.08);
        }
        #card-eleves .more-info:hover {
            background: rgba(0,0,0,0.18);
        }
        #card-archives {
            background: #22b24c;
            color: #fff;
        }
        #card-archives .more-info {
            color: #fff;
            background: rgba(0,0,0,0.08);
        }
        #card-archives .more-info:hover {
            background: rgba(0,0,0,0.18);
        }
        #card-sections {
            background: #ffc107;
            color: #333;
        }
        #card-sections .more-info {
            color: #333;
            background: #0000000f;
        }
        #card-sections .more-info:hover {
            background: #00000021;
        }
        #card-classes {
            background: #e74c3c;
            color: #fff;
        }
        #card-classes .more-info {
            color: #fff;
            background: rgba(0,0,0,0.08);
        }
        #card-classes .more-info:hover {
            background: rgba(0,0,0,0.18);
        }
    </style>
</head>
<body class="bg-light">
    <?php require_once('header.php'); ?>
    <div class="main-content">
    <div class="container mt-4">
        <h1 class="mb-4" style="font-family: 'Segoe UI',sans-serif;">TABLEAU DE BORD</h1>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card dashboard-card" id="card-eleves">
                    <div class="card-body">
                        <div class="card-title"><?= $nb_eleves ?></div>
                        <div class="card-text">Elèves disponible</div>
                    </div>
                    <a href="liste_eleves.php" class="more-info">More info <span>&#8594;</span></a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card" id="card-archives">
                    <div class="card-body">
                        <div class="card-title"><?= $nb_archives ?></div>
                        <div class="card-text">Dossiers disponibles</div>
                    </div>
                    <a href="liste_archives.php" class="more-info">More info <span>&#8594;</span></a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card" id="card-sections">
                    <div class="card-body">
                        <div class="card-title"><?= $nb_sections ?></div>
                        <div class="card-text">Section disponible</div>
                    </div>
                    <a href="gerer_section.php" class="more-info">More info <span>&#8594;</span></a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card" id="card-classes">
                    <div class="card-body">
                        <div class="card-title"><?= $nb_classes ?></div>
                        <div class="card-text">Classes disponible</div>
                    </div>
                    <a href="gerer_classe.php" class="more-info">More info <span>&#8594;</span></a>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>
