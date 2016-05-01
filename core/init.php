<?php
$db = mysqli_connect('localhost','root','joey123','tutorial');
if (mysqli_connect_errno()) {
	echo 'Database connection failed with following errors: ' . mysqli_connect_error();
	die();
}
require_once $_SERVER['DOCUMENT_ROOT'].'/phpEcommerce/config.php';
require_once BASEURL.'helpers/helpers.php';