<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/phpEcommerce/core/init.php';
	include 'includes/head.php';
	include 'includes/navigation.php';

	if(isset($_GET['add'])){
	$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
	$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
	if($_POST) {
		if (!empty($_POST['sizes'])){

			$sizeString = sanitize($_POST['sizes']);
			# Remove comma from right side of size string
			$sizeString = rtrim($sizeString, ',');

			# explode forms an array of strings separated by the first parameter
			# Split the Size string up into array items wherever theres a comma
			$sizesArray = explode(',',$sizeString);

			$sArray = array();
			$qArray = array();
			foreach($sizesArray as $ss){
				#split each individual size/quantity combination into seperate values in an array
				$s = explode(':', $ss);
					//the 0 index is the sizes
					$sArray[] = $s[0];

					//the 1 index is the quantity
					$qArray[] = $s[1];
			}

		}else{$sizesArray=array();}
	}
	?>
		<h2 class="text-center">Add A New Product</h2><hr>
		<form action="products.php?add=1" method="post" enctype="multipart/form-data">
			<div class="form-group col-md-3">
				<label for="title">Title*: </label>
				<input type="text" name="title" id="title" class="form-control" value="<?=((isset($_POST['title']))?sanitize($_POST['title']):''); ?>">
			</div>
			<div class="form-group col-md-3">
				<label for="brand">Brand*: </label>
				<select class="form-control" name="brand" id="brand">
					<option value=""<?=((isset($_POST['brand']) && $_POST['brand'] == '')?' selected':''); ?>></option>
					
					<?php while($brand = mysqli_fetch_assoc($brandQuery)) : ?>
					<option value="<?php #make the current brand the "selected" option (default) if it's been set
									echo $brand['id'];?>"<?=((isset($_POST['brand']) && $_POST['brand'] == $brand['id'])?' selected':''); ?>><?=$brand['brand'];?>
					</option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="parent">Parent Category*: </label>
				<select class="form-control" name="parent" id="parent">
					<option value=""<?=((isset($_POST['parent']) && $_POST['parent'] == '')?' selected':''); ?>></option>
					
					<?php while($parent = mysqli_fetch_assoc($parentQuery)) : ?>
					<option value="<?= $parent['id'];?>"<?=((isset($_POST['parent']) && $_POST['parent'] == $parent['id'])?' selected':''); ?>><?=$parent['category'];?>
					</option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="child">Child Category*: </label>
				<select id="child" name="child" class="form-control">
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="price">Price*:</label>
				<input type="text" class="form-control" id="price" name="price" value="<?=((isset($_POST['price']))?sanitize($_POST['price']):'');?>">
			</div>
			<div class="form-group col-md-3">
				<label for="list_price">List Price*:</label>
				<input type="text" class="form-control" id="list_price" name="list_price" value="<?=((isset($_POST['list_price']))?sanitize($_POST['list_price']):'');?>">
			</div>
			<div class="form-group col-md-3">
			<label>Quantity & Sizes*:</label>
				<button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
			</div>
			<div class="form-group col-md-3">
				<label for="sizes">Sizes & Qty Preview</label>
				<input type="text" class="form-control" name="sizes" id="sizes" value="<?=((isset($_POST['sizes']))?$_POST['sizes']:'');?>" readonly>
			</div>
			<div class="form-group col-md-6">
				<label for="photo">Product Photo:</label>
				<input type="file" name="photo" id="photo" class="form-control">
			</div>
			<div class="form-group col-md-6">
				<label for="description">Description:</label>
				<textarea name="description" id="description" class="form-control" rows="6" ><?=((isset($_POST['description']))?sanitize($_POST['description']):'');?></textarea>
			</div>
			<div class="form-group pull-right">
				<input type="submit" value="Add Product" class="form-control btn btn-success">
			</div>
		</form>

		<!-- Modal -->
		<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizes Modal">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Size & Quantity</h4>
		      </div>
		      <div class="modal-body">
		      	<div class="container-fluid">
		        <?php for($i =1; $i <= 12; $i++): ?>
					<div class="form-group col-md-4">
						<label for="size<?=$i;?>">Size:</label>
						<input type="text" class="form-control" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:''); ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="qty<?=$i;?>">Quantity:</label>
						<input type="number" class="form-control" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:''); ?>" min="0">
					</div>
		        <?php endfor; ?>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
		      </div>
		    </div>
		  </div>
		</div>

	<?php
	# The "add product" button hasn't been clicked therefore show the products table
	}else{

	$sql = "SELECT * FROM products";
	$presults = $db->query($sql);

	//toggle featured on/off
	if(isset($_GET['featured'])) {
		$id = (int)$_GET['id'];
		$featured = (int)$_GET['featured'];
		$featuredSql = "UPDATE products SET featured='$featured' WHERE id='$id'";
		$db->query($featuredSql);
		header('Location: products.php');
	}

?>
<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-button">Add Product</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
	<thead><th></th><th>Product</th><th>Price</th><th>Categories</th><th>Featured</th><th>Sold</th></thead>
	<tbody>
		<?php 
			while($product = mysqli_fetch_assoc($presults)) : 
				//store category id that current product is in
				$category_id = $product['categories'];
				//select the category using the id above and store in associative array
				$categorySQL = "SELECT * FROM categories WHERE id='$category_id'";
				$category = mysqli_fetch_assoc($db->query($categorySQL));
				//store the parent id of the current category
				$parentID = $category['parent'];
				//select the parent from the category table to get the name of it
				$parentSQL = "SELECT * FROM categories WHERE id='$parentID'";
				$parent = mysqli_fetch_assoc($db->query($parentSQL));
				//combine the category with the categories parent
				$categoryPlusParent = $category['category'].'~'.$parent['category'];
		?>
			<tr>
				<td>
					<a href="products.php?edit=<?= $product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="products.php?delete=<?= $product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
				</td>
				<td><?=$product['title']; ?></td>
				<td><?=money($product['price']); ?></td>
				<td><?=$categoryPlusParent; ?></td>
				<td>
					<a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-default btn-xs">
						<span class="glyphicon glyphicon-<?= (($product['featured'] == 1)?'minus':'plus'); ?>"></span>
					</a>
					&nbsp; <?=(($product['featured'] == 1)?'Featured Product':'Not Featured');?>
				</td>
				<td></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>


<?php 
} // End if ($_GET['add'] is set) 
 include 'includes/footer.php'; 
 ?>