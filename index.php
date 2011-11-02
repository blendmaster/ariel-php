<?php

include 'ariel.inc.php'; 

$pictures = array("ariel.png", "crab.png", "thingamabob.png", "whatsits.png", "whosit.png");
shuffle($pictures);
?>
<!doctype html>
<html>
<head>
<title>Ariel's Cove of Tchotchkes</title>
</head>
<body>
<h1>Ariel's Cove of Tchotchkes</h1>
<img src="images/<?php echo $pictures[0] ?>" />
<img src="images/<?php echo $pictures[1] ?>" />
<img src="images/<?php echo $pictures[2] ?>" />

<form action="order.php" method='post'>
	<label for="name">Your name: </label> <input type="text" name='name' id='name' />
	<table>
		<tr>
			<td>Item</td>
			<td>Price</td>
			<td>Quantity</td>
			<td>Type</td>
		</tr>
<?php
			foreach(get_products() as $name => $product) {
				echo "		<tr>\n";
				echo "			<td>$name</td>\n";
				echo sprintf("			<td>$%s</td>\n", $product['price']);
				echo "			<td><input type='number' name='$name' id='$name' value='0' min='0' /></td>\n";
				if( count($product['types']) > 0 ) {
					echo "			<td>\n				<select name='$name-type' id='$name-type'>\n";
					foreach($product['types'] as $type) {
						echo "					<option value='$type'>$type</option>\n";
					}
					echo "				</select>\n			</td>\n";
				}
				echo "		</tr>\n";
			}
?>
	</table>
	<input type="reset" /><input type="submit" />
</form>

</body>
</html>