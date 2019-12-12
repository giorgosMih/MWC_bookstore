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
    <link href="./css/custom.css" rel="stylesheet">
    <script src="./js/ajax.js"></script>
  </head>
<body>
    <header>
      <nav class="navbar navbar-expand-<?php if($_SESSION['username']!='?') echo "lg"; else echo "md";?> navbar-dark fixed-top bg-info">
        <a class="navbar-brand" href="#">Bookstore</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto">
          <?php if($_SESSION['is_admin']):?>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == 'p=orders_manage') echo ' active';?>">
              <a class="nav-link" href="?p=orders_manage">Order Management</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?p=logout">Logout</a>
            </li>
          <?php else:?>
          <?php if($_SESSION['username']!='?'):?>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == '' || $_SERVER['QUERY_STRING'] == 'p=start') echo ' active';?>">
              <a class="nav-link" href="index.php?p=start">Home Page</a>
            </li>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == 'p=products') echo ' active';?>">
              <a class="nav-link" href="?p=products">All Books</a>
            </li>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == 'p=cart') echo ' active';?>">
              <a class="nav-link" href="?p=cart">Shopping Cart</a>
            </li>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == 'p=myorders') echo ' active';?>">
              <a class="nav-link " href="?p=myorders">My orders</a>
            </li>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == 'p=myinfo') echo ' active';?>">
              <a class="nav-link" href="?p=myinfo">My Account</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?p=logout">Logout</a>
            </li>
          <?php else:?>
            <li class="nav-item<?php if($_SERVER['QUERY_STRING'] == '' || $_SERVER['QUERY_STRING'] == 'p=start') echo ' active';?>">
              <a class="nav-link" href="index.php?p=start">Home Page</a>
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
          <?php endif;?>
          <?php endif;?>
			</ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
        </div>
      </nav>
    </header>
<div class="container-fluid">
      <div class="row">
<main id='maincontent' role="main" class="w-100 pb-5 pt-3 px-2">
<?php
if( ! isset($_REQUEST['p'])) {
	$_REQUEST['p']='start';
}
$p = $_REQUEST['p'];

$pages = array('start','shopinfo','login','do_login','after_login','logout','myinfo','contact','products','cart','catinfo','productinfo','add_cart','empty_cart','buy_cart', 'orders_manage');

$ok=false;
foreach($pages as $pp) {
	if($pp==$p) {
		require "internal/$p.php";
		$ok=true;
	}
}
if(! $ok) {
	print "The requested page was not found";
}

?>
     </main>
      </div>
    </div>

    <!-- Footer -->
    <div class="text-white bg-dark fixed-bottom">
      <div class="row align-items-center mx-0">
        <div class="nav-link">
          &copy;Bookstore 2019-2020
        </div>
        <div class="nav-link">|</div>
        <a class="nav-link" href="?p=shopinfo">About Us</a>
        <a class="nav-link" href="?p=contact">Contact Us</a>
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
