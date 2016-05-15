<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/phpEcommerce/core/init.php';
	include 'includes/head.php';

	$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
	$email = trim($email);
	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$password = trim($password);
	$errors = array();
?>

<style>
	body{
		background-image:url("/phpEcommerce/images/headerlogo/background.png");
		background-size:cover;
	}
</style>
<div id="login-form">
	<!--This div is where we want the errors to be printed-->
	<div>
		
	<?php
		if($_POST){
			# FORM VALIDATION #
			if(empty($_POST['email']) || empty($_POST['password'])){
				$errors[] = 'You must provide email and password.';
			}

			// validate email
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors[] = 'You must enter a valid email';
			}

			// password is more than 6 characters
			if(strlen($password) < 6){
				$errors[] = 'Password must be at least 6 characters.';
			}

			// check if user exists in db
			$query = $db->query("SELECT * FROM users WHERE email = '$email'");
			$user = mysqli_fetch_assoc($query);
			$userCount = mysqli_num_rows($query);
			if ($userCount == 0){ //Doesn't exist
				$errors[] = 'That email doesn\'t exist in our database';
			} 

			// check if they entered their previous password.
			if(password_verify($password, $user['last_password'])){
				$date_password_changed = $user['date_password_changed'];
				$errors[] = "You entered an old password. <br> Date of previous password change: $date_password_changed";
			}

			// compare the password entered in the form with the password in the database corresponding to that email
			elseif(!password_verify($password, $user['password'])) {
				$errors[] = 'That password does not match our records, please try again.';
			}

			
			//check for errors
			if(!empty($errors)){
				echo display_errors($errors);
			} else {
				//log user in
				$user_id = $user['id'];

				//Pass user id through to login function so it can be set as $_SESSION variable
				login($user_id);
			}
		}
	?>

	</div>
	<h2 class="text-center">Login</h2><hr>
	<form action="login.php" method="post">
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>
		<div class="form-group">
			<input type="submit" value="Login" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/phpEcommerce/index.php" alt="home">Visit Site</a></p>
</div>

<?php include 'includes/footer.php'; ?>