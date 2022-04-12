<?php

class Pengurus extends DB
{
    function getPengurus()
    {
        $query = "SELECT * FROM pengurus";
        return $this->execute($query);
    }

    function getDetailPengurus($nim)
    {
        $query = "SELECT * FROM pengurus WHERE nim=$nim";
        return $this->execute($query);
    }

    function add($nim, $nama, $semester, $img, $id_bidang)
    {

        $query = "insert into pengurus values ('$nim', '$nama', '$semester', '$img', $id_bidang)";

        // Mengeksekusi query
        return $this->execute($query);
    }
    function update($nim, $nama, $semester, $id_bidang, $nimAwal)
    {

        $query = "UPDATE pengurus SET nim='$nim', nama='$nama', semester='$semester', id_bidang='$id_bidang' WHERE nim='$nimAwal'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function updateWithImage($nim, $nama, $semester, $img, $id_bidang, $nimAwal){

        $query = "UPDATE pengurus SET nim='$nim', nama='$nama', semester='$semester', img='$img', id_bidang='$id_bidang' WHERE nim='$nimAwal'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM pengurus WHERE nim= '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}


?>