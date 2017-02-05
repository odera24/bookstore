<?php
	session_start();
	# include db connection
	include "config/db.php";

	# import functions
	include "includes/functions.php";

	$title = 'View Categories';
	# import header
	include "includes/header2.php";

	$rows = fetchCategories($dbcon);
?>

<div class="wrapper">
	<div id="stream">
		<table id="tab">
			<thead>
				<tr>
					<th>Category title</th>
					<th>Description</th>
					<th>edit</th>
					<th>delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($rows as $row) {
						# code...
						echo '<tr><td>'.$row['name'].'</td><td>'.$row['description']."</td><td><a href=\"edit_category.php?id=$row[id]\">edit</a></td><td><a href=\"delete_category.php?id=$row[id]\">delete</a></td></tr>";
					}
				?> 
      		</tbody>
		</table>
	</div>
</div>

<?php
	# import footer
	include "includes/footer.php";
?>
