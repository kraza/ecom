<?php 
include("../db/db_connect.php");
$user_name = $_POST['uname'];
$user_password = $_POST['upassword'];
$mode = $_GET['mode'];
session_start();

$query = "select * from admin where `name` = '".$user_name."' and `password` = '".$user_password."'";

$select_user = mysql_query($query);
$num = mysql_num_rows($select_user);

if($mode)
{
  
  session_unset("authorized");
  session_destroy();
  header("Location: index.php");
  exit;	
}

elseif ($num) 
{
    session_register('authorized');
    $_SESSION['authorized'] = true;
    $_SESSION['msg'] = "Login successfully";
    header("Location: category.php");
    exit;
} 
else 
{
    header("Location: index.php");
    exit;	
}

?>
