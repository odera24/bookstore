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
