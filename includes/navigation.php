<?php
$sql = "SELECT * FROM categories WHERE parent=0";
//use the $db object and call the query method with the query as argument
$pquery = $db->query($sql);
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
		      <a href="index.php" class="navbar-brand">BC</a>
		    </div>
			<div class="collapse navbar-collapse" id="responsive-nav">
				<ul class="nav navbar-nav">
					<?php while($parent = mysqli_fetch_assoc($pquery)) : ?>
						<?php 
						//Store the current parent id in a variable we can use
						$parent_id = $parent['id']; 
						$sql2 = "SELECT * FROM categories WHERE parent=$parent_id";
						$cquery = $db->query($sql2);
						?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category']; ?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php while($child = mysqli_fetch_assoc($cquery)) : 
							echo '<li><a href="category.php?cat='.$child['id'].'">' . $child['category'] . '</a></li>';
							endwhile;
							?>
						</ul>
					</li>
				<?php 
				//using a colon to open and endwhile; to close is the same as using { and }
				endwhile; ?>
				<li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a></li>
				</ul>
			</div><!-- end navbar-collapse -->
		</div><!-- end container -->
	</nav>