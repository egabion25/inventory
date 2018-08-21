<!DOCTYPE html>
<html>
<head>
	<title>Kounta</title>
</head>
<body>

<?php 

$str = file_get_contents('orders-sample.json');
$orders = json_decode($str, true);

$inventory = array();




// echo "<pre>";
// print_r($json);
// echo "</pre>";
// die();

	include_once("store.php");
?>


</body>
</html>