<?php 
if(isset($_GET['search'])){
	$_SESSION['bookSearch']['category'] = "";
	$_SESSION['bookSearch']['author'] = "";
	$_SESSION['bookSearch']['priceFrom'] = "";
	$_SESSION['bookSearch']['priceTo'] = "";
	$_SESSION['bookSearch']['searchbox'] = $_GET['search'];
	header('Location: index.php?p=products');
}
die();
?>