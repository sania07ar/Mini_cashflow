<?php
include "koneksi.php";

if(isset($_POST['simpan'])){

    $nama=$_POST['nama'];
    $jenis=$_POST['jenis'];
    $nominal=$_POST['nominal'];
    $tanggal=$_POST['tanggal'];

    if($nama=="" || $jenis=="" || $nominal=="" || $tanggal==""){
        echo "<script>alert('Semua field wajib diisi');history.back();</script>";
        exit;
    }

    if($nominal<=0){
        echo "<script>alert('Nominal harus lebih dari 0');history.back();</script>";
        exit;
    }

   $sql = "INSERT INTO transaksi
(nama_transaksi,jenis,nominal,tanggal)
VALUES
('$nama','$jenis','$nominal','$tanggal')";

if(mysqli_query($conn, $sql)){
    header("Location:index.php");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
}

?>