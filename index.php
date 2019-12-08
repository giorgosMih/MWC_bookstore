<!doctype html>
<html lang="en">
<?php
session_start();
require_once "internal/dbconnect.php";

if( ! isset($_SESSION['username'])) {
	$_SESSION['username']='?';
}
if( ! isset($_SESSION['is_admin'])) {
	$_SESSION['is_admin']=0;
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./favicon.ico">

    <title>Bookstore</title>

    <!-- Bootstrap core CSS -->
    <link href="./bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./bootstrap/dashboard.css" rel="stylesheet">
    <script src="./js/ajax.js"></script>
  </head>
<body>
    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Bookstore</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == '' || $_SERVER['QUERY_STRING'] == 'p=start') echo ' active';?>">
              <a class="nav-link" href="index.php?p=start">Home Page</a>
            </li>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == 'p=shopinfo') echo ' active';?>">
              <a class="nav-link" href="?p=shopinfo">About Us</a>
            </li>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == 'p=products') echo ' active';?>">
              <a class="nav-link" href="?p=products">Books</a>
            </li>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == 'p=cart') echo ' active';?>">
              <a class="nav-link" href="?p=cart">Shopping Cart</a>
            </li>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == 'p=login') echo ' active';?>">
              <a class="nav-link" href="?p=login">Login</a>
            </li>
             <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == 'p=contact') echo ' active';?>">
              <a class="nav-link" href="?p=contact">Contact Us</a>
            </li>        
			</ul>
        </div>
      </nav>
    </header>
<div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
          
	
<?php
	require "internal/menuleft.php";
	if($_SESSION['is_admin']) {
		print "<h3>Admin MENU</h3>";
		print <<<END
<ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link " href="javascript:show_customers()">Λίστα πελατών</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:show_orders()">Λίστα παραγγελιών</a>
            </li>
          </ul>
END;
	}
	if($_SESSION['username']!='?') {
		print "<h3>User MENU</h3>";
		print <<<END
<ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link " href="?p=myorders">Εμφάνιση παραγγελιών</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?p=myinfo">Στοιχεία πελάτη</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?p=logout">Logout</a>
            </li>
            
          </ul>
END;
	}
?>
</nav>
<main id='maincontent' role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php
if( ! isset($_REQUEST['p'])) {
	$_REQUEST['p']='start';
}
$p = $_REQUEST['p'];

$pages = array('start','shopinfo','login','do_login','after_login','logout','myinfo','contact','products','cart','catinfo','productinfo','add_cart','empty_cart','buy_cart');

$ok=false;
foreach($pages as $pp) {
	if($pp==$p) {
		require "internal/$p.php";
		$ok=true;
	}
}
if(! $ok) {
	print "Η σελίδα δεν υπάρχει";
}

?>
     </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./bootstrap/jquery-3.2.1.min.js"></script>
    <script src="./bootstrap/popper.min.js"></script>
    <script src="./bootstrap/bootstrap.min.js"></script>
  </body>
</html>
