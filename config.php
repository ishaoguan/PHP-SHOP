<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/PHP-SHOP/');
define('CART_COOKIE', 'SBwi72Ucklai1u2jd');
//now plus 30 days in seconds
define('CART_COOKIE_EXPIRE',time() + (86400 * 30));
define('TAXRATE',0.2);

define('CURRENCY','gbp');
define('CHECKOUTMODE','TEST'); //Change TEST to LIVE when ready to go live

if(CHECKOUTMODE == 'TEST'){
	define('STRIPE_PRIVATE','sk_test_RvkmG3iB4BAOApgOlGCItJiT');
	define('STRIPE_PUBLIC','pk_test_O0vbv9HfU6zKI5ll67NaxdgQ');
} 
if(CHECKOUTMODE == 'LIVE'){
	define('STRIPE_PRIVATE','sk_live_dsuQqyTsbrxiwZbwcdjI97Bi');
	define('STRIPE_PUBLIC','pk_live_V0uGzb0AwIZsZpCmY2wOZmOd');
}
?>