<?php

include 'ariel.inc.php'; 
open_db();

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
	insert_order($order);
} else {
	echo "<p>You didn't order anything, or you didn't enter a name!</p>";
}
mysql_close();
?>
</body>
</html>
