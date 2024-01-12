<?php
session_start(); //memulai sesi

include "./db.php"; //koneksi database di db.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //memeriksa jika requestnya adalah POST maka ini dijalankan
    $username = $_POST['username']; // menyimpan username dari form hmtl ke variabel username
    $password = $_POST['password']; //menyimpan password dari form hmtl ke variabel password

    // Ambil data user dari database
    $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
    $res = mysqli_query($con, $sql);

    if ($res && $row = mysqli_fetch_assoc($res)) { //  memeriksa apakah ada user ada di database jika iya maka
        // verifikasi password dengan hash password yang tersimpan
        if (password_verify($password, $row['password'])) { //jika passwordnya sama maka user_id akan disimpan di variabel SESSION serta melempar halaman ke index.php
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php");
            exit();
        } else { // jika password salah maka akan muncul invalid password
            $validation = "Invalid password";
        }
    } else { // jika user tidak ditemukan maka akan muncul user not found
        $validation = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="image/favicon.png" />
    <link rel="stylesheet" href="loginAndSingup.css">
</head>

<body>
    <?php if (isset($validation) && $validation): ?> <!--Jika ada variabel validation maka script dibawahnya ini akan dijalankan-->
        <script>
            showNotification('<?php echo $validation; ?>'); // memanggil fungsi showNotification dan mengirimkan pesan notifikasi ke dalamnya. Pesan notifikasi ini berasal dari nilai variabel PHP $validation.

            function showNotification(message) { //Ini fungsi untuk membuat notifikasi
                console.log("Showing error message:", message);

                // Buat elemen div untuk pop-up
                var popup = document.createElement("div");
                popup.className = "error-popup";

                // Buat elemen div untuk progress bar
                var progressBar = document.createElement("div");
                progressBar.className = "progress-bar";

                // Menambahkan progress bar ke dalam pop-up
                popup.appendChild(progressBar);

                // Buat elemen span untuk pesan
                var messageSpan = document.createElement("span");
                messageSpan.textContent = message;

                // Menambahkan pesan ke dalam pop-up
                popup.appendChild(messageSpan);

                // Menambahkan pop-up ke dalam body
                document.body.appendChild(popup);

                // Animasi munculin notif
                setTimeout(function () {
                    popup.style.top = "20px";
                    popup.style.right = "20px";
                }, 10);

                // Mengilangkan notif dengan timer 5 detik
                var timer = setTimeout(function () {
                    popup.style.top = "-100px"; // Menghilangkan pop-up dari tampilan geser ke atas 100px
                }, 5000);

                // Intinya ini untuk mengupdate progress barnya agar seolah seperti dari penuh ke habis sebelum notifnya ilang
                var updateInterval = 50;
                var progressBarWidth = 100;
                var progressBarUpdate = setInterval(function () {
                    progressBar.style.width = progressBarWidth + "%";
                    progressBarWidth -= (updateInterval / 5000) * 100;
                }, updateInterval);

                // Hentikan pembaruan progress bar ketika timer habis
                setTimeout(function () {
                    clearInterval(progressBarUpdate);
                }, 5000);
            }
        </script>
    <?php endif; ?>
    <div class="container">
        <div class="welcome-section">
            <img src="image/banner.jpg" alt="Welcome Image">
        </div>
        <div class="login-section">
            <form method="POST" class="login-form">
                <p class="subtitle">LOGIN</p>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" class="loginValue" name="username"
                        placeholder="Enter your username...">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="loginValue" name="password"
                        placeholder="Enter your password...">
                    <a class="toggle" onclick="togglePasswordVisibility()">See password</a>
                </div>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
            </form>
        </div>
    </div>
    <script>
        // Script ini untuk tombol menampilkan dan menyembunyikan password
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");

            // mengubah tipe input dari password menjadi text agar terlihat dan sebaliknya
            passwordInput.type = (passwordInput.type === "password") ? "text" : "password";

            // Ganti teks pada ikon berdasarkan tipe input
            var toggleIcon = document.querySelector(".toggle");
            toggleIcon.textContent = (passwordInput.type === "password") ? "See password" : "Hide password";
        }
    </script>
</body>

</html>