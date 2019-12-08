<?php

if(!is_array($_SESSION['cart'])) {
	$_SESSION['cart']=array();
}
buy_cart();
function buy_cart() {
	global $mysqli;
	
	if(! $_SESSION['userid']) {
		print "Δεν έχετε κάνει <a href='?p=login'>login</a>.";
		return;
	} 
	if( count($_SESSION['cart'])==0) {
		print "Το καλάθι είναι άδειο!!!! Γέμισέ το πρώτα...";
		return;
	}
	$sql = "select * from product where ID=?";
	$stmt = $mysqli->prepare($sql);
	$s=0;
	$c=0;

	$sql2 = "insert into orders(Customer,oDate) values(?,now())";
	$order_ins = $mysqli->prepare($sql2);
	$order_ins->bind_param("i", $_SESSION['userid']);
	$r = $order_ins->execute();
	if(! $r) {
		print "Έγινε κάποιο σφάλμα: ". $mysqli->error;
		return;
	}
	$order_id = $mysqli->insert_id;
	print "Έγινε εισαγωγή στο orders με order_id=$order_id<br>";
	$sql3 = "insert into orderdetails(Orders,Quantity,Product) values(?,?,?)";
	$order_det = $mysqli->prepare($sql3);
	
	foreach($_SESSION['cart'] as $p => $q) {
		$stmt->bind_param("i",$p);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		
		$order_det->bind_param("iii", $order_id, $q, $p);
		$r = $order_det->execute();
		if($r) {
			print "Έγινε εισαγωγή στο orderdetails το product:$p, quantity: $q, Name: $row[Title]<br>";
		} else {
			print "Έγινε κάποιο σφάλμα: ". $mysqli->error . '<br>';
		}
		
		
		$s += ($q * $row['Price']);
		$c++;
	}
	print "<br><b>$c Προιόντα προστέθηκαν στην παραγγελία με συνολικό κόστος $s &euro;</b>.";
	$_SESSION['cart'] = array();
}


	