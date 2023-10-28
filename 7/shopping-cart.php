<?php
require("session-validation.php");
validate_user();
?>

<?php

if (isset($_POST["cancel"])) {
	array_splice($_SESSION["shopping-cart"], $_POST["idx"], 1);
	header("Refresh:0");
	return;
}
?>

<?php require("connection.php") ?>
<?php require("utils.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
	<link rel="stylesheet" href="style.css">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>


<body>
	<?php $active = "shopping-cart"; ?>
	<?php include("includes/navbar.php") ?>

	<h1 style="margin: 20px 40px" class="section-title">Shopping Cart</h1>

	<main>
		<section class="product-table-wrapper">
			<table class="product-table">
				<tr>
					<td class="product-image">Gambar</td>
					<td>Nama</td>
					<td>Tipe</td>
					<td style="text-align: right">Harga</td>
					<td style="width: 250px;">Aksi</td>
				</tr>
				<?php


				if (isset($_SESSION["shopping-cart"])) {
					foreach ($_SESSION["shopping-cart"] as $idx => $item) {
						$result = mysqli_query($connection, "SELECT * FROM products WHERE id = $item");
						while ($row = mysqli_fetch_assoc($result)) { ?>
							<tr>
								<td>
									<img class="product-image" src="<?= $row['image_path'] ?>" alt="">
								</td>
								<td><?= $row['name'] ?></td>
								<td><?= $row['type'] ?></td>
								<td style="text-align: right;"><?= rupiah($row['price']) ?></td>
								<td>

									<form style="display: block;" action="" method="post">
										<input name="id" hidden value="<?= $row['id'] ?>">
										<input name="idx" hidden value="<?= $idx ?>">
										<button name="cancel" type="submit" style="display: inline;" class="btn red">Batal</button>
									</form>
								</td>
							</tr>
						<?php } ?>
					<?php } ?>

				<?php } ?>

			</table>
		</section>
	</main>

	<script defer async="true" src="script.js"></script>
</body>

</html>
