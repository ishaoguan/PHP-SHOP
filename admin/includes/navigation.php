<!--Navigation Bar-->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<a href="index.php" class="navbar-brand">Shaunta's Boutqiue Admin</a>
			<ul class="nav navbar-nav">
				<li><a href="brands.php">Brands</a></li>
				<li><a href="categories.php">Categories</a></li>
				<li class="dropdown"><a href="" class="dropdown-toggle" data-toggle="dropdown">Products <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="products.php">Products</a></li>
						<li><a href="archived.php">Archived</a></li>
					</ul>
				</li>
				<?php if(has_permission()) : ?>
					<li><a href="users.php">Users</a></li>
				<?php endif; ?>
				<li class="dropdown"><a href="" class="dropdown-toggle" data-toggle="dropdown">Hello <?=$user_data['first'];?>! <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="change_password.php">Change Password</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
				<!--<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
					</ul>
					</li>-->
			</ul>
		</div>
	</nav>