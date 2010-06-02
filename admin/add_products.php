<?php
session_start();
require_once ('pagination.php');
include("../db/db_connect.php");
if (!$_SESSION['authorized']) 
{
  header("Location: index.php");	
  exit;
}
include("../db/db_connect.php");
$mode = $_GET['mode'];
$type = $_GET['type'];
$prod_id = $_GET['product_id'];
$category = $_GET['id'];

//for Product add/updation
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$description = $_POST['description'];
$cat_id = $_POST['cat_id'];
$price = $_POST['price'];
$status = $_POST['status'];
$current_image=$_FILES['img']['name'];
$extension = substr(strrchr($current_image, '.'), 1);
if($current_image){
  if (($extension!= "jpg") && ($extension != "jpeg")) 
  {
  die('Unknown extension');
  }
  $time = date("Ymdhis");
  $new_image = $cat_id."_".$time . "." . $extension;
  $destination="../images/".$new_image;
  $action = copy($_FILES['img']['tmp_name'], $destination);
  $image_update =  "update products set image = '$new_image' where id = '$product_id'";
}

//End product part

//for category add/updation
$category_id = $_POST['category_id'];
$categeory_name = $_POST['name'];
$categeory_description = $_POST['description'];
$category_status = $_POST['status'];
//End for category
#echo $_SERVER['SCRIPT_FILENAME']; 
if($type == 'category') 
  {
    if($mode=='edit') {
    $query = "update category set categeory_name='$categeory_name', category_description ='$categeory_description',catageory_status = '$category_status',updated_at = CURDATE() where id = '$category_id'";
    $_SESSION['msg'] = "Category update successfully";
    }
    elseif($mode=='delete'){
      $query = "DELETE FROM `category` where `id` = $category";
      $_SESSION['msg'] = "Category deleted successfully";
    }
    else
      {
        $query = "INSERT INTO `category` (`categeory_name` ,`category_description` ,`catageory_status` ,`created_at` ,`updated_at`)
        VALUES ('$categeory_name', '$categeory_description', '$category_status', CURDATE(),CURDATE() )";
        $_SESSION['msg'] = "Category added successfully";
      }
  if (!mysql_query($query))
  {
 die('Error: ' . mysql_error());
  }
else 
  {
  header("Location: category.php");
 exit;	  
}
  }
 else { 
if($mode=='edit') {
$query = "update products set name = '$product_name',description ='$description',status = '$status', price = '$price', updated_at = CURDATE() where id = '$product_id'";
if($current_image){
mysql_query($image_update);
}
$_SESSION['msg'] = "Product update successfully";
 }
 elseif($mode=='delete'){
      $query = "DELETE FROM `products` where `id` = $prod_id";
      $_SESSION['msg'] = "Product deleted successfully";
      $cat_id = $category;
    }
else
  {
    $query = "INSERT INTO products (cat_id, name, description, image, status, price, created_at, updated_at) VALUE ('$cat_id', '$product_name', '$description', '$new_image', '$status', '$price', CURDATE(),CURDATE() )";
    $_SESSION['msg'] = "Product added successfully";
  }

if (!mysql_query($query))
  {
  die('Error: ' . mysql_error());
  }
else 
  {
    header("Location: products.php?cat_id=".$cat_id);
    exit;	  
  }
  }
?>
