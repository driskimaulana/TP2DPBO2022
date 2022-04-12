<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/BidangDivisi.class.php");
include("includes/Divisi.class.php");

// crete new instance for BidangDivisi class, open it, and get data
$bidangDivisi = new BidangDivisi($db_host, $db_user, $db_pass, $db_name);
$bidangDivisi->open();
$bidangDivisi->getBidangDivisi();
$data = null;
$no = 1;

// crete new instance for Divisi class, open it, and get data
$divisi = new Divisi($db_host, $db_user, $db_pass, $db_name);
$divisi->open();
$divisi->getdivisi();
$input_divisi = null;
$no = 1;

// create html element option menu, used in input divisi
while (list($id_divisi, $nama_divisi) = $divisi->getResult()) {
    if($no == 1){
        $input_divisi .= '<option value="'. $id_divisi .'" name="divisi">'.$nama_divisi.'</option>';
    }
}

// concatenate html element
$input = '<form action="bidangDivisi.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="nama" name="nama">
            </div>
            <div class="input-group mb-3 mt-3">
                <label class="input-group-text" for="prodi">Divisi</label>         
                <select class="form-select" id="divisi" name="divisi" required>
                    <option selected >Choose...</option>
                    '.$input_divisi.'
                </select>
            </div>
            <button type="submit" id="add" name="addData" class="btn btn-primary mb-3">Add Data</button>
        </form>
        ';

// if edit button is clicked
if(isset($_GET['id_edit'])){
    $bidangDivisi2 = new bidangDivisi($db_host, $db_user, $db_pass, $db_name);
    $bidangDivisi2->open();
    $id_update = $_GET['id_edit'];
    $bidangDivisi2->getDetailbidangDivisi($id_update);
    $result = $bidangDivisi2->getResult();
    // add form, become update form
    $input = '<form action="bidangDivisi.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="' . $result['jabatan'] .'">
                </div>
                <div class="mb-3">
                    <input type="hidden" class="form-control" id="id_bidang" name="id_bidang" value="'.$result['id_bidang'].'">
                </div>
                <div class="input-group mb-3 mt-3">
                    <label class="input-group-text" for="prodi">Divisi</label>         
                    <select class="form-select" id="divisi" name="divisi" required>
                        <option selected required>Choose...</option>
                        '.$input_divisi.'
                    </select>
                </div>
                <button type="submit" id="submitUpdate" name="submitUpdate" class="btn btn-primary mb-3">Update</button>
            </form>
            ';
}

// execute query for updating data
if(isset($_POST['submitUpdate'])){
    $bidangDivisi->update($_POST['id_bidang'], $_POST['nama'], $_POST['divisi']);
    header('location: bidangDivisi.php');
}

// execute query for adding data
if(isset($_POST['addData'])){
    $bidangDivisi->add($_POST['nama'], $_POST['divisi']);
    header('location: bidangDivisi.php');
}

// execute query for deleting data
if(isset($_GET['id_hapus'])){
    $bidangDivisi->delete($_GET['id_hapus']);
    header('location: bidangDivisi.php');
}

// show the data from database in table
while (list($id_bidang, $jabatan, $id_divisi) = $bidangDivisi->getResult()) {
    // create new instance divisi to get the divisi name
    $divisi2 = new Divisi($db_host, $db_user, $db_pass, $db_name);
    $divisi2->open();
    $divisi2->getDetailDivisi($id_divisi);
    $result = $divisi2->getResult();
    $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $result['nama_divisi'] . "</td>
            <td>" . $jabatan . "</td>
            <td>
            <a href='bidangDivisi.php?id_edit=" . $id_bidang .  "' class='btn btn-warning' '>Edit</a>
            <a href='bidangDivisi.php?id_hapus=" . $id_bidang . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
}

$bidangDivisi->close();
$tpl = new Template("templates/bidangDivisi.html");
$tpl->replace("DATA_TABEL", $data);
$tpl->replace("INPUT_FORM", $input);
$tpl->write();