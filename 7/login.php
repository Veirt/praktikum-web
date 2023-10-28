<?php
require("session-validation.php");
validate_login();
?>
<?php require("connection.php") ?>

<?php

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");


    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('Username/password Anda salah!')</script>";
        header("Refresh:0");
        return;
    }

    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user["password"])) {
        $_SESSION["user"] = $user;
        echo "<script>alert('Login berhasil!')</script>";
        echo "<script>window.location = 'index.php' </script>";
    } else {
        echo "<script>alert('Username/password Anda salah!')</script>";
        header("Refresh:0");
        return;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Website Toko Perangkat Audio</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <?php $active = "login" ?>
    <?php include("includes/navbar.php") ?>

    <main class="login-wrapper">
        <div class="form-wrapper" style="height: 80%">
            <h1 style="margin: 20px 0;">Login</h1>

            <form class="product-form" action="" method="post" enctype="multipart/form-data">

                <div class="form-item">
                    <label class="form-label" for="product-name">Username</label>
                    <input class="form-input" type="text" value="" required name="username" id="username">
                </div>

                <div class="form-item">
                    <label class="form-label" for="product-name">Password</label>
                    <input class="form-input" type="password" value="" required name="password" id="password">
                </div>



                <div style="justify-content: center" class="form-item">
                    <input class="btn" type="submit" name="login" value="Login">

                </div>

            </form>
        </div>


    </main>

    <script defer async="true" src="script.js"></script>
</body>

</html>
