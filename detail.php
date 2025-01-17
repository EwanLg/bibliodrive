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
if (isset($_GET['nolivre']) && !empty($_GET['nolivre'])) {
    echo "<div class='col-md-6'>";
    $nolivre = $_GET['nolivre'];
    $sqlAuteur = "SELECT * FROM livre INNER JOIN auteur ON auteur.noauteur = livre.noauteur WHERE nolivre = :nolivre";
    $stmt = $connexion->prepare($sqlAuteur);
    $stmt->bindParam(':nolivre', $nolivre, PDO::PARAM_STR);
    $stmt->execute();
    $specif = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Auteur : ".$specif['prenom']." ".$specif['nom']."<br>";
    echo "ISBN13 : ".$specif['isbn13']."<br>";
    echo "Résumé du livre : <br>";
    echo $specif['detail']."<br><br>";
    echo "Date de parution : ".$specif['anneeparution'];
    echo "</div>";
    echo "<div class='col-md-3'>";
    echo $specif['prenom']." ".$specif['nom']."<br>";
    echo $specif['titre']."<br>";
    echo "<img src='covers/".$specif['photo']."' width='200vh'>";
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
 <div class="row">
 <div class='col-md-2'>
    <?php
    $sqlDisponibilite = "SELECT * FROM emprunter WHERE nolivre = :nolivre AND dateretour IS NULL";
    $stmtDisponibilite = $connexion->prepare($sqlDisponibilite);
    $stmtDisponibilite->bindParam(':nolivre', $nolivre, PDO::PARAM_STR);
    $stmtDisponibilite->execute();
    $empruntEnCours = $stmtDisponibilite->fetch();

    if ($empruntEnCours) {
        echo "<p class='text-danger'>Disponibilité : Ce livre est actuellement emprunté.</p>";
    } else {
        echo "<p class='text-success'>Disponibilité : Ce livre est disponible.</p>";
    }
    ?>
</div>
<div class='col-md-10'>
    <?php
if (isset($_SESSION['email'])) {
    echo "<a href='?nolivre=".$nolivre ."&action=ajouter' class='btn btn-primary'>Emprunter</a>";

} else{
    echo "<p class='text-danger'>Pour pouvoir réserver vous devez posséder un compter et vous identifier.</p>";
}
?>
</div>
</div>
<?php

if (isset($_GET['action']) && $_GET['action'] == 'ajouter' && isset($_GET['nolivre'])) {
    $nolivre = $_GET['nolivre'];

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }
    if (count($_SESSION['panier']) >= 5) {
        echo "<p class='text-danger'>Vous ne pouvez pas ajouter plus de 5 livres à votre panier.</p>";
    } else {
        if (!isset($_SESSION['panier'][$nolivre])) {
            $_SESSION['panier'][$nolivre] = array(
                'nolivre' => $nolivre,
                'titre' => $specif['titre'],
                'auteur' => $specif['prenom'] . " " . $specif['nom'],
                'photo' => $specif['photo'],
            );
            echo "<p class='text-success'>Le livre a été ajouté à votre panier.</p>";
        } else {
            echo "<p class='text-warning'>Ce livre est déjà dans votre panier.</p>";
        }
    }
}
?>

</body>
</html>