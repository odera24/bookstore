<?php
	include 'includes/functions.php';
	define('MAX_FILE_SIZE', 1048576);


	#errors array
	$errors = [];

	if (array_key_exists('upload', $_POST)) {

		# allowed extensions
		$ext = ['image/jpg','image/jpeg','image/png'];

		# upload file location
		$upload_loc = 'uploads/';
		
		# check if file is selected..
		if(empty($_FILES['pic']['name'])) {
			$errors['pic'] = 'Please select a file';
		}

		# check file size...
		if($_FILES['pic']['size'] > MAX_FILE_SIZE) {
			$errors['pic'] = 'File size exceeds maximum. Allowed maximum: '.MAX_FILE_SIZE;
		}

		# check extension
		if(!in_array($_FILES['pic']['type'], $ext)){
			$errors['pic'] = 'Invalid file type';
		}

		if(empty($errors)) {
			# generate new file name..
			$filename = cleanupFilename($_FILES['pic']['name']);

			$random = substr(number_format(time() * rand(),0,'',''),0,10);

			$dest = $upload_loc.$random.$filename;

			$bool = move_uploaded_file($_FILES['pic']['tmp_name'], $dest);

			if($bool){ echo true; }
		}

	}
?>
<form method="POST" enctype="multipart/form-data">
	<?php echo display_errors('pic',$errors); ?>
	<input type="file" name="pic">
	<br>
	<input type="submit" name="upload" value="upload">
</form>
