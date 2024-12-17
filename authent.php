<?php
session_start(); 

if (isset($_POST['btnDeconnecter'])) {
    session_unset(); 
    session_destroy(); 
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['btnSeConnecter'])) {
    require_once 'authent.php';

    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    $requete = "SELECT * FROM utilisateur WHERE email = :email AND motdepasse = :motdepasse";
    $stmt = $connexion->prepare($requete);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':motdepasse', $motdepasse);
    $stmt->execute();

    $enregistrement = $stmt->fetch(PDO::FETCH_OBJ);

    if ($enregistrement) {
        $_SESSION['email'] = $enregistrement->email;
        $_SESSION['motdepasse'] = $enregistrement->motdepasse;
        $_SESSION['prenom'] = $enregistrement->prenom;  
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error_message = 'Identifiants incorrects. Veuillez réessayer.';
    }
}

if (isset($_SESSION['email'])) {
    echo "<h1>Bienvenue, " . $_SESSION['prenom'] . " !</h1>";

    echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
        <button type='submit' class='btn btn-danger' name='btnDeconnecter'>Se déconnecter</button>
    </form>";
} else {
    echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
        <div class='form-floating mb-3 mt-3'>
            <input type='text' class='form-control' id='email' placeholder='Enter email' name='email' required value='" . (isset($email) ? $email : '') . "'>
            <label for='email'>Email</label>
        </div>

        <div class='form-floating mt-3 mb-3'>
            <input type='password' class='form-control' id='pwd' placeholder='Enter password' name='motdepasse' required>
            <label for='pwd'>Password</label>
        </div>";
        
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }

    echo "<button type='submit' class='btn btn-primary' name='btnSeConnecter'>Se connecter</button>
    </form>";
}
?>
