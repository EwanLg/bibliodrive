<!DOCTYPE html>

<html lang="fr">

<head>

  <title>Bibliodrive</title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<body>
    <?php
    include 'entete.php'
    ?>

<div class="row">

 <div class="col-md-9">
<p style="text-align: center;" class="text-success h3">Dernières acquisitions : </p>
<div id="demo" class="carousel slide" data-bs-ride="carousel" style="max-width: 70%; margin: auto;">  

  <div class="carousel-inner">
      <?php
$sql = "SELECT photo FROM livre ORDER BY dateajout DESC LIMIT 3";
$stmt = $connexion->query($sql);
$active = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  if ($active == 0) {  
    echo "<div class='carousel-item active'>
    <img src='covers/".$row['photo']."' alt='image' class='d-block w-100' style='object-fit: contain; max-height: 70vh; margin: auto; border-radius: 15px; border: 3px solid #000;'>
    </div>";
    $active += 1;
  } else {
    echo "<div class='carousel-item '>
    <img src='covers/".$row['photo']."' alt='image' class='d-block w-100' style='object-fit: contain; max-height: 70vh; margin: auto; border-radius: 15px; border: 3px solid #000;'>
   </div>";
  }
  }
 ?>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" style="background-color: black;"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
    <span class="carousel-control-next-icon" style="background-color: black;"></span>
  </button>
</div>
</div>

 <div class="col-md-3">
 <?php
    include 'authent.php'
    ?>  
 </div>
 </div>
</body>
</html>  