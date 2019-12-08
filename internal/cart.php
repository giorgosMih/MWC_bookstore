<h2>Shopping Cart</h2>
<table>
<?php
if(!is_array($_SESSION['cart'])) {
 $_SESSION['cart']=array();
}

	if( count($_SESSION['cart'])==0) {
		print "Your cart is empty!!!! Add some items first...";
		return;
	} else {
		$sql = "select * from product where ID=?";
		$stmt = $mysqli->prepare($sql);

		$sum=0;
		$c=0;
		foreach($_SESSION['cart'] as $p => $q) {
			 $stmt->bind_param("i", $p);
			 $stmt->execute();
			 $result = $stmt->get_result();
			 $row = $result->fetch_assoc();
			 print "<tr><td>$row[Title]  </td><td> $q * {$row['Price']}&euro; </td><td>=" . ($q * $row['Price']) . "&euro; </td></tr>";
			 $sum += ($q * $row['Price']);
			 $c++;
		}
		if($c==0) {
			print "<tr><td colspan='3'>Your shopping cart is empty :-(</td></tr>";
		}
		print "<tr><td>Total<td><td>$sum &euro;</td></tr></table>";
		 
		if($c>0){
				print "<a href='?p=buy_cart' class='btn btn-primary'>Check out</a>
				<a href='?p=empty_cart' class='btn btn-primary'>Clear cart</a>	";
		}
	}
?>



