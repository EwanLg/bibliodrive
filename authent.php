<?php
session_start();  // Démarrer la session

if (!isset($_POST['btnSeConnecter'])) { 

    echo
    "<form action='".$_SERVER['PHP_SELF']."' method='post'>
    <div class='form-floating mb-3 mt-3'>
        <input type='text' class='form-control' id='email' placeholder='Enter email' name='email'>
        <label for='email'>Email</label>
    </div>

    <div class='form-floating mt-3 mb-3'>
        <input type='password' class='form-control' id='pwd' placeholder='Enter password' name='motdepasse'>
        <label for='pwd'>Password</label>
    </div>
    <button type='submit' class='btn btn-primary' name='btnSeConnecter'>Submit</button>
    </form>";

} else {
    require_once 'authent.php';

    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    // Requête pour vérifier l'utilisateur
    $requete = "SELECT * FROM utilisateur WHERE email = :email AND motdepasse = :motdepasse";
    $stmt = $connexion->prepare($requete);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':motdepasse', $motdepasse);
    $stmt->execute();

    $enregistrement = $stmt->fetch(PDO::FETCH_OBJ);

    if ($enregistrement) { 
        // Utilisateur authentifié, on crée les variables de session
        $_SESSION['user_id'] = $enregistrement->id;
        $_SESSION['user_email'] = $enregistrement->email;
        $_SESSION['user_name'] = $enregistrement->nom;

        echo '<h1>Connexion réussie ! Bienvenue, ' . $_SESSION['user_name'] . '.</h1>';
    } else { 
        echo "<h1>Echec à la connexion.</h1>";
    }
}

// Si la session existe déjà (l'utilisateur est connecté), afficher un message de bienvenue
if (isset($_SESSION['user_id'])) {
    echo "<h1>Bienvenue, " . $_SESSION['user_name'] . " !</h1>";
}
?>
