<?php
	require_once("../core/init.php");
	if(!is_logged_in()){
		login_error_redirect();
	}
	if(!has_permission('admin')){
		permission_error_redirect('index.php');
	}
	include("includes/head.php");
	include("includes/navigation.php");

	//Delete User
	if(isset($_GET['delete'])){
		$delete_id = sanitize($_GET['delete']);
		$delete_id = (int)$delete_id;
		$db->query("DELETE FROM users WHERE id='$delete_id'");
		$_SESSION['success_flash'] = 'User has been deleted';
		header('Location: users.php');
	}

	//if user clicked Add user, do this. Otherwise show the users table
	if(isset($_GET['add'])){
		$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
		$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
		$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
		$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
		$permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
		$errors = array();
		if($_POST){
			$emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
			if (mysqli_num_rows($emailQuery) == 1){
				$errors[] = 'That email address already exists, please choose another.';
			}

			$required = array('name','email','password','confirm','permissions');
			foreach ($required as $field) {
				if(empty($_POST[$field])){
					$errors[] = 'You must fill out all fields';
					break;
				}
			}

			if(strlen($password) < 6){
				$errors[] = 'Your password must be at least 6 characters';
			}
			if($password != $confirm) {
				$errors[] = 'The passwords do not match.';
			}

			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors[] = 'Please enter a valid email address';
			}

			if (!empty($errors)){
				echo display_errors($errors);
			} else {
				# Add user to db
				$hashed = password_hash($password, PASSWORD_DEFAULT);
				$db->query("INSERT INTO users (full_name,email,password,permissions) VALUES ('$name','$email','$hashed','$permissions')");
				$_SESSION['success_flash'] = 'User has been added with the email "' . $email . '"';
				header('location: users.php');
				
			}
		}
		?>
		<h2 class="text-center">Add A New User</h2><hr>
		<form action="users.php?add=1" method="post">
			<div class="form-group col-md-6">
				<label for="name">Full Name:</label>
				<input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="email">Email:</label>
				<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="password">Password:</label>
				<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="confirm">Confirm Password:</label>
				<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="permissions">Permissions:</label>
				<select class="form-control" name="permissions" id="permissions">
				<option value=""<?=(($permissions == '')?' selected':'') ?>></option>
					<option value="editor"<?=(($permissions == 'editor')?' selected':'') ?>>Editor</option>
					<option value="admin,editor"<?=(($permissions == 'admin,editor')?' selected':'') ?>>Admin</option>
				</select>
			</div>
			<div class="form-group col-md-6 text-right">
				<a href="users.php" class="btn btn-default">Cancel</a>
				<input type="submit" value="Add User" class="btn btn-primary">
			</div>
		</form>
		<?php
	} elseif(isset($_GET['edit'])){
		$user_id = sanitize($_GET['edit']);
		$user_id = (int)$user_id;
		$editQuery = $db->query("SELECT * FROM users WHERE id = '$user_id'");
		$currentUser = mysqli_fetch_assoc($editQuery);
		$errors = array();
		$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
		$email = ((isset($_POST['name']))?sanitize($_POST['email']):'');
		if($_POST){
			if($name == '' || $email == ''){
				$errors[] = 'You must fill in a name and e-mail address.';
			}
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors[] = 'You must enter a valid email address';
			}
			if (!empty($errors)){
				echo display_errors($errors);
			} else {
				# Update user in database
				$updateQuery = $db->query("UPDATE users SET full_name='$name', email='$email' WHERE id='$user_id'");
				$_SESSION['success_flash'] = 'User successfully updated!';
				header('Location: users.php');
			}
		}

		?>
		<div class="col-md-4 col-md-offset-4">
			<h2>Edit User</h2><hr>
			<form action="users.php?edit=<?=$user_id;?>" method="post">
				<div class="form-group">
					<label for="name">Full Name:</label>
					<input type="text" name="name" id="name" class="form-control" value="<?=((isset($_POST['name']) && $_POST['name'] != '')?$name : $currentUser['full_name']);?>">
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" name="email" id="email" class="form-control" value="<?=((isset($_POST['email'])&& $_POST['email'] != '')?$email : $currentUser['email']);?>">
				</div>
				<div class="form-group">
					<a href="users.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="Edit User" class="btn btn-primary">
				</div>
			</form>
		</div>

		<?php
	} else{ //everything else

	$userQuery = $db->query("SELECT * FROM Users ORDER BY full_name");
?>
<h2>Users</h2>
<a href="users.php?add=1" class="btn btn-success pull-right" id="add-product-button">Add New User</a><hr>
<table class="table table-bordered table-striped table-condensed">
	<thead>
		<th></th><th>Name</th><th>Email</th><th>Join Date</th><th>Last Login</th><th>Permissions</th>
	</thead>
	<tbody>
		<?php while($user = mysqli_fetch_assoc($userQuery)) : ?>
			<tr>
				<td>
					<?php if($user['id'] != $user_data['id']): ?>
						<a href="users.php?delete=<?=$user['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
						<a href="users.php?edit=<?=$user['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
					<?php endif; ?>
				</td>
				<td><?=$user['full_name'];?></td>
				<td><?=$user['email'];?></td>
				<td><?=pretty_date($user['join_date']);?></td>
				<td><?=(($user['last_login'] == '0000-00-00 00:00:00')?'Never':pretty_date($user['last_login']));?></td>
				<td><?=$user['permissions'];?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>
<?php } include("includes/footer.php");