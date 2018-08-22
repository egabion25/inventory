<!DOCTYPE html>
<html>
<head>
	<title>Kounta</title>
</head>
<body>

<?php 

$str = file_get_contents('orders-sample.json');
$orders = json_decode($str, true);


$inventory = Array( 1 => Array( 1 => 5, 2 => 5, 3 => 5, 4 => 5, 5 => 5 ) );


	include_once("store.php");
?>


</body>
</html>