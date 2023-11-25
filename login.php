<?php
session_start();

include "./db.php"; //koneksi database di db.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data user dari database
    $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
    $res = mysqli_query($con, $sql);

    if ($res && $row = mysqli_fetch_assoc($res)) {
        // verifikasi password dengan hash password yang tersimpan
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php");
            exit();
        } else {
            $validation = "Invalid password";

        }
    } else {
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
    <?php if (isset($validation) && $validation): ?>
        <script>
            showNotification('<?php echo $validation; ?>');
            function showNotification(message) {
                console.log("Showing error message:", message);

                // Buat elemen div untuk pop-up
                var popup = document.createElement("div");
                popup.className = "error-popup";

                // Buat elemen div untuk progress bar
                var progressBar = document.createElement("div");
                progressBar.className = "progress-bar";

                // buat progress bar ke dalam pop-up
                popup.appendChild(progressBar);

                // Buat elemen span untuk pesan
                var messageSpan = document.createElement("span");
                messageSpan.textContent = message;

                // Tambahkan pesan ke dalam pop-up
                popup.appendChild(messageSpan);

                // Tambahkan pop-up ke dalam body
                document.body.appendChild(popup);

                // Animasi muncul dari atas samping kanan
                setTimeout(function () {
                    popup.style.top = "20px";
                    popup.style.right = "20px";
                }, 10);

                // Atur timer untuk menghilangkan pop-up setelah beberapa detik
                var timer = setTimeout(function () {
                    popup.style.top = "-100px"; // Menghilangkan pop-up dari tampilan geser ke atas 100px
                }, 5000); // 5000 milidetik (5 detik) - sesuaikan sesuai kebutuhan

                // Atur timer untuk mengupdate progress bar setiap 50 milidetik (sesuaikan sesuai kebutuhan)
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
                    <a class="toggle-icon" onclick="togglePasswordVisibility()">See password</a>
                </div>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
            </form>
        </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");

            // Ubah tipe input antara password dan text
            passwordInput.type = (passwordInput.type === "password") ? "text" : "password";

            // Ganti teks pada ikon berdasarkan tipe input
            var toggleIcon = document.querySelector(".toggle-icon");
            toggleIcon.textContent = (passwordInput.type === "password") ? "See password" : "Hide password";
        }
    </script>
</body>

</html>