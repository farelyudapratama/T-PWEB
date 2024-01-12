<?php
session_start();
include "./db.php"; // Import file koneksi database

// Periksa apakah user sudah login
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $deleteQuery = "DELETE FROM `users` WHERE `id`=?";

    // prepared statements untuk mencegah SQL injection
    $stmt = mysqli_prepare($con, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $user_id); 
    
    // Eksekusi query delete
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        // Hapus sesi
        $_SESSION = array();
        session_destroy();

        // Redirect ke halaman login
        header("Location: login.php");
        exit();
    } else {
        // Tindakan jika query delete gagal
        echo "Gagal menghapus user.";
    }

    mysqli_stmt_close($stmt);
}
?>
