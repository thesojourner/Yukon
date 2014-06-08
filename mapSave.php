<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$mapJson = $_POST["map"];
	$map = json_decode($mapJson);
	$size = count($map);

	for ($y=0; $y < $size; $y++) {
		for ($x=0; $x < $size; $x++) {
			print($map[$x][$y] . " ");
		}
		print("<BR>");
	}
}
?>
