<!DOCTYPE html>
<html>
<head>
	<title>Shaunta's Boutique</title>
	<!--Bootstrap Stylesheet-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

	<!--Custom Stylesheet-->
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<!--Reposive Meta Tag-->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<!--jQuery CDN-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

	<!--Bootstrap JS-->
	<script src="js/bootstrap.min.js"></script>
</head>
<body>

	<!--Navigation Bar-->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<a href="index.php" class="navbar-brand">Shaunta's Boutqiue Changed</a>
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Men<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Shirts</a></li>
						<li><a href="#">Pants</a></li>
						<li><a href="#">Shoes</a></li>
						<li><a href="#">Accessories</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>

	<!--Header-->
	<div id="headerWrapper">
		<div id="back-flower"></div>
		<div id="logotext"></div>
		<div id="fore-flower"></div>
	</div>

	<div class="container-fluid">
		<!--Left Sidebar-->
		<div class="col-md-2">Left Side Bar</div>

		<!--Main Content-->
		<div class="col-md-8">
			<div class="row">
				<h2 class="text-center">Feature Products</h2>
				<div class="col-md-3">
					<h4>Levis Jeans</h4>
					<img src="images/products/men4.png" alt="Levis Jeans" class="img-thumb"/>
					<p class="list-price text-danger">List Price: <s>$54.99</s></p>
					<p class="price">Our Price: $19.99</p>
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
				</div>

				<div class="col-md-3">
					<h4>Product 2</h4>
					<img src="images/products/men1.png" alt="Levis Jeans" class="img-thumb"/>
					<p class="list-price text-danger">List Price: <s>$54.99</s></p>
					<p class="price">Our Price: $19.99</p>
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
				</div>

				<div class="col-md-3">
					<h4>Product 3</h4>
					<img src="images/products/men2.png" alt="Levis Jeans" class="img-thumb"/>
					<p class="list-price text-danger">List Price: <s>$54.99</s></p>
					<p class="price">Our Price: $19.99</p>
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
				</div>

				<div class="col-md-3">
					<h4>Product 4</h4>
					<img src="images/products/men3.png" alt="Levis Jeans" class="img-thumb"/>
					<p class="list-price text-danger">List Price: <s>$54.99</s></p>
					<p class="price">Our Price: $19.99</p>
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
				</div>

				<div class="col-md-3">
					<h4>Product 5</h4>
					<img src="images/products/men5.png" alt="Levis Jeans" class="img-thumb"/>
					<p class="list-price text-danger">List Price: <s>$54.99</s></p>
					<p class="price">Our Price: $19.99</p>
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
				</div>

				<div class="col-md-3">
					<h4>Product 6</h4>
					<img src="images/products/men6.png" alt="Levis Jeans" class="img-thumb"/>
					<p class="list-price text-danger">List Price: <s>$54.99</s></p>
					<p class="price">Our Price: $19.99</p>
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
				</div>

				<div class="col-md-3">
					<h4>Product 7</h4>
					<img src="images/products/girls4.png" alt="Levis Jeans" class="img-thumb"/>
					<p class="list-price text-danger">List Price: <s>$54.99</s></p>
					<p class="price">Our Price: $19.99</p>
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
				</div>

				<div class="col-md-3">
					<h4>Product 8</h4>
					<img src="images/products/girls2.png" alt="Levis Jeans" class="img-thumb"/>
					<p class="list-price text-danger">List Price: <s>$54.99</s></p>
					<p class="price">Our Price: $19.99</p>
					<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
				</div>
			</div>
		</div>

		<!--Right Sidebar-->
		<div class="col-md-2">Right Side Bar</div>
	</div>

	<footer class="text-center" id="footer">&copy; Copyright 2016 - Design by <a href="http://www.joerushton.com">joerushton</a></footer>

	<!--Details Modal-->
	<div class="modal fade details-1" id="details-1" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title text-center">Levis Jeans</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<div class="center-block">
									<img src="images/products/men4.png" alt="Levis Jeans" class="details img-responsive">
								</div>
							</div>
							<div class="col-sm-6">
								<h4>Details</h4>
								<p>These jeans are amazing! They are straight leg, fit great and look sexy.</p>
								<hr>
								<p>Price: $34.99</p>
								<p>Brand: Levis</p>
								<form action="add_cart.php" method="post">
									<div class="form-group">
										<div class="col-xs-3">
											<label for="quantity">Quantity:</label>
											<input type="text" class="form-control" id="quantity" name="quantity">
										</div><div class="col-xs-9"></div>
										<p>Available: 3</p>
									</div><br><br>
									<div class="form-group">
										<label for="size">Size:</label>
										<select name="size" id="size" class="form-control">
											<option value="">Choose a size</option>
											<option value="28">28</option>
											<option value="32">32</option>
											<option value="36">36</option>
										</select>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal">Close</button>
					<button class="btn btn-warning" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
				</div>
			</div>
		</div>
	</div>

<script>
	$(window).scroll(function(){
		
		//Paralax LOGO
		var vscroll = $(this).scrollTop();
		jQuery('#logotext').css({
			//Setting the Y position of the image by using translate and the variable above
			"transform" : "translate(0px, "+ vscroll/2 +"px)"
		});

		//Paralax BACKFLOWER
		var vscroll = $(this).scrollTop();
		jQuery('#back-flower').css({
			//Setting the Y position of the image by using translate and the variable above
			"transform" : "translate(" + vscroll/5 + "px, -" + vscroll/12 + "px)"
		});

		//Paralax FRONTFLOWER
		var vscroll = $(this).scrollTop();
		jQuery('#fore-flower').css({
			//Setting the Y position of the image by using translate and the variable above
			"transform" : "translate(0px, -"+ vscroll/2 +"px)"
		});
	})
</script>
</body>
</html>