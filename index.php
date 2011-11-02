<?php

$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

$prices = array("whosits" => 2.24, "whatsits" => 4.99, "thingamabobs" => 2.98);

$taxRate = 0.08;

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
<img src="<?php echo $pictures[0] ?>" /><img src="<?php echo $pictures[1] ?>" /><img src="<?php echo $pictures[2] ?>" />
<form action="order.php" method='post'>
	<label for="name">Your name: </label> <input type="text" name='name' id='name' />
	<table>
		<tr>
			<td>Item</td>
			<td>Price</td>
			<td>Quantity</td>
			<td>Type</td>
		</tr>
		<tr>
			<td>Whosits</td>
			<td>$<?php echo $prices["whosits"] ?></td>
			<td>
				<input type="number" name='whosits' id="whosits" value='0' min='0' />
			</td>
			<td></td>
		</tr>
		<tr>
			<td>Whatsits</td>
			<td>$<?php echo $prices["whatsits"] ?></td>
			<td>
				<input type="number" name='whatsits' id="whatsits" value='0' min='0' />
			</td>
			<td></td>
		</tr>
		<tr>
			<td>Thingamabobs</td>
			<td>$<?php echo $prices["thingamabobs"] ?></td>
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