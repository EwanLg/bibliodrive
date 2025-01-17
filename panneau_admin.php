<?php
include 'entete.php';

if (!isset($_SESSION['profil']) || $_SESSION['profil'] !== 'admin') {
    echo "<p>Accès refusé. Vous devez être administrateur pour accéder à cette page.<p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Bibliodrive - Panneau Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary">Panneau d'administration</h1>
        <div class="row mt-4">
            <div class="col-md-4">
                <a href="ajout_auteur.php" class="btn btn-success btn-block w-100">Ajouter un auteur</a>
            </div>
            <div class="col-md-4">
                <a href="ajout_livre.php" class="btn btn-warning btn-block w-100">Ajouter un livre</a>
            </div>
            <div class="col-md-4">
                <a href="ajout_membre.php" class="btn btn-info btn-block w-100">Créer un membre</a>
            </div>
        </div>
    </div>
</body>

</html>
