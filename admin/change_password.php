<?php
	require_once '../core/init.php';
	if(!is_logged_in()){
		login_error_redirect();
	}
	include 'includes/head.php';

	$hashed = $user_data['password'];
	$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
	$old_password = trim($old_password);
	$old_hashed = password_hash($old_password,PASSWORD_DEFAULT);
	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$password = trim($password);
	$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
	$confirm = trim($confirm);
	$new_hashed = password_hash($password,PASSWORD_DEFAULT);
	$errors = array();
?>


<div id="login-form">
	<!--This div is where we want the errors to be printed-->
	<div>
		
	<?php
		if($_POST){
			# FORM VALIDATION #
			if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
				$errors[] = 'Please fill in all 3 fields';
			} elseif(!password_verify($old_password, $hashed)) {
				$errors[] = 'The old password you entered is incorrect, please try again.';
			} else

			// new password has to be more than 6 characters
			if(strlen($password) < 6){
				$errors[] = 'New password must be at least 6 characters.';
			}

			// new password matches confirmed
			if($password != $confirm){
				$errors[] = 'The new password does not match with the confirmed password.';
			}

			// check if new password is the same as old password
			if($old_password == $password){
				$errors[] = 'Your new password must be different from your old password.';
			}

			// check for errors
			if(!empty($errors)){
				echo display_errors($errors);
			} else {
				$user_id = $user_data['id'];
				//change password
				$db->query("UPDATE users SET password = '$new_hashed', last_password = '$old_hashed', date_password_changed = now() WHERE id = '$user_id'");
				$_SESSION['success_flash'] = 'Your password has been updated!';
				header('location: index.php');
			}
		}
	?>

	</div>
	<h2 class="text-center">Change Password</h2><hr>
	<form action="change_password.php" method="post">
		<div class="form-group">
			<label for="old_password">Old Password:</label>
			<input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
		</div>
		<div class="form-group">
			<label for="password">New Password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>
		<div class="form-group">
			<label for="confirm">Confirm New Password:</label>
			<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
		</div>
		<div class="form-group">
			<a href="index.php" class="btn btn-default">Cancel</a>
			<input type="submit" value="Change Password" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/phpEcommerce/index.php" alt="home">Visit Site</a></p>
</div>

<?php include 'includes/footer.php'; ?>