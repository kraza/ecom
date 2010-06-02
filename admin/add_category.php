<?php
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
if($type == 'category') 
  {
    if($mode=='edit') {
    $query = "update category set categeory_name='$categeory_name', category_description ='$categeory_description',catageory_status = '$category_status',updated_at = CURDATE() where id = '$category_id'";
    }
    elseif($mode=='delete'){
      $query = "delete form category where id = '$category' LIMIT 1";
    }
    else
      {
        $query = "INSERT INTO `category` (`categeory_name` ,`category_description` ,`catageory_status` ,`created_at` ,`updated_at`)
        VALUES ('$categeory_name', '$categeory_description', '$category_status', CURDATE(),CURDATE() )";
      }
  if (!mysql_query($query))
  {
 die('Error: ' . mysql_error());
  }
else 
  {
  header("Location: home.php?type=category");
 exit;	  
}
  }
 else { 
if($mode=='edit') {
$query = "update products set name = '$product_name',description ='$description',status = '$status',updated_at = CURDATE() where id = '$product_id'";
if($current_image){
mysql_query($image_update);
}
 }
else
{
$query = "INSERT INTO products (cat_id, name, description, image, status, created_at, updated_at) VALUE ('$cat_id', '$product_name', '$description', '$new_image', '$status', CURDATE(),CURDATE() )";
}
//echo "Query".$query;
if (!mysql_query($query))
  {
  die('Error: ' . mysql_error());
  }
else 
  {
  header("Location: home.php?cat_id=".$cat_id);
    exit;	  
  }
  }
?>
