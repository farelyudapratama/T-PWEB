<?php
include "./db.php"; // Mengimpor file db.php yang berisi koneksi ke database
$id=$_GET["id"]; // Mengambil nilai id dari parameter URL
$deleteQuery="DELETE FROM `notes` WHERE `sno`='$id'"; // Membuat query untuk menghapus data berdasarkan id
$res = mysqli_query($con, $deleteQuery); // Menjalankan query delete menggunakan koneksi database
header("location:./index.php"); // Mengarahkan pengguna kembali ke halaman utama setelah penghapusan berhasil
?>