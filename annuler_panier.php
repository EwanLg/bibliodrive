<?php
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        foreach ($_SESSION['panier'] as $key => $book) {
            $livreId = $book['id'];  
            $stmt = $connexion->prepare("SELECT * FROM emprunter WHERE email = :email AND nolivre = :nolivre AND dateretour IS NULL");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nolivre', $livreId);
            $stmt->execute();
            $empruntActuel = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($empruntActuel) {
                $stmtUpdate = $connexion->prepare("UPDATE emprunter SET dateretour = NOW() WHERE email = :email AND nolivre = :nolivre AND dateretour IS NULL");
                $stmtUpdate->bindParam(':email', $email);
                $stmtUpdate->bindParam(':nolivre', $livreId);
                $stmtUpdate->execute();
            } else {

                $_SESSION['message'] = "Le livre '{$book['titre']}' n'est pas emprunté, il ne peut pas être annulé.";
                header('Location: panier.php');
                exit();
            }
        }
        unset($_SESSION['panier']);
        $_SESSION['message'] = "Votre panier a été annulé avec succès. Les livres ont été retournés.";
    } else {
        $_SESSION['message'] = "Veuillez vous connecter pour annuler votre panier.";
    }
} else {
    $_SESSION['message'] = "Aucun panier à annuler.";
}
header('Location: panier.php');
exit();
?>
