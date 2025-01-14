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
  if (isset($_POST['btnAjouterAuteur'])) {
  $stmt = $connexion->prepare("INSERT INTO auteur (nom, prenom) VALUES (:nom, :prenom)");
  $stmt->bindParam(':nom', $_POST['nom']);
  $stmt->bindParam(':prenom', $_POST['prenom']);
  $stmt->execute();
  echo "Auteur ajouté avec succès.";
  }
  echo "<form action='' method='post'>
        <div class='form-floating mb-3 mt-3'>
            <input type='text' class='form-control' id='nom' placeholder='Enter nom' name='nom' required >
            <label for='nom'>nom</label>
        </div>

        <div class='form-floating mt-3 mb-3'>
            <input type='prenom' class='form-control' id='prenom' placeholder='Enter prenom' name='prenom' required>
            <label for='prenom'>prenom</label>
        </div>
        <button type='submit' class='btn btn-primary' name='btnAjouterAuteur'>Ajouter</button>
  </form>
    </form>
<br><br>";

$sqlauteurs = "SELECT * FROM auteur ORDER BY nom ASC";
$stmt = $connexion->prepare($sqlauteurs);
$stmt->execute();
if ($sqlauteurs) {
  echo "<div><h3>Liste des Auteurs :</h3>";
  echo "<ul>";
  while ($enregistrement = $stmt->fetch()) { 
    echo "<li>".$enregistrement['nom']." ".$enregistrement['prenom']."</li>";
  }
  echo "</ul></div>";
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
