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
    <title>Bibliodrive - Ajouter un Livre</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center text-warning">Ajouter un Livre</h1>
        <?php
        if (!isset($_POST['btnlivre'])) {
            $stmt = $connexion->prepare("SELECT noauteur, nom, prenom FROM auteur");
            $stmt->execute();
            $auteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="auteur" class="form-label">Auteur</label>
                    <select name="auteur" id="auteur" class="form-select" required>
                        <option value="">Sélectionnez un auteur</option>
                        <?php foreach ($auteurs as $auteur) { ?>
                            <option value="<?= $auteur['noauteur'] ?>"><?= $auteur['nom'] . " " . $auteur['prenom'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                </div>
                <div class="mb-3">
                    <label for="isbn13" class="form-label">ISBN13</label>
                    <input type="text" class="form-control" id="isbn13" name="isbn13" required>
                </div>
                <div class="mb-3">
                    <label for="annee" class="form-label">Année de Parution</label>
                    <input type="text" class="form-control" id="annee" name="annee" required>
                </div>
                <div class="mb-3">
                    <label for="detail" class="form-label">Résumé</label>
                    <textarea class="form-control" id="detail" name="detail" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Image (URL)</label>
                    <input type="text" class="form-control" id="photo" name="photo">
                </div>
                <button type="submit" name="btnlivre" class="btn btn-primary">Ajouter le Livre</button>
            </form>
        <?php
        } else {
            $stmt = $connexion->prepare("INSERT INTO livre (noauteur, titre, isbn13, anneeparution, detail, photo, dateajout)
                VALUES (:auteur, :titre, :isbn13, :anneeparution, :detail, :photo, :dateajout)");
            $stmt->execute([
                ':auteur' => $_POST['auteur'],
                ':titre' => $_POST['titre'],
                ':isbn13' => $_POST['isbn13'],
                ':anneeparution' => $_POST['annee'],
                ':detail' => $_POST['detail'],
                ':photo' => $_POST['photo'],
                ':dateajout' => date('Y-m-d H:i:s'),
            ]);
            echo "<p class='text-success'>Livre ajouté avec succès.</p>";
        }
        ?>
    </div>
</body>

</html>
