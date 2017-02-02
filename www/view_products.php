<?php
	session_start();
	# include db connection
	include "config/db.php";

	# import functions
	include "includes/functions.php";

	$title = 'View Products';
	# import header
	include "includes/header2.php";

	$rows = fetchProducts($dbcon);
?>

<div class="wrapper">
	<div id="stream">
		<table id="tab">
			<thead>
				<tr>
					<th>product title</th>
					<th>product category</th>
					<th>author</th>
					<th>description</th>
					<th>edit</th>
					<th>delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($rows as $row) {
						# code...
						echo '<tr><td>'.$row['name'].'</td><td>'.fetchCategoryName($dbcon, $row['id']).'</td><td>'.$row['author'].'</td><td>'.$row['description']."</td><td><a href=\"edit_product.php?id=$row[id]\">edit</a></td><td><a href=\"delete_product.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">delete</a></td></tr>";
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
