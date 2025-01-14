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

if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['nolivre'])) {
    $nolivre = $_GET['nolivre'];
    if (isset($_SESSION['panier'][$nolivre])) {
        unset($_SESSION['panier'][$nolivre]);
        $message = "Le livre a été supprimé du panier."; 
    } else {
        $message = "Le livre n'existe pas dans le panier."; 
    }
}

if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $key => $book) {
        echo "<div class='card mb-3' id='book-{$key}' style='max-width: 540px;'>
                <div class='row g-0'>
                    <div class='col-md-4'>
                        <!-- Ajuster la taille de l'image -->
                        <img src='covers/{$book['photo']}' class='img-fluid rounded-start' alt='{$book['titre']}' style='max-height: 150px; object-fit: cover;'>
                    </div>
                    <div class='col-md-8'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$book['titre']}</h5>
                            <p class='card-text'>Auteur: {$book['auteur']}</p>
                            <p><a href='?nolivre={$key}&action=supprimer' class='btn btn-danger'>Supprimer</a></p>
                        </div>
                    </div>
                </div>
              </div>";
    }
} else {
    echo "<p>Votre panier est vide.</p>";
}

if (isset($message)) {
    echo "<p class='alert alert-info'>{$message}</p>";
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
