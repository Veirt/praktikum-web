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
	<?php $active = "dashboard"; ?>
	<?php include("includes/dashboard-navbar.php") ?>

	<h1 style="margin: 20px 40px" class="section-title">Dashboard</h1>

	<main>
		<section class="product-table-wrapper">
			<table class="product-table">
				<tr>
					<td class="product-id">ID</td>
					<td class="product-image">Gambar</td>
					<td>Nama</td>
					<td>Tipe</td>
					<td style="text-align: right">Harga</td>
					<td style="width: 250px;">Aksi</td>
				</tr>
				<?php
				$result = mysqli_query($connection, "SELECT * FROM products");
				while ($row = mysqli_fetch_assoc($result)) { ?>
					<tr>
						<td><?= $row['id'] ?></td>
						<td>
							<img class="product-image" src="<?= $row['image_path'] ?>" alt="">
						</td>
						<td><?= $row['name'] ?></td>
						<td><?= $row['type'] ?></td>
						<td style="text-align: right;"><?= rupiah($row['price']) ?></td>
						<td>
							<a href="update.php?id=<?= $row['id'] ?>">
								<button class="btn green">Update</button>
							</a>

							<form onsubmit="return submitForm();" style="display: block;" action="" method="post">
								<input name="id" hidden value="<?= $row['id'] ?>">
								<button name="delete" type="submit" style="display: inline;" class="btn red">Delete</button>
							</form>
						</td>
					</tr>
				<?php } ?>
			</table>
		</section>
	</main>

	<?php date_default_timezone_set("Asia/Makassar") ?>
	<h3 class="dashboard-time">Current Date: <?= date("D, d M Y. e") ?></h3>


	<script defer async="true" src="script.js"></script>
	<script>
		function submitForm() {
			const confirmation = confirm("Apakah anda yakin ingin menghapus produk ini?")
			return confirmation;
		}
	</script>
</body>

</html>

<?php
if (isset($_POST["delete"])) {
	$id = $_POST["id"];

	$select_stmt = mysqli_prepare($connection, "SELECT image_path FROM products WHERE id = ?");
	mysqli_stmt_bind_param($select_stmt, "i", $id);
	mysqli_stmt_execute($select_stmt);
	$result = mysqli_stmt_get_result($select_stmt);
	$old_image = mysqli_fetch_assoc($result)['image_path'];
	mysqli_stmt_close($select_stmt);

	$delete_stmt = mysqli_prepare($connection, "DELETE FROM products WHERE id = ?");
	mysqli_stmt_bind_param($delete_stmt, "i", $id);
	$delete_result = mysqli_stmt_execute($delete_stmt);

	if ($delete_result) {
		if (file_exists($old_image)) {
			unlink($old_image);
		}
		echo "<script>alert('Berhasil menghapus produk.')</script>";
	} else {
		echo "<script>alert('Gagal menghapus produk.')</script>";
	}

	mysqli_stmt_close($delete_stmt);
	echo "<script>document.location = 'dashboard.php'</script>";
}
?>
