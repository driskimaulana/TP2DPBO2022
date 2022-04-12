<?php

class BidangDivisi extends DB
{
    function getBidangDivisi()
    {
        $query = "SELECT * FROM bidang_divisi";
        return $this->execute($query);
    }

    function getDetailBidangDivisi($id_bidang)
    {
        $query = "SELECT * FROM bidang_divisi WHERE id_bidang=$id_bidang";
        return $this->execute($query);
    }

    function add($jabatan, $id_divisi)
    {
        $query = "insert into bidang_divisi(jabatan, id_divisi) values ('$jabatan', '$id_divisi')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($id_bidang, $jabatan, $id_divisi){

        $query = "UPDATE bidang_divisi SET jabatan='$jabatan', id_divisi='$id_divisi' WHERE id_bidang=$id_bidang";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM bidang_divisi WHERE id_bidang = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function statusbidangDivisi($id)
    {

        $query = "update bidangDivisi set status = '$status' where id_bidang = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
