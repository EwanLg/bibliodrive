<?php
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
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

    if ($reservationsRestantes > 0) {
        try {
            $connexion->beginTransaction();

            foreach ($_SESSION['panier'] as $key => $book) {
                $nolivre = $book['nolivre'];

                $stmt = $connexion->prepare("SELECT COUNT(*) FROM livre WHERE nolivre = :nolivre");
                $stmt->bindParam(':nolivre', $nolivre);
                $stmt->execute();
                $livreExiste = $stmt->fetchColumn();

                if ($livreExiste > 0) {
                    $stmt = $connexion->prepare("INSERT INTO emprunter (email, nolivre, dateemprunt) VALUES (:email, :nolivre, NOW())");
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':nolivre', $nolivre);
                    $stmt->execute();
                } else {
                    throw new Exception("Le livre avec la référence $nolivre n'existe pas dans la base de données.");
                }
            }

            $connexion->commit();

            unset($_SESSION['panier']);
            $_SESSION['message'] = "Votre panier a été validé avec succès!";
        } catch (Exception $e) {
            $connexion->rollBack();
            $_SESSION['message'] = "Une erreur est survenue: " . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = "Vous avez atteint votre limite d'emprunts en cours.";
    }
} else {
    $_SESSION['message'] = "Votre panier est vide.";
}

header('Location: panier.php');
exit();
?>