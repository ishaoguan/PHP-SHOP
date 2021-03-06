<?php

function display_errors($errors){
	$display = '<ul class="bg-danger">';
	foreach($errors as $error){
		$display .= '<li class="text-danger">' . $error . '</li>';
	}
	$display .= '</ul>';
	return $display;
}

function sanitize($dirty){
	return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}

function money($number){
	return '£'.number_format($number,2);
}

function login($user_id){
	$_SESSION['SBUser'] = $user_id;
	//access the database connection
	global $db;
	//Update the last login field in the users account
	$date = date("Y-m-d H:i:s");
	$db->query("UPDATE users SET last_login='$date'
		WHERE id='$user_id'");
	$_SESSION['success_flash'] = 'You are now logged in!';
	header('Location: index.php');
}

//return true if the user is logged in
function is_logged_in(){
	if(isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0){
		return true;
	} else {
		return false;
	}
}

//Set the error message for members only pages and set a default relocate value (which can be changed if a different url is passed through as an argument)
function login_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'You must be logged in to access that page';
	header('Location: '.$url);
}

function permission_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'You do not have permission to access that page';
	header('Location: '.$url);
}

function has_permission($permission = 'admin'){
	global $user_data;
	$permissions = explode(',',$user_data['permissions']);
	if(in_array($permission,$permissions,true)){
		return true;
	} else {
		return false;
	}
}

function pretty_date($date){
	return date("M d, Y h:i A",strtotime($date));
}

function get_category($child_id) {
	global $db;
	$id = sanitize($child_id);
	$sql = "SELECT p.id AS 'pid', p.category AS 'parent', c.id AS 'cid', c.category AS 'child'
			FROM categories c
			INNER JOIN categories p
			ON c.parent = p.id
			WHERE c.id = '$id'";
	$query = $db->query($sql);
	$category = mysqli_fetch_assoc($query);
	return $category;
}

# In the products table, the sizes are stored as a string with the format "small:3, medium:1"
# This function converts that string into a key value array by splitting each s/q combination into separate array items
# Then splitting the s/q combination into a key value pair of size => s and quantity => q
function sizesToArray($string){
	$sizesArray = explode(', ',$string);
	$returnArray = array();
	foreach($sizesArray as $size){
		$s = explode(':',$size);
		$returnArray[] = array('size' => $s[0], 'quantity' => $s[1]);
	}
	return $returnArray;
}

# This function produces the reverse of sizesToArray function by turning the array into a string
# It loops through each array item and adds the size followed by a ":" followed by quantity and then a comma on the end to separate each s/q combination.
function sizesToString($sizes){
	$sizeString = '';
	foreach ($sizes as $size){
		$sizeString .= $size['size'] .':'. $size['quantity'] .',';
	}
	$trimmed = rtrim($sizeString,',');
	return $trimmed;
}

# EXAMPLE USAGE:
# $a = sanitize_if_is_set('a','post');
# <form method="post"
# <input type="text" name="a" value="<?php echo $a; #closephp">
function sanitize_if_is_set($field, $method, $value_if_not_set = ''){
	if ($method == 'post'){
		if(isset($_POST[$field])){
			return sanitize($_POST[$field]);
		} else {
			return $value_if_not_set;
		}
	} elseif ($method == 'get'){
		if(isset($_GET[$field])){
			return sanitize($_GET[$field]);
		} else {
			return $value_if_not_set;
		}

	} elseif ($method == 'request'){
		if(isset($_REQUEST[$field])){
			return sanitize($_REQUEST[$field]);
		} else {
			return $value_if_not_set;
		}
	}
}

?>