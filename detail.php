<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Pengurus.class.php");
include("includes/BidangDivisi.class.php");
include("includes/Divisi.class.php");

if(isset($_GET['nim'])){

    // create new instance pengurus class
    $pengurus = new Pengurus($db_host, $db_user, $db_pass, $db_name);
    $pengurus->open();

    // get nim from url
    $getNim = $_GET['nim'];
    $pengurus->getDetailPengurus($getNim);
    $data = null;
    $no = 1;
    list($nim, $nama, $semester, $img, $id_bidang) = $pengurus->getResult();

    
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
    
    // show data
    $data .= "
            <div class='row'>
                <div class='col-md-4'></div>
                <div class='card m-5 col-md-8 justify-content-center' style='width: 20rem; display: inline-block;'>
                    <a href='index.php' style='text-decoration: none;'>
                    <img src='assets/images/".$img."' class='card-img-top' alt='" . $nama ."'>
                    <div class='card-body'>
                        <p class='card-text' style='color: black;'>" . $nama . "</p>
                        <p class='card-text' style='color: black;'>Semester " . $semester . "</p>
                        <p class='card-text' style='color: black;'>" . $result2['nama_divisi'] . "</p>
                        <p class='card-text' style='color: black;'>" . $result['jabatan'] . "</p>
                        <a class='btn btn-primary mt-3' href='pengurus.php?update&nim=".$getNim."'>Update</a>
                        <a class='btn btn-danger mt-3' href='pengurus.php?delete&nim=".$getNim."'>Delete</a>
                    </div>
                    
                    </a>
                </div>
            </div>

            
    ";

    // write in html
    $pengurus->close();
    $tpl = new Template("templates/detail.html");
    $tpl->replace("DATA_TABEL", $data);
    $tpl->write();


}

