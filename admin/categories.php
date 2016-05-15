<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/phpEcommerce/core/init.php';
	if(!is_logged_in()){
		login_error_redirect();
	}
	include 'includes/head.php';
	include 'includes/navigation.php';

	//Select the parents query
	$sql = "SELECT * FROM categories WHERE parent = 0";
	$result = $db->query($sql);
	$errors = array();
	$category = '';
	//post_parent will be from the form $_POST['parent']
	$post_parent = '';

	//Edit Category
	if(isset($_GET['edit']) && !empty(['edit'])){
		$edit_id = (int)$_GET['edit'];
		$edit_id = sanitize($edit_id);
		$edit_sql = "SELECT * FROM categories WHERE id='$edit_id'";
		$edit_result = $db->query($edit_sql);
		$edit_category = mysqli_fetch_assoc($edit_result);
	}

	//Delete category
	if(isset($_GET['delete']) && !empty($_GET['delete'])){
		$delete_id = (int)$_GET['delete'];
		$delete_id = sanitize($delete_id);
		$dsql = "DELETE FROM categories WHERE id = '$delete_id' OR parent = '$delete_id'";
		$db->query($dsql);
		header('Location: categories.php');
	}


	//Process Form
	if(isset($_POST) && !empty($_POST)){
		$post_parent = sanitize($_POST['parent']);
		$category = sanitize($_POST['category']);
		//Querying for checking if exists in db
		$formQuery = "SELECT * FROM categories WHERE category='$category' AND parent='$post_parent'";
		if(isset($_GET['edit'])){
			$id = $edit_category['id'];
			//New query to check if it exists and ISNT the current one. We want it to change the current one and therefore don't want to populate $error array by having the $count variable > 0 from selecting the current category.
			$formQuery = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND id != '$id'";
		}
		$formResult = $db->query($formQuery);
		$count = mysqli_num_rows($formResult);

		//if category is blank
		if($category == ''){
			$errors[] .= 'The category cannot be left blank.';
		}

		//If exists in the database
		if($count > 0){
			$errors[] .= $category . ' already exists with that parent';
		}

		//Display errors or update database
		if(!empty($errors)){
			//display errors
			$display = display_errors($errors); ?>
			<script>
				//use jquery to display the errors in a specific div tag on the page
				jQuery('document').ready(function(){
					jQuery('#errors').html('<?=$display; ?>');
				});
			</script>
		<?php }else {
			//update database
			$insertQUERY = "INSERT INTO categories (category, parent) VALUES ('$category', '$post_parent')";
			if(isset($_GET['edit'])){
				//when the url has ?edit=X in, the query will update when the user submits the form rather than inserting.
				$insertQUERY = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id='$edit_id'";
			}
			$db->query($insertQUERY);
			header("Location: categories.php");
		}
	}

	$category_value = '';
	$parent_value = 0;
	if(isset($_GET['edit'])){
		$category_value = $edit_category['category'];
		$parent_value = $edit_category['parent'];
	} else {
		if (isset($_POST)){
			$category_value = $category;
			$parent_value = $post_parent;
		}
	}
?>
<h2 class="text-center">Categories</h2><hr>
<div class="row">

	<!--Form-->
	<div class="col-md-6">
		<form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');  ?>" method="post">
			<legend><?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Category</legend>
			<div id="errors"></div>
			<div class="form-group">
				<label for="parent">Parent</label>
				<select class="form-control" name="parent" id="parent">
					<option value="0"<?= (($parent_value == 0)?' selected="selected"':'');  ?>>Parent</option>
					<?php while($parent = mysqli_fetch_assoc($result)): ?>
						<option value="<?=$parent['id'];?>"<?=(($parent_value == $parent['id'])?' selected="selected"':''); ?> ><?=$parent['category'];?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="category">Category</label>
				<input type="text" class="form-control" id="category" name="category" value="<?= $category_value; ?>">
			</div>
			<div class="form-group">
				<?php
				if (isset($_GET['edit'])){ ?>
					<a href="categories.php" class="btn btn-default">Cancel</a>
				<?php }
				?>
				<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?> Category" class="btn btn-success" name="add_category">
			</div>
		</form>
	</div>

	<!--Category Table-->
	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<th>Category</th><th>Parent</th><th></th>
			</thead>
			<tbody>
			<?php 
				//Select the parents query again since the previous one has been used in a while loop already
				$sql = "SELECT * FROM categories WHERE parent = 0";
				$result = $db->query($sql);

				//looping through the parents and generating a new query which selects the categories with the current parent
				while($parent = mysqli_fetch_assoc($result)): 
					$parent_id = (int)$parent['id'];
					$sql2 = "SELECT * FROM categories where parent = '$parent_id'";
					$cResult = $db->query($sql2);
			?>
				<tr class="bg-primary">
					<td><?= $parent['category']; ?></td>
					<td></td>
					<td>
						<a href="categories.php?edit=<?= $parent['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
						<a href="categories.php?delete=<?= $parent['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
					</td>
				</tr>
				<?php while($child = mysqli_fetch_assoc($cResult)): ?>
					<tr class="bg-info">
						<td><?=$child['category'];?></td>
						<td><?=$parent['category'];?></td>
						<td>
							<a href="categories.php?edit=<?= $child['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
							<a href="categories.php?delete=<?= $child['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
						</td>
					</tr>
				<?php //end of child loop 
						endwhile; ?>
			<?php //end of parent loop 
				endwhile; ?>
			</tbody>
		</table>
	</div>
</div>

<?php include 'includes/footer.php'; ?>