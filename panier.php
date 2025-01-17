<?php
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['nolivre'])) {
    $key = $_GET['nolivre']; 

    if (isset($_SESSION['panier'][$key])) {
        unset($_SESSION['panier'][$key]); 
        $_SESSION['message'] = "Le livre a été supprimé de votre panier.";
    } else {
        $_SESSION['message'] = "Le livre n'existe pas dans votre panier.";
    }

    header('Location: panier.php');
    exit();
}

$empruntsEnCours = 0;
$maxEmprunts = 5; 
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $stmt = $connexion->prepare("SELECT COUNT(*) FROM emprunter WHERE email = :email AND dateretour IS NULL");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $empruntsEnCours = $stmt->fetchColumn();
}

$reservationsRestantes = $maxEmprunts - $empruntsEnCours;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibliodrive - Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'entete.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-9 col-md-8 mb-3">
                <h3 class="text-center">Votre Panier</h3>

                <p>Emprunts en cours: <?php echo $empruntsEnCours; ?></p>
                <p>Réservations possibles: <?php echo $reservationsRestantes; ?></p>

                <!-- Affichage des messages de confirmation -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info">
                        <?php echo $_SESSION['message']; ?>
                        <?php unset($_SESSION['message']); ?>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <?php
                    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])):
                        foreach ($_SESSION['panier'] as $key => $book): ?>
                            <div class='col-md-6 col-lg-4 mb-4'>
                                <div class='card'>
                                    <img src='covers/<?php echo $book['photo']; ?>' class='card-img-top' alt='<?php echo $book['titre']; ?>' style='height: 200px; object-fit: cover;'>
                                    <div class='card-body'>
                                        <h5 class='card-title'><?php echo $book['titre']; ?></h5>
                                        <p class='card-text'>Auteur: <?php echo $book['auteur']; ?></p>
                                        <a href='panier.php?nolivre=<?php echo $key; ?>&action=supprimer' class='btn btn-danger'>Supprimer</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; 
                    else: ?>
                        <div class="col-12 text-center"><p>Votre panier est vide.</p></div>
                    <?php endif; ?>
                </div>

                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <?php if (isset($_SESSION['panier']) && is_array($_SESSION['panier']) && count($_SESSION['panier']) > 0): ?>
                            <a href="valider_panier.php" class="btn btn-success">Valider le panier</a>
                            <a href="annuler_panier.php" class="btn btn-warning">Annuler l'emprunt</a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="col-lg-3 col-md-4">
                <?php include 'authent.php'; ?> 
            </div>
        </div>
    </div>

</body>
</html>
