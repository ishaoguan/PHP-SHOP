<?php
$db = mysqli_connect('localhost','root','joey123','php-shop');
if (mysqli_connect_errno()) {
	echo 'Database connection failed with following errors: ' . mysqli_connect_error();
	die();
}
session_start();
//BASEURL = $_SERVER['DOCUMENT_ROOT'].'/PHP-SHOP/
require_once $_SERVER['DOCUMENT_ROOT'].'/PHP-SHOP/config.php';
require_once BASEURL.'helpers/helpers.php';
require BASEURL.'vendor/autoload.php';

# $_COOKIE[CART_COOKIE] is set to the value of the cart id when it's created
$cart_id = '';
if(isset($_COOKIE[CART_COOKIE])){
	# hence why we set $cart_id = to cookie id, allowing us to refer to the cart_id anywhere
	$cart_id = sanitize($_COOKIE[CART_COOKIE]);
}

//Store the user information using session variables when they log in
if(isset($_SESSION['SBUser'])){
	$user_id = $_SESSION['SBUser'];
	$query = $db->query("SELECT * FROM users WHERE id= '$user_id'");
	$user_data = mysqli_fetch_assoc($query);

	//Check if the full name contains a space, if so split it up into 2 names
	if(strpos($user_data['full_name'], " ") !== false) {
		$fn = explode(' ', $user_data['full_name']);
		$user_data['first'] = $fn[0];
		$user_data['last'] = $fn[1];
	} else {
		$user_data['first'] = $user_data['full_name'];
		$user_data['last'] = $user_data['full_name'];
	}
}

if(isset($_SESSION['success_flash'])){
	echo '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
	unset($_SESSION['success_flash']);
}

if(isset($_SESSION['error_flash'])){
	echo '<div class="bg-danger"><p class="text-danger text-center">' . $_SESSION['error_flash'] . '</p></div>';
	unset($_SESSION['error_flash']);
}