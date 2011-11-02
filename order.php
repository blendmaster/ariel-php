<?php

include 'ariel.inc.php'; 

function process_order() {
	$products = get_products();
	
	$order = array('time' => date("D, d M Y H:i:s"), 
	               'customer' => $_POST['customer'],
				   'subtotal' => 0,
				   'items' => array());
	//if no name
	if( empty($order['customer']) ) { return false; }
	foreach(get_products() as $name => $product) {
		$item = array('product' => $product['id'],
		              'amount' => $_POST["product-".$product['id']]);
		if( count($product['types']) > 0 ) {
			$item['type'] = $_POST["type-of-".$product['id']];
			$item['type_name'] = $product['types'][$item['type']]['name'];
		}
		$item['subtotal'] = $item['amount'] * $product['price'];
		$order['subtotal'] += $item['subtotal'];
		$order['items'][$name] = $item;
	}
	//if they didn't order anything
	if( $order['subtotal'] == 0 ) { return false; }
	
	global $tax;
	$order['tax'] = $order['subtotal'] * $tax;
	$order['total'] = $order['subtotal'] + $order['tax'];
	
	return $order;
}

function print_order($order) {
	printf("<p>On %s, %s ordered:</p>\n", $order['time'], $order['customer']);
	echo <<<OUTPUT
<table>
	<tr>
		<td>Item</td>
		<td>Price</td>
		<td>Quantity</td>
		<td>Type</td>
		<td>Subtotal</td>
	</tr>
OUTPUT;
	foreach(get_products() as $name => $product) {
		$id = $product['id'];
		echo "		<tr>\n";
		echo "			<td>$name</td>\n";
		printf("			<td>$%s</td>\n", $product['price']);
		printf("			<td>%s</td>\n", $order['items'][$name]['amount']);
		if( count($product['types']) > 0 ) {
			printf("<td>%s</td>", $order['items'][$name]['type_name']);
		} else {
			echo "<td></td>";
		}
		printf("<td>$%s</td>", $order['items'][$name]['subtotal']);
		echo "		</tr>\n";
	}
	printf(<<<OUTPUT
	<tr>
		<td>Subtotal</td>
		<td></td>
		<td></td>
		<td></td>
		<td>$%s</td>
	</tr>
	<tr>
		<td>Tax</td>
		<td></td>
		<td></td>
		<td></td>
		<td>$%s</td>
	</tr>
	<tr>
		<td>Total</td>
		<td></td>
		<td></td>
		<td></td>
		<td>$%s</td>
	</tr>
</table>
OUTPUT
	, $order['subtotal'], $order['tax'], $order['total']);
}
?>
<!doctype html>
<html>
<head>
<title>Ariel's Cove of Tchotchkes - Order Complete</title>
</head>
<body>
<h1>Ariel's Cove of Tchotchkes</h1>
<?php 
if( $order = process_order() ) {
	print_order($order);
} else {
	echo "<p>You didn't order anything, or you didn't enter a name!</p>";
}
?>
</body>
</html>
