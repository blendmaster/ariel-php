<?php

$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

$prices = array("whosits" => 2.24, "whatsits" => 4.99, "thingamabobs" => 2.98);
$wo = $prices["whosits"];
$wa = $prices["whatsits"];
$th = $prices["thingamabobs"];

$taxRate = 0.08;
?>
<!doctype html>
<html>
<head>
<title>Ariel's Cove of Tchotchkes - Order Complete</title>
</head>
<body>
<h1>Ariel's Cove of Tchotchkes</h1>
<?php 
if( ($log = fopen("$DOCUMENT_ROOT/unit5/orders/orders.csv", 'a')) !== FALSE ) {

$name = $_POST['name'];
$whosits = $_POST['whosits']; $whoSubtotal = $whosits * $prices["whosits"];
$whatsits = $_POST['whatsits']; $whaSubtotal = $whatsits * $prices["whatsits"];
$thingamabobs = $_POST['thingamabobs']; $thiSubtotal = $thingamabobs * $prices["thingamabobs"];
$thingtype = $_POST['thingtype']; 
$quantityTotal = $whosits + $whatsits + $thingamabobs;
$taxTotal = round(($thiSubtotal + $whaSubtotal + $whoSubtotal) * $taxRate,2);
$total = round(($thiSubtotal + $whaSubtotal + $whoSubtotal) * (1.0 + $taxRate),2);

$now = date("D, d M Y H:i:s");

if( $quantityTotal !== 0 && !empty($name)) {
fputcsv($log, array($now, $name, $whosits, $whatsits, $thingamabobs, $thingtype));

echo <<<OUTPUT
<h2>Order Complete</h2>
<p>On $now, $name ordered:</p>
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
			<td>&#36;$wo</td>
			<td>
				$whosits
			</td>
			<td></td>
			<td>&#36;$whoSubtotal</td>
		</tr>
		<tr>
			<td>Whatsits</td>
			<td>&#36;$wa</td>
			<td>
				$whatsits
			</td>
			<td></td>
			<td>&#36;$whaSubtotal</td>
		</tr>
		<tr>
			<td>Thingamabobs</td>
			<td>&#36;$th</td>
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
	<p>You'd think you're the girl who has everything, but who cares; no big deal; now you have more.</p>
OUTPUT;
} else {
	echo "<p>You didn't order anything, or you didn't enter a name!</p>";
}
fclose($log);
} else {
	echo "<p>Error reading orders file!</p>";
}
?>
</body>
</html>
