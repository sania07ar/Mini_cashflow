<?php
include "koneksi.php";

$bulan=@$_GET['bulan'];
$tahun=@$_GET['tahun'];

$where="";

if($bulan!="" && $tahun!=""){
    $where="WHERE MONTH(tanggal)='$bulan'
    AND YEAR(tanggal)='$tahun'";
}

$masuk=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(nominal) total
FROM transaksi
WHERE jenis='masuk'"));

$keluar=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(nominal) total
FROM transaksi
WHERE jenis='keluar'"));

$totalMasuk=$masuk['total'];
$totalKeluar=$keluar['total'];
$saldo=$totalMasuk-$totalKeluar;

$data=mysqli_query($conn,
"SELECT * FROM transaksi
$where
ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Mini Cashflow</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container mt-4">

<h2>Mini Cashflow</h2>

<form action="tambah.php" method="POST">

<div class="row">

<div class="col">
<input
type="text"
name="nama"
class="form-control"
placeholder="Nama Transaksi">
</div>

<div class="col">

<select
name="jenis"
class="form-control">

<option value="">Jenis</option>

<option value="masuk">
Masuk
</option>

<option value="keluar">
Keluar
</option>

</select>

</div>

<div class="col">

<input
type="number"
name="nominal"
class="form-control"
placeholder="Nominal">

</div>

<div class="col">

<input
type="date"
name="tanggal"
class="form-control">

</div>

<div class="col">

<button
class="btn btn-primary"
name="simpan">

Simpan

</button>

</div>

</div>

</form>

<hr>

<div class="row">

<div class="col">

<div class="card bg-success text-white">

<div class="card-body">

<h5>Total Masuk</h5>

Rp <?=number_format($totalMasuk,0,",",".")?>

</div>

</div>

</div>

<div class="col">

<div class="card bg-danger text-white">

<div class="card-body">

<h5>Total Keluar</h5>

Rp <?=number_format($totalKeluar,0,",",".")?>

</div>

</div>

</div>

<div class="col">

<div class="card bg-primary text-white">

<div class="card-body">

<h5>Saldo</h5>

Rp <?=number_format($saldo,0,",",".")?>

</div>

</div>

</div>

</div>

<hr>

<form method="GET">

<div class="row">

<div class="col">

<select
name="bulan"
class="form-control">

<option value="">Bulan</option>

<?php
for($i=1;$i<=12;$i++){
echo "<option value='$i'>$i</option>";
}
?>

</select>

</div>

<div class="col">

<input
type="number"
name="tahun"
placeholder="Tahun"
class="form-control">

</div>

<div class="col">

<button class="btn btn-info">

Filter

</button>

</div>

</div>

</form>

<br>

<table class="table table-bordered">

<tr>

<th>No</th>

<th>Nama</th>

<th>Jenis</th>

<th>Nominal</th>

<th>Tanggal</th>

<th>Aksi</th>

</tr>

<?php

$no=1;

while($d=mysqli_fetch_array($data)){

$warna=($d['jenis']=="masuk")
?"table-success":"table-danger";

?>

<tr class="<?=$warna?>">

<td><?=$no++?></td>

<td><?=$d['nama_transaksi']?></td>

<td><?=$d['jenis']?></td>

<td>
Rp <?=number_format($d['nominal'],0,",",".")?>
</td>

<td><?=$d['tanggal']?></td>

<td>

<a
href="hapus.php?id=<?=$d['id']?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus data?')">

Hapus

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>