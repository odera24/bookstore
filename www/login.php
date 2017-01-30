<?php
	#connect database..
	include "config/db.php";

	# include functions
	include "includes/functions.php";

	#include header
	include "includes/header.php";

	# handle form errors
	$errors = [];

	#ensure that login button is clicked
	if (array_key_exists('submit', $_POST)) {

		# validate email
		if (!empty($_POST['email'])) {
			$email = $_POST['email'];

			# check if email exist
			$chk = doesEmailExist($dbcon, $email);

			if(!$chk) {
				# admin email does not exist in database
				$errors['email'] = 'Unauthorized admin user';
			} else {
				# email exists in database
				# validate password
				if(!empty($_POST['password'])) {
					$pwd = $_POST['password'];

					# autheticate user by comparing db password to supplied password
					$auth = loginAdmin($dbcon, $email, $pwd);

					echo $auth;

					if($auth) {
						header('location: dashboard.php');
					} else {
						$errors['password'] = 'Email/Password mismatch';
					}

				} else {
					# empty password field
					$errors['password'] = 'Please enter your password';
				}

			}





		} else {
			$errors['email'] = 'Please enter an email address';
		}

		
	}


?>
<div class="wrapper">
	<h1 id="login-label">Admin Login</h1>
	<hr>
	<form id="login" method="POST">
		<div>
			<?php display_errors('email',$errors); ?>
			<label>email:</label>
			<input type="text" name="email" placeholder="email">
		</div>
		<div>
			<?php display_errors('password',$errors); ?>
			<label>password:</label>
			<input type="password" name="password" placeholder="password">
		</div>
		<input type="submit" name="submit" value="login">
	</form>

	<h4 class="jumpto">Don't have an account? <a href="register.php">register</a></h4>
</div>
<?php
	#include footer
	include "includes/footer.php";
?>
