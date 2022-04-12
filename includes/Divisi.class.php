<?php

class Divisi extends DB
{
    function getDivisi()
    {
        $query = "SELECT * FROM divisi";
        return $this->execute($query);
    }
    function getDetailDivisi($id_divisi)
    {
        $query = "SELECT * FROM divisi WHERE id_divisi=$id_divisi";
        return $this->execute($query);
    }

    function add($data)
    {
        $query = "insert into divisi values ('', '$data')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM divisi WHERE id_divisi = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($id, $namaDivisi)
    {

        $query = "UPDATE divisi SET nama_divisi='$namaDivisi' WHERE id_divisi=$id";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function statusDivisi($id)
    {

        $status = "Senior";
        $query = "update divisi set status = '$status' where id_divisi = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
