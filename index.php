<?php

include 'ariel.inc.php'; 
open_db();
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
	<label for="customer">Your name: </label> <input type="text" name='customer' id='customer' />
	<table>
		<tr>
			<td>Item</td>
			<td>Price</td>
			<td>Quantity</td>
			<td>Type</td>
		</tr>
<?php
			foreach(get_products() as $name => $product) {
				$id = $product['id'];
				echo "		<tr>\n";
				echo "			<td>$name</td>\n";
				printf("			<td>$%s</td>\n", $product['price']);
				echo "			<td><input type='number' name='product-$id' id='product-$id' value='0' min='0' /></td>\n";
				if( count($product['types']) > 0 ) {
					echo "			<td>\n				<select name='type-of-$id' id='type-of-$id'>\n";
					foreach($product['types'] as $type) {
						$type_name = $type['name'];
						$type_id = $type['id'];
						echo "					<option value='$type_id'>$type_name</option>\n";
					}
					echo "				</select>\n			</td>\n";
				}
				echo "		</tr>\n";
			}
			mysql_close();
?>
	</table>
	<input type="reset" /><input type="submit" />
</form>

</body>
</html>