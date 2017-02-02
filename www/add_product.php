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

	# define constants
	define('MAX_FILE_SIZE', 2097152);

	# add product 
	if (array_key_exists('submit', $_POST)) {
		# variables
		$upload_test = false;
		$upload_loc = 'uploads/';
		$upload_dest = '';
		$upload_ext = ['image/jpg','image/jpeg','image/png'];

		# validate product name
		if(empty($_POST['name'])) {
			$errors['name'] = "Please enter product name";
		}

		# validate product description
		if(empty($_POST['description'])) {
			$errors['description'] = "Please enter product description";
		}

		# validate category
		if(empty($_POST['category'])) {
			$errors['category'] = "Please select a category";
		}

		# validate price
		if(empty($_POST['price'])) {
			$errors['price'] = "Please enter product price";
		}

		# validate author
		if(empty($_POST['author'])) {
			$errors['author'] = "Please enter author";
		}

		# validate image...check if image is selected
		if(empty($_FILES['image']['name'])) {
			$errors['image'] = "click 'choose file' to upload an image";
		} 
		else {

			# check image file size...
			if($_FILES['image']['size'] > MAX_FILE_SIZE) {
				$errors['image'] = 'Picture is too large! Allowed maximum is: '.MAX_FILE_SIZE;
			}

			# check extension
			if(!in_array($_FILES['image']['type'], $upload_ext)){
				$errors['image'] = 'Invalid file type';
			}
		}

		if(empty($errors)){
			# generate new file name..
			$filename = cleanupFilename($_FILES['image']['name']);

			# generate random number
			$random = substr(number_format(time() * rand(),0,'',''),0,10);

			# build destination location
			$upload_dest = $upload_loc.$random.$filename;

			# move file from temporary location to server
			$upload_test = move_uploaded_file($_FILES['image']['tmp_name'], $upload_dest);
		}

		if($upload_test) {
			# successful upload, insert to database...
			$result = addProduct($dbcon, $_POST['category'], $_POST['name'], $_POST['price'], $upload_dest, $_POST['description'],$_POST['author']);
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
			<?php display_errors('name',$errors); ?>
			<input type="text" name="name" placeholder="Product Name">
		</div>
		<div>
			<label>Product Description:</label>
			<?php display_errors('description',$errors); ?>
			<textarea placeholder="Product Description" name ="description"></textarea>
		</div>
		<div>
			<label>Product Category:</label>
			<?php display_errors('category',$errors); ?>
			<select name="category">
				<option disabled="disabled" selected="selected"> -- select category -- </option>
				<?php
					echo fetchCategories($dbcon);
				?>
			</select>
		</div>
		<div>
			<label>Author:</label>
			<?php display_errors('author',$errors); ?>
			<input type="text" name="author" placeholder="Book Author">
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
