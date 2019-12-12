<?php
print "Bye bye $_SESSION[username]. We hope we see you again.";
$_SESSION['username']='?';
$_SESSION['is_admin']=0;
$_SESSION['userid']='';
header('Location: index.php?p=login');
?>