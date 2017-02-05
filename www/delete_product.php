<?php
	session_start();
	# include db connection
	include "config/db.php";

	# import functions
	include "includes/functions.php";

	$title = 'Delete Product';
	# import header
	include "includes/header2.php";

	$errors =[];

	$product = fetchProducts($dbcon, $_GET['id']);

	if (array_key_exists('accept', $_POST)) {
		# delete product and return to product list...
		if(deleteProduct($dbcon, $product['id'])) {
			header('location: view_products.php');
		}
		echo "Unkown error occured";
	}

	if (array_key_exists('decline', $_POST)) {
		# return to product list...
		header('location: view_products.php');
	}
?>
<div class="wrapper">
	<div id="stream">
		<br><br><br>
		<p class='lead'>Are you sure you want to delete <strong><?php echo $product['name']; ?></strong> by <?php echo $product['author']; ?>?</p>
		<br><hr>
		<form method="POST">
			<input type="submit" name="accept" value="Yes">
			<input type="submit" name="decline" value="No">
		</form>
	</div>
</div>

<?php
	# import footer
	include "includes/footer.php";
?>
