<?php
$isUserConnected = isset($_SESSION['userid']) && !empty($_SESSION['userid']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$isUserConnected) {
    $email = $_POST['email'];
    $password = $_POST['motdepasse'];

    $sql = "SELECT * FROM utilisateur WHERE email = :email";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['motdepasse'])) {
        $_SESSION['userid'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $message = "Connexion réussie. Bienvenue, " . $user['email'];
    } else {
        $loginError = "Identifiants incorrects.";
    }
}

if ($isUserConnected) {
    echo "Bienvenue, vous êtes connecté !";
    echo "<a href='logout.php'>Se déconnecter</a>";
} else {
    if (isset($loginError)) {
        echo $loginError;
    }
    if (isset($message)) {
        echo $message;
    }

    echo "<form action='' method='POST'>";
    echo "<div class='mb-3 mt-3'>";
    echo "<label for='email' class='form-label'>Email:</label>";
    echo "<input type='email' class='form-control' id='email' placeholder='Entrez email' name='email' required>";
    echo "</div>";
    echo "<div class='mb-3'>";
    echo "<label for='motdepasse' class='form-label'>Mot de passe:</label>";
    echo "<input type='password' class='form-control' id='motdepasse' placeholder='Entrez mot de passe' name='motdepasse' required>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary'>Se connecter</button>";
    echo "</form>";
}
?>
