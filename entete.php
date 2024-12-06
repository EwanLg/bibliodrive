<?php

// Connexion au serveur

try {

  $dns = 'mysql:host=localhost;dbname=bibliodrive'; // dbname : nom de la base

  $utilisateur = 'root'; // root sur vos postes

  $motDePasse = ''; // pas de mot de passe sur vos postes

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
               <form style="width: 100vh;" class="d-flex">
                  <input class="form-control me-2" type="text" placeholder="Search">
                  <button class="btn btn-primary" type="button">Search</button>
               </form>
               <button class="btn btn-danger" type="button">Panier</button>
            </div>
         </nav>
      </div>
      <div class="col-md-3">
         <img style="width: 70%; float: right;" src="img.jpg">
      </div>
   </div>