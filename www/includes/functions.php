<?php

	# display errors inline
	function display_errors($key, $arr) {

		if(key_exists($key,$arr)){
			echo '<span class="err">'.$arr[$key].'</span>';
		}
	}

	# register admin into the admin table 
	# $f = fname, $l = lname, $e = email, $p = password
	function registerAdmin($dbcon,$f,$l,$e,$p){
		# prepare statement...
		$statement = $dbcon->prepare("INSERT INTO admin(firstname,lastname,email,hash) VALUES (:fn, :ln, :em, :hs)");

		# hash password
		$hash = password_hash($p, PASSWORD_BCRYPT);
		
		# bind params...
		$data = [
			':fn' => $f,
			':ln' => $l,
			':em' => $e,
			':hs' => $hash
		];

		$statement->execute($data);
	}

	function doesEmailExist($dbcon,$e) {
		$result = false;

		$statement = $dbcon->prepare("SELECT email from admin WHERE email=:e");

		# bind params
		# $statement->execute(":e", $e);
		$statement->execute([':e' => $e]);

		# get number of rows returned
		$count = $statement->rowCount();

		if($count > 0) {
			$result = true;
		}

		return $result;
	}


	function authAdminPassword($con,$email,$pass) {
		#set flag
		$flag = false;
		
		# check for email in database
		$statement = $con->prepare("SELECT id, hash from admin WHERE email=:e");

		$statement->execute([':e'=>$email]);

		$count = $statement->rowCount();
		$row = $statement->fetch(PDO::FETCH_ASSOC);

		#fetch password 
		$hash = $row['hash'];

		if($count == 1 && password_verify($pass,$hash)) {
			$flag = true;
		}

		return [$flag,$row];
	}

	function addCategory($con,$c,$d) {
		# prepare statement...
		$statement = $con->prepare("INSERT INTO category(name,description) VALUES (:n, :d)");

		$data = [
			':n' => $c,
			':d' => $d
		];

		$statement->execute($data);
	}

	function fetchCategories($con){
		# declare string to build html
		$optionList = '';

		#prepare statement...
		$stmt = $con->prepare('SELECT * FROM category');

		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	function fetchCategoryName($con, $id) {
		# prepare statement
		$stmt = $con->prepare("SELECT name FROM category WHERE id=:e");

		$stmt->execute([':e' => $id]);

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return $result['name'];
	}

	function addProduct($con, $array) {

		# break array apart into variables
		extract($array);

		# prepare statement
		$stmt = $con->prepare("INSERT INTO product(category_id, name, price, image_location, description, author) VALUES (:c, :n, :p, :i, :d, :a)");

		$data = [
				':c' => $category, 
				':n' => $name, 
				':p' => $price, 
				':i' => $image_location, 
				':d' => $description, 
				':a' => $author
		];

		$res = $stmt->execute($data);

		return $stmt->rowCount();
	}

	function fetchProducts($con, $id = false){

		if($id) {
			# prepare statement
			$stmt = $con->prepare("SELECT * FROM product WHERE id=:e");
			$stmt->execute([':e' => $id]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		} 
		
		# prepare statement
		$stmt = $con->prepare("SELECT * FROM product");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_BOTH);
		return $result;
	}

	function updateProduct($con, $array, $id) {

		$res = false;

		$queryStr = "UPDATE product SET";

		# loop through array to build update query
		foreach ($array as $key => $value) {
			# code to generate update bindings...
			# $queryStr .= " $key = :".substr($key, 0, 1).",";
			$queryStr .= " $key = :$key,";
		}

		# remove trailing comma
		$queryStr = rtrim($queryStr, ',');
		
		$queryStr .= " WHERE id = :id";

		$stmt = $con->prepare($queryStr);

		$array['id'] = $id;

		$stmt->execute($array);

		if($stmt->rowCount() == 1){
			$res = true;
		}
		return $res;
	}

	function cleanupFilename($s) {

		#remove special characters and whitespaces from filename
		$s = str_replace(' ', '-', $s);
		$dirt = ['_','@','$','!','%','&','^','/','\\',',','?','>','<','`','~','=','+','[',']','{','}','|','(',')'];
		return str_replace($dirt, '', $s);
	}

	function doFileUpload($filesArray, $fieldName, $uploadDir) {
		$res = false;
		# process filename
		$filename = cleanupFilename($filesArray[$fieldName]['name']);

		# generate random number
		$random = substr(number_format(time() * rand(),0,'',''),0,10);

		$newfilename = $random.$filename;

		# build destination location
		$upload_dest = $uploadDir.$newfilename;

		# move file from tmp to destination
		$bool = move_uploaded_file($filesArray[$fieldName]['tmp_name'], $upload_dest);

		if($bool) {
			$res = true;
		}

		return [$res, $upload_dest];
	}
