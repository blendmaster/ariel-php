<?php
$tax = 0.08;

function open_db() {
	$server = "localhost";
	$username = "ariel";
	$password = "ariel";
	$db = "ariel";

	if( mysql_connect($server, $username, $password) ) {
		mysql_select_db($db);
	} else {
		return false;
	}
}

function get_orders() {
	open_db();
	
	$orders = mysql_query('');
	
	mysql_close();
	return $orders;
}

function get_products() {
	open_db();
	
	$products_db = mysql_query('select * from products');
	$products = array();
	while($product = mysql_fetch_assoc($products_db)) {
		$types_db = mysql_query(sprintf('select * from types where types.product = %s', $product['id']));
		$types = array();
		while($type = mysql_fetch_assoc($types_db)) {
			$types[$type['id']] = $type;
		}
		
		$products[$product['name']] = array("price" => $product['price'],
                                            "types" => $types,
											"id" => $product['id']);
	}
	
	mysql_close();
	return $products;
}

?>