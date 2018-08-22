<?php 
	include_once("src/Products.php");

	// inherits the products from procuct class
	$products_class = new ReflectionClass('Products');
	$products_class = $products_class->getConstants();

	// Re-instanciate the products array
	$products = array();
	foreach ($products_class as $key => $product_class) {	
		$products[$product_class] = array( "id" => $product_class,	 "name" => $key , "qty" => 5   );
	}

?>



<table class="products_table">

  <tr>
  	<th class="particulars">  PARTICULARS </th>
	<?php foreach ($products as $product) : ?>
		<th><?php echo $product["name"]; ?></th>
	<?php endforeach; ?>
  </tr>

  <?php

  	$orders = sum_orders_by_product( $orders );

	// echo "<pre>";
	// print_r($orders);
	// echo "</pre>";
	// die();

  	$row_class = 0;
  	foreach ($orders as $day => $order) {

  		if( $row_class ){
  			$row_class = "gray";
  		}

		// echo "<pre>";
		// print_r(	$order			);
		// echo "</pre>";
		// die();



	  	echo create_stock_row( $day+1, $row_class);
	  	echo create_orders_row( $day+1, $order, $row_class);
	  	echo create_current_stock_row( $day+1, $order, $row_class);
	  	echo create_replenishment_row( $day+1, $order, $row_class);


	  	$row_class = !$row_class;


	  	// break;

		// echo "<pre>";
		// print_r($inventory);
		// echo "</pre>";
		// die();

	// echo "<pre>";
	// print_r(	$orders	);
	// echo "</pre>";
	// die();



	  	
  	}





		// echo "<pre>";
		// print_r($inventory);
		// echo "</pre>";
		// die();

















  ?>



</table>

<?php


function sum_orders_by_product( $orders_array ){
	$sum_orders = array();
	foreach ($orders_array as $orders_today) {
		foreach ($orders_today as $order_today) {
			foreach ($order_today as $key => $ot) {
				if(	isset(	$x[$key]	 )	){
					$x[$key] = $x[$key] + $ot;	
				}else{
					$x[$key] = $ot;	
				}
			}
		}

		$sum_orders[] = $x;
		$x = array();
	}

	return $sum_orders;
}


function create_stock_row( $day,  $row_class=false){
	global $products, $inventory;
	$stock_row = "<tr class='". $row_class . "'>";
	$stock_row .=  "<td> Day-". $day ."&emsp; Stock</td>";
	for($i = 1; $i <= COUNT($products); $i++) {
		// $stock_row .= "<td>".  $products[$i]["qty"] ."</td>";
		$stock_row .= "<td>".  $inventory[$day][$i] ."</td>";

	// echo "<pre>";
	// print_r($inventory[$day]);
	// echo "</pre>";
	// die();
	
	}
	$stock_row .=  "</tr>";
	return $stock_row;
}





function create_current_stock_row( $day, $order, $row_class=false){

	// echo "<pre>";
	// print_r(	$order			);
	// echo "</pre>";
	// die();

	global $products, $inventory;
	$stock_row = "<tr class='". $row_class . "'>";
	$stock_row .=  "<td> Day-". $day ."&emsp; Remaining</td>";
		for($product_id = 1; $product_id <= COUNT($products); $product_id++) {
			
			if(	!isset($order[$product_id])	){
				$order[$product_id] = 0;
			}

			$remaining_stock = 	$products[$product_id]["qty"] - $order[$product_id];
			$stock_row .= "<td>".  $remaining_stock ."</td>";
			$product_states[$product_id] = $remaining_stock;

		}

		// echo "<pre>";
		// print_r(	$product_states			);
		// echo "</pre>";
		// die();

	$inventory[$day+1] = $product_states; 

	$stock_row .=  "</tr>";
	return $stock_row;
}


function create_orders_row( $day, $orders_today, $row_class=false){
	global $products, $inventory, $orders;
	$stock_row = "<tr class='". $row_class . "'>";
	$stock_row .=  "<td> Day-". $day ."&emsp; Customer Orders</td>";
	$cells = "";
		for($product_id = 1; $product_id <= COUNT($products); $product_id++) {

			if( !isset($orders_today[$product_id]) )
				$orders_today[$product_id] = 0;
			if( ($inventory[$day][$product_id] - $orders_today[$product_id]) >= 0  ){



					foreach ($orders[ $day] as $key => $order) {
							$orders[ $day][$key] = 0;
						// echo "<pre>";
						// print_r(		);
						// echo "</pre>";
						// die();
					}



				$cells .=  "<td>". $orders_today[$product_id]  ."</td>";
			}else{
				$cells .= "<td>". $orders_today[$product_id]  ." (cancelled / out-of-stock )  </td>";
			}
		}
	$stock_row .=  $cells;
	$stock_row .=  "</tr>";



	return $stock_row;
}

function create_replenishment_row( $day, $orders, $row_class=false){
	global $products,$inventory;

	// echo "<pre>";
	// print_r(		$inventory[$day]	);
	// echo "</pre>";
	// die();

	$stock_row = "<tr class='". $row_class . "'>";
	$stock_row .=  "<td> Day-". $day ."&emsp;	 Purchase Order</td>";
		for($i = 1; $i <= COUNT($inventory[$day]); $i++) {


			if( $inventory[$day][$i] < 10 ){
				$stock_row .= "<td>20 ( coming on day-" . ($day+2)  . ") </td>";
			}else{
				$stock_row .= "<td></td>";
			}

		}

		// $inventory[$day] = $product_states; 


	$stock_row .=  "</tr>";
	return $stock_row;
}




?>

<style type="text/css">
.products_table  {
	border-collapse:collapse;
	border-spacing:0;
}

.products_table th.particulars{
	    background: lightgray;
}

.products_table td{
	font-family:Arial, sans-serif;
	font-size:14px;
	padding:10px 5px;
	border-style:solid;
	border-width:1px;
	overflow:hidden;
	word-break:normal;
	border-color:black;
}

.products_table th{
	font-family:Arial, sans-serif;
	font-size:14px;
	font-weight:normal;
	padding:10px 5px;
	border-style:solid;
	border-width:1px;
	overflow:hidden;
	word-break:normal;
	border-color:black;
}

td{
	text-align:left;
	vertical-align:top;
}

tr.gray>td{
	background-color: #f1f1f1;
}

</style>