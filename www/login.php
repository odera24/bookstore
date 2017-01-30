<?php
	#include header
	include "includes/header.php";
?>
<div class="wrapper">
	<h1 id="login-label">Admin Login</h1>
	<hr>
	<form id="login">
		<div>
			<label>email:</label>
			<input type="text" name="email" placeholder="email">
		</div>
		<div>
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
