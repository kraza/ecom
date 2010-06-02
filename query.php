<?php 

$cat_id = $_GET['cat_id'];
// Query for category
$query  = "select * from category where `catageory_status` = true ";
$category_result = mysql_query($query);

$product_id = $_GET['id'];

if ($product_id){
$query1 = "select * from products where `id` = '".$product_id."'";
$product_info  = mysql_query($query1);
$info_row = mysql_fetch_row($product_info);
}

$query3 = "select b.id, a.name, a.price, b.quantity, b.totalprice from products a, cart_tbl b where a.id = b.pd_id and b.sid = '".$_SESSION['ct_session_id']."' ORDER BY b.id desc";
$cart_table = mysql_query($query3);

//Query for products
//$query2 = "select * from products where `status` = true order by `created_at` desc";
//$product_result  = mysql_query($query2);
//echo $cat_id;
//if ($cat_id) {
//  echo "my is iss".$cat_id;
//  $query2 = "select * from products where `id` = '".$cat_id."' and `status` = true order by `created_at` desc";
//  $product_result  = mysql_query($query2);
//  echo "Qiery is".$query2;
//}
//else {
//  $query2 = "select * from products where `status` = true order by `created_at` desc";
//  $product_result  = mysql_query($query2);
//  echo "Qiery is".$query2 ;
 // }
?>
