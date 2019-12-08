<?php

require "../internal/dbconnect.php";
session_start();

if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin']==0) {
	die("You are not admin");
}
$sql = 'SELECT *,O.ID as OID,C.ID as CID FROM orders O INNER JOIN  `customer` C ON O.Customer = C.ID';

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$res = $stmt->get_result();
print "<ol>";


$sql2 = 'SELECT * , Quantity * Price AS TotalPrice FROM  `orderdetails` O INNER JOIN product P ON O.Product = P.ID WHERE Orders =?';

$stmt2 = $mysqli->prepare($sql2);

while($row = $res->fetch_assoc()) {
	print "<li>OrderID: $row[OID], Date: $row[oDate], Customer: $row[Fname] $row[Lname]\n";
	$stmt2->bind_param('i',$row['OID']);
	$stmt2->execute();
	$res2 = $stmt2->get_result();
	print "<ol>";
	while($row2 = $res2->fetch_assoc()) {
		print "<li>$row2[Title]: $row2[Quantity] x $row2[Price] &euro; = $row2[TotalPrice] &euro;</li>\n";
	}
	print "</ol>";
}
print "</ol>";
?>
