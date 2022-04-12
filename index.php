<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Pengurus.class.php");
include("includes/BidangDivisi.class.php");
include("includes/Divisi.class.php");

// create new instance Pengurus, open it, and get the data
$pengurus = new Pengurus($db_host, $db_user, $db_pass, $db_name);
$pengurus->open();
$pengurus->getPengurus();
$data = null;
$no = 1;

// show data from database
while (list($nim, $nama, $semester, $img, $id_bidang) = $pengurus->getResult()) {
    
    // dapatkan data bidang divisi dari foreign key
    $bidangDivisi = new BidangDivisi($db_host, $db_user, $db_pass, $db_name);
    $bidangDivisi->open();
    $bidangDivisi->getDetailBidangDivisi($id_bidang);
    $result = $bidangDivisi->getResult();

    // dapat data divisi dari foreign key yang diambil sebelumnya
    $divisi = new Divisi($db_host, $db_user, $db_pass, $db_name);
    $divisi->open();
    $divisi->getDetailDivisi($result['id_divisi']);
    $result2 = $divisi->getResult();
    
    // concatenate each data
    $data .= "
            <div class='card m-5' style='width: 13rem; display: inline-block;'>
                <a href='detail.php?nim=" . $nim . "' style='text-decoration: none;'>
                <img src='assets/images/".$img."' class='card-img-top' alt='" . $nama ."'>
                <div class='card-body'>
                    <p class='card-text' style='color: black;'>" . $nama . "</p>
                    <p class='card-text' style='color: black;'>Semester " . $semester . "</p>
                    <p class='card-text' style='color: black;'>" . $result2['nama_divisi'] . "</p>
                    <p class='card-text' style='color: black;'>" . $result['jabatan'] . "</p>
                </div>
                </a>
            </div>
            
    ";
}

// write in the html
$pengurus->close();
$tpl = new Template("templates/index.html");
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
