<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/phpEcommerce/core/init.php';
	if(!is_logged_in()){
		login_error_redirect();
	}
	include 'includes/head.php';
	include 'includes/navigation.php';

	//Delete Product (Archive it)
	if(isset($_GET['delete'])){
		$delete_id = (int)$_GET['delete'];
		$db->query("UPDATE products SET archived = 1 WHERE id = '$delete_id'");
		header('Location: products.php');
	}

	if(isset($_GET['add']) || isset($_GET['edit'])){
	$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
	$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
	# Variables for form fields ensures no undefined variables. These are echo'd in the respective form fields.

	$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
	$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
	$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
	$category = ( (isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
	$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
	$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
	$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
	$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
	$saved_image = '';

	# if the user entered something, that will stick, otherwise (left blank) the current record will show which is set in the if($_GET['edit']) below.
		if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$productResults = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
			$product = mysqli_fetch_assoc($productResults);
			if(isset($_GET['delete_image'])){
				$image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];
				# use PHP build in unlink function to delete a file from the given path
				unlink($image_url);
				# Remove the image path from the product record and relocate back to edit form
				$db->query("UPDATE products SET image = '' WHERE id = '$edit_id'");
				header('Location: products.php?edit='.$edit_id);
			}
			# Update the variables displayed in the forms if $_GET['edit'] is set.
			# Now the record with the id that matches with the edit_id will show in the fields
			$category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
			$title = ((isset($_POST['title']) && $_POST['title'] != '')? sanitize($_POST['title']) :  $product['title'] );
			$brand = ((isset($_POST['brand']) && $_POST['brand'] != '')? sanitize($_POST['brand']) :  $product['brand'] );

			$parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
			$parentResult = mysqli_fetch_assoc($parentQ);

			$parent = ((isset($_POST['parent']) && $_POST['parent'] != '')? sanitize($_POST['parent']) :  $parentResult['parent'] );
			$price = ((isset($_POST['price']) && $_POST['price'] != '')? sanitize($_POST['price']) :  $product['price'] );
			$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')? sanitize($_POST['list_price']) :  $product['list_price'] );
			$description = ((isset($_POST['description']) && $_POST['description'] != '')? sanitize($_POST['description']) :  $product['description'] );
			$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')? sanitize($_POST['sizes']) :  $product['sizes'] );
			$saved_image = (($product['image'] != '')?$product['image']:'');
			$dbpath = $saved_image;
		}
		//if the sizes variable has values in it, build up the size array
		if (!empty($sizes)){

			$sizeString = sanitize($sizes);
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



	if($_POST) {

		# no need for individual form field checks since we created a "required" array
		# and then said that foreach item check if theres a POST with that field name

		$errors = array();

		$required = array('title', 'brand', 'price', 'child', 'sizes');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All fields with astrisk* are required.';
				# the break jumps out of the loops after the error message has been displayed once so that it doesn't repeat itself.
				break;
			}
		}

		# If a file has been selected, then..
		if (!empty($_FILES)) {
			# the input type="file" has the name of photo and so its stored in $_FILES associative array with the index ['photo']
			$photo = $_FILES['photo'];
			$name = $photo['name'];
			$uploadName = '';
			$uploadPath = '';

			# if ($name) means that all the upload related functionality only happens if a name exists. without a name means that the user hasn't selected a file and so there's no reason to create file paths and check the file etc.
			if ($name) {
			$nameArray = explode('.',$name);
			$fileName = $nameArray[0];
			$fileExt = $nameArray[1];
			# add unique name for uploaded file and keep the file extension
			$uploadName = md5(microtime()).'.'.$fileExt;
			# upload path in this case is C:/xampp/htdocs/phpecommerce/images/products
			$uploadPath = BASEURL.'images/products/'.$uploadName;
			# the path entered into the database
			$dbpath = '/phpEcommerce/images/products/'.$uploadName;

			$mime = explode('/',$photo['type']);
			$mimeType = $mime[0];
			$tmpLoc = $photo['tmp_name'];
			$fileSize = $photo['size'];
			$allowed = array('png', 'jpg', 'jpeg', 'gif');

				//Size Check
				if ($fileSize > 15000000) {
					$errors[] = 'The file size must be under 15MB.';
				}
				//Image Check - Type of file
				if ($mimeType != 'image' && $mimeType != '') {
					$errors[] = 'The file must be an image.';
				}
				//Extension Check
				if (!in_array($fileExt, $allowed) && !empty($fileExt)) {
					$errors[] = 'The file type must be PNG, JPG, JPEG or GIF.';
				}

			}
			
			
		}

		if(!empty($errors)){ //If the error array is populated..

			#display the errors using our custom error function
			echo display_errors($errors);
		}else{
			# Upload file and Insert into database
			if(!empty($_FILES)){
				move_uploaded_file($tmpLoc,$uploadPath); #(from, destination)
			}
			$insertSQL = "INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`,`description`) VALUES ('$title','$price','$list_price','$brand','$category','$sizeString','$dbpath','$description')";
			if(isset($_GET['edit'])){
				# if we're editing, we want to update a record rather than insert a new one
				$insertSQL = "UPDATE products SET title = '$title', price = '$price', list_price='$list_price', brand = '$brand', categories = '$category', sizes = '$sizes', image = '$dbpath', description = '$description' WHERE id='$edit_id'";
			}
			$db->query($insertSQL);
			header('Location: products.php');

		}
	}
	?>
		<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New'); ?>  Product</h2><hr>
		<form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1'); ?>" method="post" enctype="multipart/form-data">
			<div class="form-group col-md-3">
				<label for="title">Title*: </label>
				<input type="text" name="title" id="title" class="form-control" value="<?=$title; ?>">
			</div>
			<div class="form-group col-md-3">
				<label for="brand">Brand*: </label>
				<select class="form-control" name="brand" id="brand">
					<option value=""<?=(($brand == '')?' selected':'');?>></option>
					
					<?php while($b = mysqli_fetch_assoc($brandQuery)) : ?>
					<option value="<?= $b['id'];?>"<?=(($brand == $b['id'])?' selected':''); ?>><?=$b['brand'];?>
					</option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="form-group col-md-3">
				<label for="parent">Parent Category*: </label>
				<select class="form-control" name="parent" id="parent">
					<option value=""<?=(($parent == '')?' selected':'');?>></option>
					
					<?php while($p = mysqli_fetch_assoc($parentQuery)) : ?>
					<option value="<?= $p['id'];?>"<?=(($parent == $p['id'])?' selected':''); ?>><?=$p['category'];?>
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
				<input type="text" class="form-control" id="price" name="price" value="<?=$price;?>">
			</div>
			<div class="form-group col-md-3">
				<label for="list_price">List Price:</label>
				<input type="text" class="form-control" id="list_price" name="list_price" value="<?=$list_price;?>">
			</div>
			<div class="form-group col-md-3">
			<label>Quantity & Sizes*:</label>
				<button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
			</div>
			<div class="form-group col-md-3">
				<label for="sizes">Sizes & Qty Preview</label>
				<input type="text" class="form-control" name="sizes" id="sizes" value="<?=$sizes;?>" readonly>
			</div>
			<div class="form-group col-md-6">
				<?php if($saved_image != ''): ?>
					<div class="saved-image">
						<img src="<?=$saved_image;?>" alt="saved image" /><br>
						<a href="products.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
					</div>
				<?php else: ?>
					<label for="photo">Product Photo:</label>
					<input type="file" name="photo" id="photo" class="form-control">
				<?php endif; ?>
			</div>
			<div class="form-group col-md-6">
				<label for="description">Description:</label>
				<textarea name="description" id="description" class="form-control" rows="6" ><?=$description;?></textarea>
			</div>
			<div class="form-group pull-right">
				<a href="products.php" class="btn btn-default">Cancel</a>
				<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?> Product" class="btn btn-success">
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

	$sql = "SELECT * FROM products WHERE archived=0";
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
 <script>
 	jQuery('document').ready(function(){
 		get_child_options('<?=$category;?>');
 	});
 </script>