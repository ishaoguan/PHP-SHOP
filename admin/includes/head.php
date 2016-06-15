<?php
require_once '../core/init.php';
$themeQ = $db->query("SELECT id, css FROM theme WHERE selected=1");
$theme = mysqli_fetch_assoc($themeQ);

if(isset($_GET['t'])){
		$theme_id = (int)$_GET['t'];
		$remove_old_theme = $db->query("UPDATE theme SET selected=0 WHERE selected=1");
		$set_new_theme = $db->query("UPDATE theme SET selected=1 WHERE id='$theme_id'");
		$get_new_name = $db->query("SELECT name FROM theme WHERE selected=1");
		$new_theme = mysqli_fetch_assoc($get_new_name);
		header("Location: index.php");

		$_SESSION['success_flash'] = 'The theme has been changed to '.$new_theme['name'];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Administator</title>
	<!--Bootstrap Stylesheet-->
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">

	<!--Custom Stylesheet-->
	<link rel="stylesheet" type="text/css" href="../css/main.css">

	<!--Custom Stylesheet-->
	<link rel="stylesheet" type="text/css" href="../<?=$theme['css'];?>">

	<!--Reposive Meta Tag-->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<!--jQuery CDN-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

	<!--Bootstrap JS-->
	<script src="../js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid">