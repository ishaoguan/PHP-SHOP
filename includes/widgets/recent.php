<h3 class="text-center">Popular Items</h3>
<?php
	# This script will select the last 5 (unique) products that have been purchased
	# Display them in a table and be included on the right side bar as a Popular Items widget
	
	// By ordering by id DESC and LIMIT 5 we are ensuring that just the last 5 are selected
	$transQ = $db->query("SELECT * FROM cart WHERE paid = 1 ORDER BY id DESC LIMIT 5");
	$results = array();
	while($row = mysqli_fetch_assoc($transQ)){
		// Add each row returned from the query into the results array
		// This creates a multidimentional array:
		# [0](id, items, expire_date, paid) [1](id, items, expire_date, paid) ...
		$results[] = $row;
	}
	$row_count = $transQ->num_rows;
	$used_ids = array();

	# execute the following code for however many rows returned from the query
	for($i=0;$i<$row_count;$i++){
		$json_items = $results[$i]['items'];
		$items = json_decode($json_items,true);
		// for each of the items in the current cart, . If not then add it. Once it's added it wont be added added
		foreach ($items as $item){
			// check to see if the id is in the used_ids array.. (if it is it wont be added)
			if(!in_array($item['id'],$used_ids)){
				//if it's not in the array then the item will be added.
				$used_ids[] = $item['id'];
			}
		}
	}
?>
<div id="recent_widget">
	<table class="table table-condensed">
		<?php foreach($used_ids	as $id): 
			$productQ = $db->query("SELECT id, title FROM products WHERE id='$id'");
			$product = mysqli_fetch_assoc($productQ);
		?>
		<tr>
			<td><?=substr($product['title'],0,15);?></td>
			<td>
				<a href="javascript:void(0)" class="text-primary" onclick="detailsmodal(<?=$product['id'];?>)">View</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>