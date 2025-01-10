<?php
try {

  $dns = 'mysql:host=localhost;dbname=bibliodrive';

  $utilisateur = 'root';

  $motDePasse = '';

  $connexion = new PDO( $dns, $utilisateur, $motDePasse );

} catch (Exception $e) {

  echo "Connexion à MySQL impossible : ", $e->getMessage();

  die();

  
}

?>
<div class="container-fluid">

   <div class="row">
      <div class="col-md-9">
         <p class="h3">La bibliothèque de Moulinsart est fermée au public jusqu'à nouvel ordre. Mais il vous est possible de réserver et retirer vos mivres via notre service Biblio Drive !</p>
         <nav class="navbar navbar-expand-sm navbar-dark bg-light">
            <div class="container-fluid">
               <form style="width: 100vh;" class="d-flex" action="lister_livres.php" method = "get">
                  <input class="form-control me-2" name="noauteur" type="text" placeholder="Rechercher dans le catalogue (saisie du nom de l'auteur)">
                  <button class="btn btn-primary" type="submit">Rechercher</button>
               </form>
               <a href="panier.php"><button class="btn btn-danger" type="button">Panier</button></a>
            </div>
         </nav>
      </div>
      <div class="col-md-3">
         <img style="width: 70%; float: right;" src="img.jpg">
      </div>
   </div>