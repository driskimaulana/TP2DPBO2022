<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Divisi.class.php");
include("includes/Pengurus.class.php");

// create new instance for Divisi class, open it, and get the data
$divisi = new Divisi($db_host, $db_user, $db_pass, $db_name);
$divisi->open();
$divisi->getdivisi();
$data = null;
$no = 1;

// html input form
$input = '<form action="divisi.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Divisi</label>
                <input type="text" class="form-control" id="nama" name="nama">
            </div>
            <button type="submit" id="add" name="addData" class="btn btn-primary mb-3">Add Data</button>
        </form>
        ';

//  if update is clicked
if(isset($_GET['id_edit'])){
    $divisi2 = new Divisi($db_host, $db_user, $db_pass, $db_name);
    $divisi2->open();
    $id_update = $_GET['id_edit'];
    $divisi2->getDetailDivisi($id_update);
    $result = $divisi2->getResult();
    // update the form with default value is the selected data
    $input = '<form action="divisi.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Divisi</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="' . $result['nama_divisi'] .'">
                </div>
                <div class="mb-3">
                    <input type="hidden" class="form-control" id="id_divisi" name="id_divisi" value="'.$result['id_divisi'].'">
                </div>
                <button type="submit" id="submitUpdate" name="submitUpdate" class="btn btn-primary mb-3">Update</button>
            </form>
            ';
}

// execute query for update
if(isset($_POST['submitUpdate'])){
    $divisi->update($_POST['id_divisi'], $_POST['nama']);
    header('location: divisi.php');
}

// execute query for add data
if(isset($_POST['addData'])){
    $divisi->add($_POST['nama']);
    header('location: divisi.php');
}

// execute query for delete data
if(isset($_GET['id_hapus'])){
    $divisi->delete($_GET['id_hapus']);
    header('location: divisi.php');
}

// show data from database in table
while (list($id_divisi, $nama_divisi) = $divisi->getResult()) {

    $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $nama_divisi . "</td>
            <td>
            <a href='divisi.php?id_edit=" . $id_divisi .  "' class='btn btn-warning' '>Edit</a>
            <a href='divisi.php?id_hapus=" . $id_divisi . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
}

$divisi->close();
$tpl = new Template("templates/divisi.html");
$tpl->replace("DATA_TABEL", $data);
$tpl->replace("INPUT_FORM", $input);
$tpl->write();