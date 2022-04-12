<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Pengurus.class.php");
include("includes/BidangDivisi.class.php");
include("includes/Divisi.class.php");

// variable, flag for update state
$isUpdate = false;

// if add is clicked
if (isset($_POST['addPengurus'])) {
  
  // get the data
  $nim = $_POST['nim'];
  $nama = $_POST['nama'];
  $semester = $_POST['semester'];
  $id_bidang = $_POST['divisi'];

  // path image upload
  $targetDir = "assets/images/";
  $fileName = basename($_FILES['images']["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

  $newPengurus = new Pengurus($db_host, $db_user, $db_pass, $db_name);

  $newPengurus->open();

  // tipe image diperbolehkan
  $allowTypes = array('jpg','png','jpeg','gif','pdf');
  if(in_array($fileType, $allowTypes)){
      // upload image ke server
      if(move_uploaded_file($_FILES["images"]["tmp_name"], $targetFilePath)){
          // Insert ke dalam database
          $insert = $newPengurus->add($nim, $nama, $semester, $fileName, $id_bidang);
      }else{
          $statusMsg = "Error saat proses upload image";
      }
  }else{
      $statusMsg = 'Maaf, hanya menerima JPG, JPEG, PNG, GIF, & PDF file.';
  }
}

// if delete is clicked
if(isset($_GET['delete'])){
  $pengurus = new Pengurus($db_host, $db_user, $db_pass, $db_name);

  $pengurus->open();

  $nim = $_GET['nim'];

  // delete data
  $pengurus->delete($nim);

  header('location: index.php');

}


// if update is clicked
if (isset($_POST['updatePengurus'])) {
  
  // get data
  $nim = $_POST['nim'];
  $nim_lama = $_POST['nim_lama'];
  $nama = $_POST['nama'];
  $semester = $_POST['semester'];
  $id_bidang = $_POST['divisi'];

  $img = $_POST['images'];

  $pengurus = new Pengurus($db_host, $db_user, $db_pass, $db_name);

  $pengurus->open();

  $pengurus->update($nim, $nama, $semester, $id_bidang, $nim_lama);
  

  // path image upload
  $targetDir = "assets/images/";
  $fileName = basename($_FILES['images']["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

  $newPengurus = new Pengurus($db_host, $db_user, $db_pass, $db_name);

  $newPengurus->open();

  // tipe image diperbolehkan
  $allowTypes = array('jpg','png','jpeg','gif','pdf');
  if(in_array($fileType, $allowTypes)){
      // upload image ke server
      if(move_uploaded_file($_FILES["images"]["tmp_name"], $targetFilePath)){
          // Insert ke dalam database
          $insert = $newPengurus->updateWithImage($nim, $nama, $semester, $fileName, $id_bidang, $nim_lama);           
      }else{
          $statusMsg = "Error saat proses upload image";
      }
  }else{
      $statusMsg = 'Maaf, hanya menerima JPG, JPEG, PNG, GIF, & PDF file.';
  }

  header('location: index.php');

}

// if update is clicked
if(isset($_GET['update'])){
  $isUpdate = true;
  
  $pengurus = new Pengurus($db_host, $db_user, $db_pass, $db_name);
  $pengurus->open();

  $nim = $_GET['nim'];

  $pengurus->getDetailPengurus($nim);

  $result = $pengurus->getResult();

}

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
    <div class="col-lg-8 col-md-8 col-sm-12 col-12 mx-auto my-5">

      <h1 class="text-center pt-3"><?=$isUpdate ? "Update" : "Input"?> Pengurus</h1>
      <form action="pengurus.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" value="<?= $isUpdate ? $result['nim'] : "" ?>">
        </div>
        <div class="mb-3">
            <input type="hidden" class="form-control" id="nim_lama" name="nim_lama" value="<?= $isUpdate ? $result['nim'] : "" ?>">
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $isUpdate ? $result['nama'] : "" ?>">
        </div>
        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <input type="text" class="form-control" id="semester" name="semester" value="<?= $isUpdate ? $result['semester'] : "" ?>">
        </div>
        <div class="input-group mb-3 mt-3">
                <label class="input-group-text" for="divisi">Divisi dan Bidang</label>
                
                <select class="form-select" id="divisi" name="divisi" required>
                    <option selected >Choose...</option>
                    <?php
                    // dapat data divisi 
                    $bidangDivisi = new BidangDivisi($db_host, $db_user, $db_pass, $db_name);
                    $bidangDivisi->open();
                    $bidangDivisi->getBidangDivisi();

                    while(list($id_bidang, $jabatan, $id_divisi) = $bidangDivisi->getResult()){
                      $divisi = new Divisi($db_host, $db_user, $db_pass, $db_name);
                      $divisi->open();
                      $divisi->getDetailDivisi($id_divisi);
                      $result2 = $divisi->getResult();
                    ?>
                    
                        <option value="<?=$id_bidang?>" name="bidang" <?php if($isUpdate) echo ($result['id_bidang'] == $id_bidang) ? 'selected="selected"' : ''; ?>><?= $result2['nama_divisi'] .' - '. $jabatan?></option>                    
                    <?php
                    }
                    ?>
                    
                </select>
            </div>
        <div class="mb-3">
                <label class="mb-3" for="images">Upload Image</label>
                <div class="input-group mb-3">
                <input class="form-control" type="file" name="images" id="images">
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