<?php

$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

$taxRate = 0.08;

$prices = array("whosits" => 2.24, "whatsits" => 4.99, "thingamabobs" => 2.98);

$grandTotal = 0;

?>
<!doctype html>
<html>
<head>
<title>Ariel's Cove of Tchotchkes - Order History</title>
</head>
<body>
<h1>Ariel's Cove of Tchotchkes</h1>
<h2>Order History</h2>
<?php 
if( ($log = fopen("$DOCUMENT_ROOT/unit5/orders/orders.csv", 'r')) !== FALSE ) {

$orders = array();

while (($data = fgetcsv($log)) !== FALSE) {
	$orders[$data[1]][] = $data;
}

ksort($orders);

foreach ($orders as $customer => $corders) {
	echo "<h3>Customer $customer</h3>";
	foreach( $corders as $order ) {
	
	$name = $order[1];
	$whosits = $order[2]; $whoSubtotal = $whosits * $prices["whosits"];
	$whatsits = $order[3]; $whaSubtotal = $whatsits * $prices["whatsits"];
	$thingamabobs = $order[4]; $thiSubtotal = $thingamabobs * $prices["thingamabobs"];
	$thingtype = $order[5]; 
	$quantityTotal = $whosits + $whatsits + $thingamabobs;
	$taxTotal = round(($thiSubtotal + $whaSubtotal + $whoSubtotal) * $taxRate,2);
	$total = round(($thiSubtotal + $whaSubtotal + $whoSubtotal) * (1.0 + $taxRate),2);

	$grandTotal = $grandTotal + $total;

	$then = $order[0];


echo <<<OUTPUT
<p>On $then, you ordered:</p>
<table>
		<tr>
			<td>Item</td>
			<td>Price</td>
			<td>Quantity</td>
			<td>Type</td>
			<td>Subtotal</td>
		</tr>
		<tr>
			<td>Whosits</td>
			<td>&#36;2.24</td>
			<td>
				$whosits
			</td>
			<td></td>
			<td>&#36;$whoSubtotal</td>
		</tr>
		<tr>
			<td>Whatsits</td>
			<td>$4.99</td>
			<td>
				$whatsits
			</td>
			<td></td>
			<td>&#36;$whaSubtotal</td>
		</tr>
		<tr>
			<td>Thingamabobs</td>
			<td>$2.98</td>
			<td>
				$thingamabobs
			</td>
			<td>
				$thingtype
			</td>
			<td>&#36;$thiSubtotal</td>
		</tr>
		<tr>
			<td>Tax</td>
			<td></td>
			<td></td>
			<td></td>
			<td>&#36;$taxTotal</td>
		</tr>
		<tr>
			<td>Total</td>
			<td></td>
			<td>$quantityTotal</td>
			<td></td>
			<td>&#36;$total</td>
		</tr>
	</table>
OUTPUT;
}
}
if( $grandTotal !== 0 ) {
	echo "<p>These orders cost a total of &#36;$grandTotal.</p>";
} else {
	echo "<p>No orders so far!</p>";
}
fclose($log);
} else {
	echo "<p>Error reading orders file!</p>";
}
?>
</body>
</html>
