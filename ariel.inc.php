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
	
	$orders_db = mysql_query('select * from orders');
	$orders = array();
	
	while($order = mysql_fetch_assoc($orders_db)) {
		$order['items'] = array();
	
		$order_items_db = mysql_query(sprintf('select * from order_items where order_items.order = %s', $order['id']));
		$order_items = array();
		while($order_item = mysql_fetch_assoc($order_items_db)) {
			$order_items[$order_item['product']] = $order_item;
		}
		
		foreach(get_products() as $name => $product) {
			$item = array('product' => $product['id'],
						  'amount' => 0,
						  'subtotal' => 0,
						  'type' => 'NULL');
			if( isset($order_items[$product['id']]) ) {
				$item['amount'] = $order_items[$product['id']]['amount'];
				$item['subtotal'] = $order_items[$product['id']]['subtotal'];
			}
			if( count($product['types']) > 0 ) {
				$item['type'] = $order_items[$product['id']]['type'];
				if( isset($order_items[$product['id']]) ) {
					$item['type'] = $order_items[$product['id']]['type'];
				}
				$item['type_name'] = $product['types'][$item['type']]['name'];
			}
			
			$order['items'][$name] = $item;
		}
		array_push($orders, $order);
	}
	
	return $orders;
}

function get_products() {
	
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
	
	return $products;
}

function process_order() {
	$products = get_products();
	
	$order = array('customer' => $_POST['customer'],
				   'subtotal' => 0,
				   'items' => array());
	//if no name
	if( empty($order['customer']) ) { return false; }
	foreach(get_products() as $name => $product) {
		$item = array('product' => $product['id'],
		              'amount' => $_POST["product-".$product['id']]);
		$item['type'] = 'NULL';
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
	$order['tax'] = round($order['subtotal'] * $tax, 2);
	$order['total'] = $order['subtotal'] + $order['tax'];
	
	return $order;
}

function print_order($order) {
	printf("<p>%s ordered:</p>\n", $order['customer']);
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

function insert_order($order) {
	$order_insert = sprintf("insert into orders (customer, subtotal, tax, total) values('%s',%s,%s,%s)",
	                    $order['customer'],
						$order['subtotal'],
						$order['tax'],
						$order['total']);
	if (!mysql_query($order_insert)) {
		die('Error: ' . mysql_error());
	}
	$order_id = mysql_fetch_assoc(mysql_query("SELECT LAST_INSERT_ID(id) as last from orders order by id desc limit 1"));
	
	foreach( $order['items'] as $name => $item) {
		if( $item['amount'] > 0 ) {
			$item_insert = sprintf("insert into order_items (`order`, product, type, amount, subtotal) values(%s,%s,%s,%s,%s)",
								$order_id['last'],
								$item['product'],
								$item['type'],
								$item['amount'],
								$item['subtotal']);
			if (!mysql_query($item_insert)) {
				die('Error: ' . mysql_error());
			}
		}
	}
}

?>