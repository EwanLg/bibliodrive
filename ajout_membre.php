<!DOCTYPE html>

<html lang="fr">

<head>

  <title>Bibliodrive - Ajouter un Membre</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include 'entete.php';

    if (!isset($_SESSION['profil']) || $_SESSION['profil'] !== 'admin') {
        echo "<div class='alert alert-danger text-center' role='alert'>
                Accès refusé. Vous devez être administrateur pour accéder à cette page.
              </div>";
        exit;
    }

    if (!isset($_POST['ajout_membre'])) {
        ?>
        <div class="container mt-5">
            <h4 class="text-center">Créer un Membre</h4>
            <form method="POST" class="mt-4">
                <div class="row mb-3">
                    <label for="txtemail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="txtemail" name="txtemail" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="txtmdp" class="col-sm-2 col-form-label">Mot de Passe</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="txtmdp" name="txtmdp" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="txtnom" class="col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtnom" name="txtnom" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="txtprenom" class="col-sm-2 col-form-label">Prénom</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtprenom" name="txtprenom" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="txtadresse" class="col-sm-2 col-form-label">Adresse</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtadresse" name="txtadresse" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="txtville" class="col-sm-2 col-form-label">Ville</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtville" name="txtville" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="txtpostal" class="col-sm-2 col-form-label">Code Postal</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtpostal" name="txtpostal" required>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="ajout_membre" class="btn btn-primary">Créer un Membre</button>
                </div>
            </form>
        </div>
        <?php
    } else {
        $stmt = $connexion->prepare("INSERT INTO utilisateur (email, motdepasse, nom, prenom, adresse, ville, codepostal) VALUES (:email, :motdepasse, :nom, :prenom, :adresse, :ville, :codepostal)");

        $email = $_POST['txtemail'];
        $mdp = md5($_POST['txtmdp']);
        $nom = $_POST['txtnom'];
        $prenom = $_POST['txtprenom'];
        $adresse = $_POST['txtadresse'];
        $ville = $_POST['txtville'];
        $postal = $_POST['txtpostal'];

        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':motdepasse', $mdp);
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':adresse', $adresse);
        $stmt->bindValue(':ville', $ville);
        $stmt->bindValue(':codepostal', $postal);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center' role='alert'>
                    Le membre a été ajouté avec succès !
                  </div>";
        } else {
            echo "<div class='alert alert-danger text-center' role='alert'>
                    Une erreur est survenue lors de l'ajout du membre.
                  </div>";
        }
    }
    ?>

    <?php include('authent.php'); ?>
</body>
</html>
