<?php
	require_once("../core/init.php");
	if(!is_logged_in()){
		login_error_redirect();
	}
	include("includes/head.php");
	include("includes/navigation.php");

	$archived_query = $db->query("SELECT * FROM products WHERE archived=1");


	if(isset($_GET['restore'])){
		$restore_id = (int)$_GET['restore'];
		$restore_query = $db->query("UPDATE products SET archived=0 WHERE id='$restore_id'");
		header("Location: archived.php");
	}
?>

<h2 class="text-center">Archived Products</h2><hr>

<?php if (mysqli_num_rows($archived_query) > 0) : ?>
<table class="table table-bordered table-striped table-condensed table-auto">
	<thead>
		<th>ID</th>
		<th>Product</th>
		<th>Price</th>
		<th>Category</th>
		<th>Restore</th>
	</thead>
	<tbody>
		<?php 
			while($product = mysqli_fetch_assoc($archived_query)) : 
				$category_id = $product['categories'];
				$category_query = $db->query("SELECT * FROM categories WHERE id='$category_id'");
				$category = mysqli_fetch_assoc($category_query);

				$parent_id = $category['parent'];
				$parent_query = $db->query("SELECT * FROM categories WHERE id='$parent_id'");
				$parent = mysqli_fetch_assoc($parent_query);

				$categories = $category['category'].'~'.$parent['category'];
		?>
		<tr>
			<td><?=$product['id']?></td>
			<td><?=$product['title']?></td>
			<td><?=$product['price']?></td>
			<td><?=$categories?></td>
			<td><a href="archived.php?restore=<?=$product['id'];?>" class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span></a></td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>
<?php else : ?>
<p class="bg-info text-center">There are currently no archived products. To archive a product, click the <span class="glyphicon glyphicon-remove-sign"></span> icon on the products page.</p>

<?php 
endif;
include("includes/footer.php");

?>