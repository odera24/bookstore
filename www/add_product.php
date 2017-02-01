<?php
	session_start();
	# include db connection
	include "config/db.php";

	# import functions
	include "includes/functions.php";

	# import header
	include "includes/header2.php";

	# errors
	$errors =[];

	if (array_key_exists('submit', $_POST)) {


		# validate category name
		if(empty($_POST['category'])) {
			$errors['category'] = "Please enter a category";
		} 

		# validate category description
		if(empty($_POST['description'])) {
			$errors['description'] = "Please enter category description";
		}

		if(empty($errors)){
			addCategory($dbcon,$_POST['category'],$_POST['description']);
		}

	}
?>

<div class="wrapper">
	<div id="stream">
		<h1 id="register-label">Add product</h1>
		<hr>

		<form id="register" method="POST" enctype="multipart/form-data">
		<div>
			<label>Product name:</label>
			<?php display_errors('product',$errors); ?>
			<input type="text" name="product" placeholder="Product Name">
		</div>
		<div>
			<label>Product Description:</label>
			<?php display_errors('description',$errors); ?>
			<textarea placeholder="Product Description" name ="description"></textarea>
		</div>
		<div>
			<label>Product Category:</label>
			<?php display_errors('category',$errors); ?>
			<select name="category"></select>
		</div>
		<div>
			<label>Price:</label>
			<?php display_errors('price',$errors); ?>
			<input type="text" name="price" placeholder="Product Price">
		</div>
		<div>
			<label>Product image:</label>
			<?php display_errors('image',$errors); ?>
			<input type="file" name="image" placeholder="Product image">
		</div>

		<input type="submit" name="submit" value="Add">

		</form>
	</div>
</div>

<?php
	# import footer
	include "includes/footer.php";
?>
