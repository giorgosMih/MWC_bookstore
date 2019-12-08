<?php
if(!is_array($_SESSION['cart'])) {
 $_SESSION['cart']=array();
}
$pid = $_REQUEST['pid']; 
if(!isset($_SESSION['cart'][$pid])) {
	$_SESSION['cart'][$pid]=0;
}
$_SESSION['cart'][$pid] += $_REQUEST['qty']; 


print "The book has been added to your cart... <br>";

require "internal/cart.php";
?>