<?php
	session_start();
	# include db connection
	include "config/db.php";

	# import functions
	include "includes/functions.php";

	$title = 'Edit Products';
	# import header
	include "includes/header2.php";

	$errors = [];

	if(!isset($_GET['id'])){
		header('Location: view_products.php');
	}

	$product = fetchProducts($dbcon, $_GET['id']);

	if(array_key_exists('submit', $_POST)) {

		# check for name change 

	}

?>

<div class="wrapper">
	<div id="stream">
		<h1 id="register-label">Edit product</h1>
		<hr>

		<form id="register" method="POST" enctype="multipart/form-data">
		<div>
			<label>Product name:</label>
			<?php display_errors('name',$errors); ?>
			<input type="text" name="name" placeholder="Product Name" value="<?= $product['name'];?>">
		</div>
		<div>
			<label>Product Description:</label>
			<?php display_errors('description',$errors); ?>
			<textarea placeholder="Product Description" name ="description"><?= $product['description'];?></textarea>
		</div>
		<div>
			<label>Product Category:</label>
			<?php display_errors('category',$errors); ?>
			<select name="category">
				<option value="<?= $product['category_id'];?>" selected="selected" disabled="disabled"><?= fetchCategoryName($dbcon,$product['category_id']);?></option>
				<optgroup label="---------------------">
					<?php
						echo fetchCategories($dbcon);
					?>
				</optgroup>
				
			</select>
		</div>
		<div>
			<label>Author:</label>
			<?php display_errors('author',$errors); ?>
			<input type="text" name="author" placeholder="Book Author" value="<?= $product['author'];?>">
		</div>
		<div>
			<label>Price:</label>
			<?php display_errors('price',$errors); ?>
			<input type="text" name="price" placeholder="Product Price" value="<?= $product['price'];?>">
		</div>
		<div>
			<label>Product image:</label>
			<?php display_errors('image',$errors); ?>
			<input type="file" name="image" placeholder="Product image">
		</div>

		<input type="submit" name="submit" value="Update">

		</form>
	</div>
</div>

<?php
	# import footer
	include "includes/footer.php";
?>
