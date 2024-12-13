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
 <?php
if (isset($_GET['id']) && !empty($_GET['nomlivre'])) {
    echo "<div class='col-md-6'>";
    $nomlivre = $_GET['nomlivre'];
    $sqlAuteur = "SELECT * FROM livre INNER JOIN auteur ON auteur.noauteur = livre.noauteur WHERE titre = :nomlivre";
    $stmt = $connexion->prepare($sqlAuteur);
    $stmt->bindParam(':nomlivre', $nomlivre, PDO::PARAM_STR);
    $stmt->execute();
    $specif = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Auteur : ".$specif['prenom']." ".$specif['nom']."<br>";
    echo "ISBN13 : ".$specif['isbn13']."<br>";
    echo "Résumé du livre : <br>";
    echo $specif['detail'];
    echo "</div>";
    echo "<div class='col-md-3'>";
    echo $specif['prenom']." ".$specif['nom']."<br>";
}
    else{
        echo "<div class='col-md-9'>";
        echo "Aucun livre sélectionné";
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