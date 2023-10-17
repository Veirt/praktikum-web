<?php require("connection.php") ?>
<?php
if (isset($_POST["update"])) {
    $id = $_POST['id'];
    $product_name = $_POST["product-name"];
    $product_type = $_POST["product-type"];
    $product_price = $_POST["product-price"];

    if (file_exists($_FILES['product-image']['tmp_name'])) {
        $original_file_name = basename($_FILES["product-image"]["name"]);
        $temp_file_name = $_FILES["product-image"]["tmp_name"];
        $file_type = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));


        $valid_image = true;

        // validation
        $image_size = getimagesize($_FILES["product-image"]["tmp_name"]);

        if ($image_size === false) {
            echo "<script>alert('Bukan image!')</script>";
            $valid_image = false;
        }

        if ($_FILES["product-image"]["size"] > 5000000) {
            echo "<script>alert('File terlalu besar!')</script>";
            $valid_image = false;
        }

        if (
            $file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
            && $file_type != "gif"
        ) {
            echo "<script>alert('File format tidak disupport.')</script>";
            $valid_image = false;
        }

        if (!$valid_image) {
            return;
        }

        // format: assets/uploads/name-unixtimestamp.format
        $target_file_dir =  "assets/uploads/";
        $target_file_name = $target_file_dir . $product_name . "-" . time() . "." . $file_type;

        $result = mysqli_query($connection, "UPDATE products SET name='$product_name', type='$product_type', price='$product_price', image_path='$target_file_name' WHERE id='$id'");
    } else {
        $result = mysqli_query($connection, "UPDATE products SET name='$product_name', type='$product_type', price='$product_price'  WHERE id='$id'");
    }


    if (!$result) {
        echo "<script>alert('Gagal memperbarui produk!')</script>";
        return;
    } else {
        echo "<script>alert('Berhasil memperbarui produk!')</script>";
        echo "<script>document.location = 'dashboard.php' </script>";
    }

    @move_uploaded_file($temp_file_name, $target_file_name);
}
?>

<?php

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $result = mysqli_query($connection, "SELECT * FROM products WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<script>alert('Produk tidak ditemukan!')</script>";
        echo "<script>document.location = 'dashboard.php'</script>";
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
    <?php $active = "product" ?>
    <?php include("includes/dashboard-navbar.php") ?>

    <section class="form">
        <div class="product-form-wrapper">
            <h1 style="margin: 20px 0;">Form Update Produk</h1>

            <form class="product-form" action="" method="post" enctype="multipart/form-data">
                <input name="id" hidden value="<?= $_GET['id'] ?>" type="text">
                <div class="form-item">
                    <label class="form-label" for="product-name">Nama Produk</label>
                    <input class="form-input" type="text" value="<?= $row['name'] ?>" required name="product-name" id="product-name">
                </div>

                <div class="form-item">
                    <label class="form-label" for="product-type">Tipe Produk</label>
                    <select class="form-input" name="product-type" required id="product-type">
                        <option <?= $row['type'] == 'IEM' ? 'selected' : '' ?> value="IEM">IEM</option>
                        <option <?= $row['type'] == 'Headphone' ? 'selected' : '' ?> value="Headphone">Headphone</option>
                        <option <?= $row['type'] == 'TWS' ? 'selected' : '' ?> value="TWS">TWS</option>
                        <option <?= $row['type'] == 'USB Dongles' ? 'selected' : '' ?> value="USB Dongles">USB Dongles</option>
                    </select>
                </div>

                <div class="form-item">
                    <label class="form-label" for="product-price">Harga</label>
                    <input value="<?= $row['price'] ?>" class="form-input" type="number" required name="product-price" id="product-price">
                </div>


                <div class="form-item">
                    <label class="form-label" for="product-image">Gambar</label>
                    <input class="form-input" type="file" accept="image/*" name="product-image" id="product-image">
                </div>
                <div style="height: 150px; justify-content: start;" class="form-item">
                    <label style="visibility: hidden;" class="form-label" for="product-image">Gambar Lama</label>
                    <img class="product-image-preview" style="" src="<?= $row['image_path'] ?>" alt="">

                </div>

                <div style="justify-content: center" class="form-item">
                    <input class="btn" type="submit" name="update" value="Update">

                </div>

            </form>
        </div>
    </section>


    <script defer async="true" src="script.js"></script>
</body>


</html>
