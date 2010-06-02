<?php
$type = $_GET['type'];  // type is either it is category or product
$mode = $_GET['mode']; // mode defines ,it is in add mode or in edit mode.
$cat_id = $_GET['cat_id'];
$category_id = $_GET['id']; // category id for edit category table 
$product_id = $_GET['product_id']; //product id for editing product table

$query  = "select * from category where `catageory_status` = true ";
$category_result = mysql_query($query);
//if($cat_id){
//$query2 = "select * from products where `cat_id` = '".$cat_id."' and `status` = true";
//$product_result  = mysql_query($query2);
//}

if ($mode and $product_id){
$query2 = "select * from products where `cat_id` = '".$cat_id."' and `id` = '".$product_id."'";
$product_result  = mysql_query($query2);
$edit_row = mysql_fetch_row($product_result);
}

if ($category_id){
$query4 = "select * from category where `id` = '".$category_id."'";
$category_edit  = mysql_query($query4);
$edit_row = mysql_fetch_row($category_edit);
}
?>
