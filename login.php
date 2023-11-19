<?php
session_start();

include "./db.php";

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
            echo "Invalid username or password";
        }
    } else {
        echo "Invalid username or password";
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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <form class="form" method="POST">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username...">
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password...">
                    </div>
                    <button type="submit" class="btn submit">Login</button>
                </form>
                <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
            </div>
        </div>
    </div>
</body>

</html>
