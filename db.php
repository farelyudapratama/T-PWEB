<?php
// Informasi koneksi ke database
$server = "localhost";      
$username = "root";         
$password = "";             
$database = "notes-1";      

// Membuat koneksi ke database menggunakan MySQLi
$con = mysqli_connect($server, $username, $password, $database);

// Memeriksa apakah koneksi berhasil atau gagal
if (!$con) {
    // Jika koneksi gagal, menampilkan pesan kesalahan dan menghentikan eksekusi program
    die("Connection failed: " . mysqli_connect_error());
}
?>
