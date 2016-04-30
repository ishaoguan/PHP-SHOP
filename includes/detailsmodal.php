<?php
require_once('../core/init.php');
//since we used method "post" in the AJAX. we can use:
$id = $_POST['id'];
$id = (int)$id;

$sql = "SELECT * FROM products WHERE id='$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);

//get the brand id for the current product
$brand_id = $product['brand'];
//create a new query to get the brand from the brand table using the brand id
$sql = "SELECT * FROM brand WHERE id='$brand_id'";
$brand_query = $db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);

//Store the sizes column in the string
$sizestring = $product['sizes'];
//Store the size string in an array and split each item up wherever theres a "," as a separate array item
$size_array = explode(',', $sizestring);

?>


<?php ob_start(); ?>

<!--Details Modal-->
	<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" type="button" onclick="closeModal()" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title text-center"><?= $product['title'] ?></h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<div class="center-block">
									<img src="<?= $product['image'] ?>" alt="<?= $product['title'] ?>" class="details img-responsive">
								</div>
							</div>
							<div class="col-sm-6">
								<h4>Details</h4>
								<p><?= $product['description'] ?></p>
								<hr>
								<p>Price: $<?= $product['price'] ?></p>
								<p>Brand: <?= $brand['brand'] ?></p>
								<form action="add_cart.php" method="post">
									<div class="form-group">
										<div class="col-xs-3">
											<label for="quantity">Quantity:</label>
											<input type="text" class="form-control" id="quantity" name="quantity">
										</div><div class="col-xs-9"></div>
									</div><br><br>
									<div class="form-group">
										<label for="size">Size:</label>
										<select name="size" id="size" class="form-control">
											<option value="">Choose a size</option>
											<?php
												foreach ($size_array as $string) {
													//Separate the size value and quantity for this current string wherever there is a colon.
													$string_array = explode(':', $string);
													$size = $string_array[0];
													$quantity = $string_array[1];
													echo '<option value="' . $size . '">' . $size . ' ('.$quantity.' Available)</option>';
												}
											?>
										</select>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" onclick="closeModal()">Close</button>
					<button class="btn btn-warning" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		function closeModal(){
			jQuery('#details-modal').modal('hide');

			setTimeout(function(){
				jQuery('#details-modal').remove();
			},200);
		}
	</script>
	<?php echo ob_get_clean(); ?>