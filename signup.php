<?php
session_start();

include "./db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$hashedPassword')";
    $res = mysqli_query($con, $sql);

    if ($res) {
        echo "User registered successfully. <a href='login.php'>Login</a>";
    } else {
        echo "Error registering user.";
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
                    <button type="submit" class="btn submit">Sign Up</button>
                </form>
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</body>

</html>
