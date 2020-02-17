<?php
$prod_id=$_REQUEST["product"];
$q=$_REQUEST["q"];
$_SESSION['cart'][$prod_id]=$q;

header("Location: index.php?p=cart");
?>