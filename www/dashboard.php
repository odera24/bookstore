<?php
	# include db connection
	include "config/db.php";

	# import functions
	include "includes/functions.php";

	# import header
	include "includes/header.php";
?>


<div class="wrapper">
	<div id="stream">
		<h1 id="register-label">Add Post</h1>
		<hr>

		<form id="register">
		<div>
			<label>post title:</label>
			<input type="text" name="title" placeholder="Post Title">
		</div>
		<div>
			<label>post excerpt:</label>
			<textarea placeholder="summary" name ="summary"></textarea>
		</div>

		<div>
			<label>post content:</label>
			<textarea placeholder="content" name="content" class="post-box"></textarea>
		</div>

		<input type="submit" name="submit" value="publish">

		</form>
	</div>
</div>

<?php
	# import footer
	include "includes/footer.php";
?>
