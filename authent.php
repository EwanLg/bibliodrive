<?php

if (!isset($_POST['btnSeConnecter'])) { 

    echo
    '<form action="" method = "post" ">
    <div class="form-floating mb-3 mt-3">
  <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
  <label for="email">Email</label>
</div>

<div class="form-floating mt-3 mb-3">
  <input type="text" class="form-control" id="pwd" placeholder="Enter password" name="motdepasse">
  <label for="pwd">Password</label>
</div>
<button type="submit" class="btn btn-primary" name="btnSeConnecter">Submit</button>
</form>';

} else

{


    require_once 'authent.php';

    $email = $_POST['email'];

    $motdepasse = $_POST['motdepasse'];

 

    $requete = "SELECT * FROM utilisateur WHERE email='" . $email . "' AND motdepasse = '" . $motdepasse . "'";


    $select = $connexion->query($requete);


    $select->setFetchMode(PDO::FETCH_OBJ);

    $enregistrement = $select->fetch();

    if ($enregistrement) { 

        echo '<h1>Connexion réussie !</h1>';

    } else { 
        echo "<h1>Echec à la connexion.</h1>";

    }

}

?>
