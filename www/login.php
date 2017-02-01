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
		if(empty($_POST['email'])) {
			$errors['email'] = "Please enter an email address";
		} else {
			$email = $_POST['email'];
		}

		# validate password
		if(empty($_POST['password'])) {
			$errors['password'] = "Please enter a password";
		} else {
			$pass = $_POST['password'];
		}

		# process if both username and password are supplied
		if(!empty($_POST['email']) && !empty($_POST['password'])) {

			$result = authAdminPassword($dbcon,$email,$pass);

			if ($result) {
				header('location: dashboard.php');
			}
			$errors['password'] = 'Email/Password Mismatch';
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
