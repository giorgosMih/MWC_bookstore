<?php
$pid = $_REQUEST['pid'];
$sql = "select * from product where ID=?";


if( $stmt = $mysqli->prepare($sql) ) {
	$stmt->bind_param("i", $pid);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {
		print "<b>$row[Title]</b>".
		"<p>$row[Description]</p>".
		"<form onsubmit='add_cart(event, $row[ID])'>
			<input id='qty' type='number' min='1' step='1' value='1' name='qty'>
			<button type='submit' class='btn btn-primary' id='btn_add_cart'>Add to cart</button>
		</form>
		";
	}

}
?>


<div id='response'></div>
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

function showresponse() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("response").innerHTML = xmlhttp.responseText;
        }
}
</script>
