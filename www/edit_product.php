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
		# initialize array to hold changes
		$holder = [];

		# validate product name
		if(empty($_POST['name'])) {
			$errors['name'] = "Please enter product name";
		} 
		else {
			# test for changes
			$res = strcmp($product['name'], $_POST['name']);
			if($res) {
				$holder['name'] = $_POST['name'];
			} 
		}

		# validate product description
		if(empty($_POST['description'])) {
			$errors['description'] = "Please enter product description";
		}
		else {
			# test for changes
			$res = strcmp($product['description'], $_POST['description']);
			if($res) {
				$holder['description'] = $_POST['description'];
			} 
		}

		# validate category
		if(empty($_POST['category'])) {
			$errors['category'] = "Please select a category";
		}
		else {
			# test for changes
			$res = strcmp($product['category_id'], $_POST['category']);
			if($res) {
				$holder['category_id'] = $_POST['category'];
			} 
		}

		# validate price
		if(empty($_POST['price'])) {
			$errors['price'] = "Please enter product price";
		}
		else {
			# test for changes
			$res = strcmp($product['price'], $_POST['price']);
			if($res) {
				$holder['price'] = $_POST['price'];
			} 
		}

		# validate author
		if(empty($_POST['author'])) {
			$errors['author'] = "Please enter author";
		}
		else {
			# test for changes
			$res = strcmp($product['author'], $_POST['author']);
			if($res) {
				$holder['author'] = $_POST['author'];
			} 
		}

		# update if no errors
		if(empty($errors)){
			$res = editProducts();
		}
		print_r($holder);

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
				<option value="<?= $product['category_id'];?>" selected="selected"><?= fetchCategoryName($dbcon,$product['category_id']);?></option>
				<?php
					$categoriesList = fetchCategories($dbcon);

					foreach ($categoriesList as $row) {
						# code...
						if($row['id'] !== $product['category_id']){
							echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
						} 
					}
				?>
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
