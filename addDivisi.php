<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Pengurus.class.php");
include("includes/BidangDivisi.class.php");
include("includes/Divisi.class.php");

$isUpdate = false;


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= !$isUpdate ? "Add Data" : "Update Data"?></title>
  <!-- import bootstrap -->
  <link rel="stylesheet" href="assets/style/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/style/style.css">
</head>

<body >
  <nav class="navbar navbar-expand-lg navbar-dark ">
      <div class="container-fluid">
        <a class="navbar-brand text-white" href="index.php"><img src="assets/images/logo.png" width="100px" alt="" srcset=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link text-black active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-black" href="divisi.php">Divisi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-black" href="bidangDivisi.php">Bidang Divisi</a>
            </li>
          </ul>
        </div>
      </div>
  </nav>

  <div class="container-fluid mt-5 align-center">
    <div class="col-lg-3 col-md-3 col-sm-12 col-12 mx-auto my-5">

      <h1 class="text-center pt-3"><?=$isUpdate ? "Update" : "Input"?> Pengurus</h1>
      <form action="pengurus.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" value="<?= $isUpdate ? $result['nim'] : "" ?>">
        </div>

        
        <button type="submit" id="addPengurus" name="<?= !$isUpdate ? "addPengurus" : "updatePengurus"?>" class="btn btn-primary">Submit</button>
        
        
      </form>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
</body>

</html>