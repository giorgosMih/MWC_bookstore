<div class="cart">
<h2>Shopping Cart</h2>
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

		
?> 
<table class="table">
<tbody>
<tr>
<td></td>
<td>ITEM NAME</td>
<td>QUANTITY</td>
<td>UNIT PRICE</td>
<td>ITEMS TOTAL</td>
</tr> 
<?php 
foreach ($_SESSION["cart"] as $product => $q){
		$stmt->bind_param("i", $product);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$sum += ($q * $row['Price']);
		$c++;
?>
<tr>
<td>
<img src='<?php echo "img/".$row["image"]; ?>' width="50" height="40" />
</td>
<td><?php echo $row['Title']; ?><br />
<form method='post' action=''>
<input type='hidden' name='code' value="<?php echo $row['ID']; ?>" />
<input type='hidden' name='action' value="remove" />
<button type='submit' class='remove'>Remove Item</button>
</form>
</td>
<td>

	<input id='qty' type='number' min='1' step='1' value='<?=$q ?>' name='qty' onclick="myFunction(<?=$row['ID']?>, this);">
</td>
<td><?php echo "&euro;".$row['Price']; ?></td>
<td><?php echo "&euro;".$q * $row['Price']; ?></td>
</tr>
<?php
}
$stmt->close();
?>
<tr>
<td colspan="5" align="right">
<strong>TOTAL: <?php echo "&euro;".$sum; ?></strong>
</td>
</tr>
</tbody>
</table> 
  <?php
?>
</div>
 
<div style="clear:both;"></div>

<?php if(isset($status)):?>
<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>
<?php endif;?>

<?php
		if($c==0) {
			print "<tr><td colspan='3'>Your shopping cart is empty :-(</td></tr>";
		}
		 
		if($c>0){
				print "<a href='?p=buy_cart' class='btn btn-primary'>Check out</a>
				<a href='?p=empty_cart' class='btn btn-primary'>Clear cart</a>	";
		}
	}
?>
<script>

var xmlhttp;
function add_cart(e, pid) {
	
	e.preventDefault()
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = showresponse;
	var a = document.getElementById('qty').value;
	xmlhttp.open("GET","ajax/add_cart.php?pid="+pid+"&qty="+a,true);
	xmlhttp.send();
}

function myFunction(id, elem) {
	window.location="index.php?p=update_cart&product=" + id + "&q=" + elem.value;
	
}
</script>
<?php
if (isset($_POST['action']) && $_POST['action']=="remove"){
	if(!empty($_SESSION["cart"])) {
		foreach($_SESSION["cart"] as $key => $value) {
		  if($_POST["code"] == $key){
		  	unset($_SESSION["cart"][$key]);
		  	$status = "<div class='box' style='color:red;'>
		  	Product is removed from your cart!</div>";
		  	echo '<script>window.location.reload(true);</script>';
		  }
		  if(empty($_SESSION["cart"]))
		  	unset($_SESSION["cart"]);
		} 
	}
}
?>
