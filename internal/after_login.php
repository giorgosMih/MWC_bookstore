<?php
if($_SESSION['is_admin']){
	print "Welcome $_SESSION[username]";
}
else{
	header('Location: index.php');
}
?>