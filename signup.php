<?php
session_start(); //memulai sesi
include "./db.php"; //koneksi database di db.php
$res = false; // variabel untuk menyimpan nilai true atau false (Diset false diawal)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {//memeriksa jika requestnya adalah POST maka ini dijalankan
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) { // ngecek jika formulir belum diisi salah satu
        $validation = "Please enter both username and password.";
    } else { // jika udeh diisi
        // Mengecek adakah nama didatabase
        $checkUsernameQuery = "SELECT * FROM `users` WHERE `username` = '$username'";
        $checkUsernameResult = mysqli_query($con, $checkUsernameQuery);

        if (mysqli_num_rows($checkUsernameResult) > 0) { // Jika ada maka tidak boleh sama
            $validation = "Username already exists. Please choose a different username.";
        } else { // jika tidak ada yang sama maka
            // password akan dihash
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Menambahkan user beserta password hasil hash di database
            $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$hashedPassword')";
            $res = mysqli_query($con, $sql);

            if ($res) {
                $validation = "User registered successfully.";
            } else {
                $validation = "Error registering user.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" type="image/png" href="image/favicon.png" />
    <link rel="stylesheet" href="loginAndSingup.css">
</head>

<body>
<?php if (isset($validation) && $validation): ?> 
    <script> // Script untuk membuat notifikasi
        showNotification('<?php echo $validation; ?>', <?php echo $res ? 'true' : 'false'; ?>);
        function showNotification(message, isSuccess) {
            console.log("Showing notification:", message);

            // Buat elemen div untuk pop-up
            var popup = document.createElement("div");
            popup.className = isSuccess ? "success-popup" : "error-popup";

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

            
            var timer = setTimeout(function () {
                popup.style.top = "-100px"; 
            }, 5000); 

            var updateInterval = 50;
            var progressBarWidth = 100;
            var progressBarUpdate = setInterval(function () {
                progressBar.style.width = progressBarWidth + "%";
                progressBarWidth -= (updateInterval / 5000) * 100;
            }, updateInterval);

            setTimeout(function () { // Ketika timer habis akan di lempar ke halaman login
                clearInterval(progressBarUpdate);
                if (isSuccess) {
                    window.location.href = 'login.php';
                }
            }, 5000);
        }
    </script>
<?php endif; ?>


    <div class="container">
        <div class="login-section">
            <form method="POST" class="login-form">
                <p class="subtitle">SIGN UP</p>
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
                <button type="submit">Sign Up</button>
                <p>Already have an account ? <a href="login.php">Login here</a></p>
            </form>
        </div>
        <div class="welcome-section">
            <img src="image/banner.jpg" alt="Welcome Image">
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            passwordInput.type = (passwordInput.type === "password") ? "text" : "password";
            var toggleIcon = document.querySelector(".toggle-icon");
            toggleIcon.textContent = (passwordInput.type === "password") ? "See password" : "Hide password";
        }
    </script>
</body>

</html>
