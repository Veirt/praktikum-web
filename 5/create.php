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
  <?php $active = "create" ?>
  <?php include("includes/dashboard-navbar.php") ?>
  <?php require("connection.php") ?>

  <section class="form">
    <div class="product-form-wrapper">
      <h1 style="margin: 20px 0;">Form Penambahan Produk</h1>

      <form class="product-form" action="" method="post" enctype="multipart/form-data">

        <div class="form-item">
          <label class="form-label" for="product-name">Nama Produk</label>
          <input class="form-input" type="text" required name="product-name" id="product-name">
        </div>

        <div class="form-item">
          <label class="form-label" for="product-type">Tipe Produk</label>
          <select class="form-input" name="product-type" required id="product-type">
            <option value="IEM">IEM</option>
            <option value="Headphone">Headphone</option>
            <option value="TWS">TWS</option>
            <option value="USB Dongles">USB Dongles</option>
          </select>
        </div>

        <div class="form-item">
          <label class="form-label" for="product-price">Harga</label>
          <input class="form-input" type="number" required name="product-price" id="product-price">
        </div>

        <div class="form-item">
          <label class="form-label" for="product-image">Gambar</label>
          <input class="form-input" type="file" accept="image/*" required name="product-image" id="product-image">
        </div>

        <div style="justify-content: center" class="form-item">
          <input class="btn" type="submit" name="create" value="Create">

        </div>

      </form>
    </div>
  </section>


  <script defer async="true" src="script.js"></script>
</body>

</html>
<?php

if (isset($_POST["create"])) {
  $product_name = $_POST["product-name"];
  $product_type = $_POST["product-type"];
  $product_price = $_POST["product-price"];

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

  $result = mysqli_query($connection, "INSERT INTO products (name, type, price, image_path) VALUES ('$product_name', '$product_type', '$product_price', '$target_file_name')");
  if (!$result) {
    echo "<script>alert('Gagal menambahkan produk!')</script>";
    return;
  } else {
    echo "<script>alert('Berhasil menambahkan produk!')</script>";
    echo "<script>document.location = 'dashboard.php' </script>";
  }

  @move_uploaded_file($temp_file_name, $target_file_name);
}
?>
