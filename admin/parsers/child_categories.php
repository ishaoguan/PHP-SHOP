<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpEcommerce/core/init.php';
//$_POST['parentID'] is sent from the AJAX in the footer.php as data via POST method
$parentID = (int)$_POST['parentID'];
$selected = sanitize($_POST['selected']);
$childQuery = $db->query("SELECT * FROM categories WHERE parent = '$parentID' ORDER BY category");

//start a buffer
ob_start();
?>
	<option value=""></option>
	<?php while($child = mysqli_fetch_assoc($childQuery)): ?>
		<option value="<?=$child['id'];?>"<?= (($selected == $child['id'])?' selected':''); ?>><?=$child['category'];?></option>
	<?php endwhile; ?>


<?php echo ob_get_clean(); #this sends everything after the ob_start as data to the ajax request ?>