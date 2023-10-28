<?php
require("session-validation.php");
validate_login();
?>
<?php require("connection.php") ?>

<?php
if (isset($_POST["register"])) {
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];
    $password_confirmation = $_POST["confirm-password"];

    if ($password != $password_confirmation) {
        echo "<script>alert('Password Konfirmasi tidak cocok!')</script>";
        header("Refresh:0");
        return;
    }

    $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username telah dipakai!')</script>";
        header("Refresh:0");
        return;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $result = mysqli_query($connection, "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed', 'User')");

    if ($result) {
        echo "<script>alert('Registrasi berhasil!')</script>";
        echo "<script>window.location = 'login.php'</script>";
    } else {
        echo "<script>alert('Registrasi gagal.')</script>";
        header("Refresh:0");
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
    <?php $active = "register" ?>
    <?php include("includes/navbar.php") ?>

    <main class="login-wrapper">
        <div class="form-wrapper" style="height: 80%">
            <h1 style="margin: 20px 0;">Register</h1>

            <form class="product-form" action="" method="post" enctype="multipart/form-data">

                <div class="form-item">
                    <label class="form-label" for="product-name">Username</label>
                    <input placeholder="Username" class="form-input" type="text" value="" required name="username" id="username">
                </div>

                <div class="form-item">
                    <label class="form-label" for="product-name">Password</label>
                    <input placeholder="Password" class="form-input" type="password" value="" required name="password" id="password">
                </div>

                <div class="form-item">
                    <label style="visibility: hidden" class="form-label" for="product-name">Confirm Password</label>
                    <input placeholder="Confirm Password" class="form-input" type="password" value="" required name="confirm-password" id="confirm-password">
                </div>

                <div style="justify-content: center" class="form-item">
                    <input class="btn" type="submit" name="register" value="Register">

                </div>

            </form>
        </div>


    </main>

    <script defer async="true" src="script.js"></script>
</body>

</html>
