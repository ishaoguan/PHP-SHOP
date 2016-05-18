<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/phpEcommerce/core/init.php';
	# $_POST fields are sent via AJAX from the function add_to_cart in the footer
	$product_id = sanitize($_POST['product_id']);
	$size = sanitize($_POST['size']);
	$available = sanitize($_POST['available']);
	$quantity = sanitize($_POST['quantity']);
	$item = array();
	$item[] = array(
		'id' => $product_id,
		'size' => $size,
		'quantity' => $quantity
	);

	//$domain = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);
	$domain = false;
	$query = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
	$product = mysqli_fetch_assoc($query);
	$_SESSION['success_flash'] = $product['title'].' was added to your cart.';

	// check to see if the cart cookie exists
	if($cart_id != ''){
		# select the current cart
		$cartQ = $db->query("SELECT * FROM cart WHERE id='{$cart_id}'");
		$cart = mysqli_fetch_assoc($cartQ);
		# split the existing items up so they can be looped for checks
		$previous_items = json_decode($cart['items'],true);
		$item_match = 0;
		$new_items = array();
		// loop through existing items to check if the current product being added to the cart already exists
		foreach($previous_items as $pitem){
			//if product id/size we're adding is the same as current previous item in loop
			if($item[0]['id'] == $pitem['id'] && $item[0]['size'] == $pitem['size']){
				//increment the quantity by however many the user selected
				$pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity'];
				//if the new total quantity is greater than the available amount
				if($pitem['quantity'] > $available){
					//set quantity to however many are available to stop them going over that amount.
					$pitem['quantity'] = $available;
				}
				$item_match = 1;
			}
			//add current previous item to the new_item array
			$new_items[] = $pitem;
		}
		if($item_match != 1){
			// set new items array to current item + all the previous items
			$new_items = array_merge($item,$previous_items);
		}
		# put the item into json format before entering into db
		$items_json = json_encode($new_items);
		$cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
		$db->query("UPDATE cart SET items = '$items_json', expire_date = '$cart_expire' WHERE id='$cart_id'");
		//destroy old cookie
		setcookie(CART_COOKIE,'',1,"/",$domain,false);
		//set new cookie
		setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
	}else{ //A cookie hasn't been set so a new cart and a cookie needs to be created
		//add the cart to the database and set cookie

		# put the item into json format before entering into db
		$items_json = json_encode($item);
		$cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
		$db->query("INSERT INTO cart (items, expire_date) VALUES ('{$items_json}','{$cart_expire}')");
		# set cart id to the id of the row added to the database
		$cart_id = $db->insert_id;
		# $cart_id is the cookie value so it's unique to each cart/cookie
		setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
	}

	?>