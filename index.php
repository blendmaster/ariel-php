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

<?php
	foreach(get_products() as $name => $product) {
		$price = $product['price'];
		echo "<p>$name: $$price</p>";
	}
?>

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
				echo "<tr>";
				echo "	<td>$name</td>";
				echo sprintf("	<td>$%s</td>", $product['price']);
				echo "<td><input type='number' name='$name' id='$name' value='0' "
				echo "</tr>";
			}
		?>
		<tr>
			<td>Thingamabobs</td>
			<td>$</td>
			<td>
				<input type="number" name='thingamabobs' id="thingamabobs" value='0' min='0' />
			</td>
			<td>
			<select name="thingtype" id="thingtype">
				<option value="gadget">Gadget</option>
				<option value="gizmo">Gizmo</option>
			</select>
			</td>
		</tr>
	</table>
	<input type="reset" /><input type="submit" />
</form>

</body>
</html>