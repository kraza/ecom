<?php
session_start();
require_once ('pagination.php');
include("../db/db_connect.php");
echo $_SESSION['authorized'];
if (!$_SESSION['authorized']) 
{
  header("Location: index.php");	
  exit;
}

$type = $_GET['type'];  // type is either it is category or product
$mode = $_GET['mode']; // mode defines ,it is in add mode or in edit mode.
$cat_id = $_GET['cat_id'];
$category_id = $_GET['id']; // category id for edit category table 
$product_id = $_GET['product_id']; //product id for editing product table

if(!$mode){$mode = 'add';}
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

if($type){
$query3 =  "select * from category";
$category = mysql_query($query3);
}

if ($type and $category_id){
$query4 = "select * from category where `id` = '".$category_id."'";
$category_edit  = mysql_query($query4);
$edit_row = mysql_fetch_row($category_edit);
echo $edit_row[1];
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>HAREDESIGNS.COM</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<Link href="../style.css" type="text/css" rel="stylesheet">
<style type="text/css">
a {
color:#333;
text-transform: capitalize;
}
a:hover{
color: #999;
text-decoration:underline
}
<!--
.style2 {font-size: 12px}
.style3 {font-size: 13px; line-height:18px; text-decoration:none; font-weight:bold; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;}
-->
</style>
</head>

<body background="../images/pgbg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="770" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="15" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top" bgcolor="#FFFFFF"><table width="755" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="75" align="center" valign="middle"><table width="720" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="475" height="30" align="left" valign="middle" class="caption"><a href="/index.php"><img src="../images/logo.jpg" width="150" height="111" border="0"></a></td>
              <td width="114" height="30" align="right" valign="middle" class="cart">&nbsp;</td>
              <td width="130" height="30" align="center" valign="middle"><div align="left" class="style2"><br>
              </div></td>
              <td width="10" height="30"><a href="#" class="cart"></a></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="32" align="center" valign="middle" background="../images/menubar.gif">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="top"><table width="755" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="center" valign="top">
                <td width="176"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="20" align="left" valign="middle">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td height="31" align="left" valign="middle" background="../images/shop.gif" style="background-repeat:no-repeat">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style3"><strong><font color="#FFFFFF">C</font></strong></span><span class="footermenu"><strong><font color="#FFFFFF">ategories</font></strong></span></td>
                    </tr>
                    <tr> 
                      <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php while ($row = mysql_fetch_array($category_result, MYSQL_NUM)) { if  (($cat_id ) and ($cat_id == $row[0])) {$cat_name = $row[1] ;}?>
                          <tr>
                          
                            <td style="border-bottom:1px solid #D8D8D8" height="26" align="center" valign="middle"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="10%" height="22" align="center"><img src="../images/bullet.gif" width="7" height="9"></td>
                                  <td width="90%" height="22" align="left" valign="middle"><a href="home.php?cat_id=<?php echo $row[0];?>" class="menu2"><?php echo $row[1];?></a></td>
                                </tr>
                              </table></td>
                          </tr><?php } ?>
                        
                        </table></td>
                    </tr>
                    <tr> 
                      <td height="325" align="center" valign="top">&nbsp;</td>
                    </tr>
                </table></td>
                <td width="10">&nbsp;</td>
                <td width="559"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="100%" height="20" colspan="2" align="left" valign="top">&nbsp;</td>
                    </tr>
                    
                    <tr> 
                      <td height="31" colspan="2" align="left" valign="middle" background="../images/greenbar.gif" style="background-repeat:no-repeat" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style3"><strong><font color="#FFFFFF">Welcome to HAREDESIGNS Admin Module </font></strong></span></td>
                    </tr>
                    <tr> 
                      <td height="20" colspan="2"><A HREF="home.php?type=category">&gt;&gt; Add/Edit Category </a>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <A HREF="login.php?mode=logout">Logout</td> 
                    </tr>
                    <tr> 
                      <td colspan="2" align="center" valign="top"><p><strong>Product List</strong></p>
                  <p>&nbsp;</p>
                  <?php
                       if($cat_id) { 
                      $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                      $page = ($page == 0 ? 1 : $page);
                      $perpage = 9;//limit in each page
                      $startpoint = ($page * $perpage) - $perpage;
                      
                      $sql = @mysql_query("select * FROM `products` where `cat_id`=$cat_id order by id desc LIMIT $startpoint,$perpage");
                    $i = 0;
                    $active = False;
                    while($row = mysql_fetch_array($sql)) { 
                     $active = True;
                    echo '<A HREF="home.php?cat_id='.$cat_id.'&&product_id='.$row[0].'&&mode=edit"> <img src="../images/'.$row[4].'" alt="'.$row[2].'" width="80" height="80" /> </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      ' ;
                      $i = $i+1;
                      if ($i%3 == 0){ echo '<br/><br/><br/>';}
                    }

                      //show pages
                      if($active){
                      echo Pages("products",$perpage,"home.php?cat_id=".$cat_id."&&");
                      }
                      else{echo "No Product added in this category.";}
                      }
                    ?>
                  <hr>
                  <?php if($cat_id) { 
                  ?>
                  <p><strong>Add product for <?php echo $cat_name;?></strong></p>
                  
                  <form method="POST" action="add_products.php?mode=<?php echo $mode;?>" enctype="multipart/form-data">
                  <table width="500" border="0">
                    
                    <tr>
                      <td width="132"><strong>Product Name</strong></td>
                      <td width="352"><input type="text" name="product_name" value="<?php echo $edit_row[2];?>"><input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
                      <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"></td>
                    </tr>
                    <tr>
                      <td><strong>Image</strong></td>
                      <td><input type="file" name="img" /><?php if($product_id){?><img src="../images/<?php echo $edit_row[4];?>" alt="'.$row[2].'" width="180" height="150" /><?php }?></td>
                    </tr>
                    <tr>
                      <td><strong>Status</strong></td>
                      <td><select name="status" id="status" >
                      <option value="1">Active</option>
                      <option value="0" <?php if(!$edit_row[5] && ($mode == 'edit')) {?> SELECTED <?php } ?>>InActive</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td><strong>Description</strong></td>
                      <td><textarea name="description" rows="5" cols="40"> <?php echo $edit_row[3];?></textarea></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"><input type="submit" name="submit" value="Submit"/> <input type="reset" name="reset" value="Reset"/> </td>
                    </tr>
                  </table>
                  </form>
                  <?php } ?>
                  
                  <?php if($type  && (!$category_id  and ($mode != 'cat_add'))) {?>
                  <table width="500" border="0">
                  <?php while ($row = mysql_fetch_array($category, MYSQL_NUM)) { ?>
                  <tr>
                  <td><?php echo $row[1];?></td>
                  <td><?php if($row[3]) {?> Active <?php } ?> <?php if(!$row[3]) {?> InActive <?php }?></td>
                  <td><A HREF="home.php?type=category&&mode=edit&&id=<?php echo $row[0]; ?>">Edit</a></td><td><A HREF="add_products.php?type=category&&mode=delete&&id=<?php echo $row[0]; ?>">Delete</a></td>
                  </tr>
                  <?php }?>
                  </table><br/><br/> </br>
                  <a href="home.php?type=category&&mode=cat_add">Add New </a>
                  <?php }?>
                  
                  <?php if($type  && ($category_id  or ($mode == 'cat_add'))) { echo $mode;?>
                  <form method="POST" action="add_products.php?mode=<?php echo $mode;?>&&type=category">
                    <table width="500" border="0">
                    <tr>
                      <td width="132"><strong>Category Name</strong></td>
                      <td width="352"><input type="text" name="name" value="<?php echo $edit_row[1];?>">
                      <input type="hidden" name="category_id" value="<?php echo $category_id; ?>"></td>
                    </tr>
                    <tr>
                      <td><strong>Description</strong></td>
                      <td><textarea name="description" rows="5" cols="40"> <?php echo $edit_row[2];?></textarea></td>
                    </tr>
                    <tr>
                      <td><strong>Status</strong></td>
                      <td><select name="status" id="status" >
                      <option value="1">Active</option>
                      <option value="0" <?php if(!$edit_row[3] && ($mode == 'edit')) {?> SELECTED <?php } ?>>InActive</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"><input type="submit" name="submit" value="Submit"/> <input type="reset" name="reset" value="Reset"/> </td>
                    </tr>
                    
                  </table>
                  </form>
                  <?php }?>
                  </td>
                    </tr>
                </table>
                  
                  <p>&nbsp;</p></td>
                <td width="10">&nbsp;</td>
                
              </tr>
            </table></td>
        </tr>
        <tr>
          <td align="center" valign="middle" bgcolor="#3C3C3C"><img src="../images/bottom.gif" width="2" height="2"></td>
        </tr>
        <tr>
          <td height="40" align="center" valign="middle">Copyright 2010 Hare Designs- All rights reserved.</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="15" align="left" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>
