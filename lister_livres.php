<!DOCTYPE html>

<html lang="fr">

<head>

  <title>Bibliodrive</title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<body>
    <?php
    include 'entete.php'
    ?>

<div class="row">

 <div class="col-md-9">
 <?php
if (isset($_GET['noauteur']) && !empty($_GET['noauteur'])) {
    // Récupère la valeur de 'noauteur' depuis l'URL
    $noauteur = htmlspecialchars($_GET['noauteur']);

    // Requête SQL pour vérifier si l'auteur existe dans la table 'auteur' en utilisant le nom
    $sqlAuteur = "SELECT noauteur FROM auteur WHERE nom = :nom";
    $stmt = $connexion->prepare($sqlAuteur);
    $stmt->bindParam(':nom', $noauteur, PDO::PARAM_STR); // Utilise PDO::PARAM_STR pour les chaînes

    try {
        $stmt->execute();
        $auteur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($auteur) {

            // Requête SQL pour obtenir les titres des livres de cet auteur
            $sqlLivres = "SELECT titre FROM livre WHERE noauteur = :noauteur";
            $stmtLivres = $connexion->prepare($sqlLivres);
            $stmtLivres->bindParam(':noauteur', $auteur['noauteur'], PDO::PARAM_INT); // Assurez-vous que c'est un entier
            $stmtLivres->execute();
            $livres = $stmtLivres->fetchAll(PDO::FETCH_ASSOC);

            // Affiche les résultats
            if ($livres) {
                echo "<h3>Livres de l'auteur :</h3>";
                echo "<ul>";
                foreach ($livres as $livre) {
                    echo "<li>" . htmlspecialchars($livre['titre']) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucun livre trouvé pour cet auteur.</p>";
            }
        } else {
            // Affiche un message de débogage si l'auteur n'est pas trouvé
            echo "<p>Auteur non trouvé pour le nom : " . htmlspecialchars($noauteur) . "</p>";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    }
} else {
    echo "<p>Veuillez entrer le nom de l'auteur pour effectuer la recherche.</p>";
}
?>



</div>

 <div class="col-md-3">
 <?php
    include 'authent.php'
    ?>  
 </div>
 </div>
</body>
</html>  