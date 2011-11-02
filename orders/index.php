<?php
include '../ariel.inc.php'; 
open_db();
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
	foreach(get_orders() as $order) {
		$grandTotal += $order['total'];
		print_order($order);
	}
	
	echo "<p>Grand Total: $$grandTotal</p>";
	
	mysql_close();
?>
</body>
</html>
