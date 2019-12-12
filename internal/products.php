<?php 
$sql = "select * from product";
if( $stmt = $mysqli->prepare($sql) ) {
	$stmt->execute();
	$books = $stmt->get_result();
}

foreach ($books as $index => $row) {
	var_dump($row);
	echo '<br/>';
	echo '<br/>';
}
?>