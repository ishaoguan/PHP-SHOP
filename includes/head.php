<?php
require_once 'core/init.php';
$themeQ = $db->query("SELECT id, css FROM theme WHERE selected=1");
$theme = mysqli_fetch_assoc($themeQ);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Shaunta's Boutique</title>
	<!--Bootstrap Stylesheet-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

	<!--Custom Stylesheet-->
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<!--Custom Theme-->
	<link rel="stylesheet" type="text/css" href="<?=$theme['css'];?>">

	<!-- Slideshow plugin -->
	<link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">

	<!--Reposive Meta Tag-->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<!--jQuery CDN-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

	<script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

	<!--Bootstrap JS-->
	<script src="js/bootstrap.min.js"></script>

	<script src="https://js.stripe.com/v2/"></script>
</head>
<body>