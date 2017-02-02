<?php
	session_start();
	# include db connection
	include "config/db.php";

	# import functions
	include "includes/functions.php";

	$title = 'Add Category';
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
		<h1 id="register-label">Add category</h1>
		<hr>

		<form id="register" method="POST">
		<div>
			<label>Category name:</label>
			<?php display_errors('category',$errors); ?>
			<input type="text" name="category" placeholder="Category Name">
		</div>
		<div>
			<label>Category Description:</label>
			<?php display_errors('description',$errors); ?>
			<textarea placeholder="Category Description" name ="description"></textarea>
		</div>

		<input type="submit" name="submit" value="Add">

		</form>
	</div>
</div>

<?php
	# import footer
	include "includes/footer.php";
?>
