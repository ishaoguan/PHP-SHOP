<?php
	$themeQ = $db->query("SELECT id, name FROM theme");
?>

<!--Navigation Bar-->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#responsive-nav" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
				<a href="index.php" class="navbar-brand">BC Admin</a>
			</div>
			<div class="collapse navbar-collapse" id="responsive-nav">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Dashboard</a></li>
					<li><a href="brands.php">Brands</a></li>
					<li><a href="categories.php">Categories</a></li>
					<li class="dropdown"><a href="" class="dropdown-toggle" data-toggle="dropdown">Products <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="products.php">Products</a></li>
							<li><a href="archived.php">Archived</a></li>
						</ul>
					</li>
					<li class="dropdown"><a href="" class="dropdown-toggle" data-toggle="dropdown">Theme <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php while($theme = mysqli_fetch_assoc($themeQ)): ?>
								<li><a href="?t=<?=$theme['id'];?>"><?=$theme['name'];?></a></li>
							<?php endwhile; ?>
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
					<ul class="nav navbar-right">
						<li><a href="../"><span class="glyphicon glyphicon-off"></span> Front-End</a></li>
					</ul>
			</div><!-- end navbar-collapse -->
		</div>
	</nav>