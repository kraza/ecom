<?php
include("db/db_connect.php");
require_once 'db/cart-functions.php';

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';
//$action=$_GET['action'];
switch ($action) {
	case 'add' :
		addToCart();
		break;
	case 'update' :
		updateCart();
		break;	
	case 'delete' :
		deleteFromCart();
		break;
	case 'view' :
	     //header("Location: cart_list.php");
		break;
}
?>

 
