<script language="JavaScript" type="text/javascript">
function submit_addtocart(catId)
{
window.location.href="cart.php?action=add&p="+catId;
//document.myform.submit();
}
</script>
<?php
require("addtocartbutton.php");

$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$page = ($page == 0 ? 1 : $page);
$perpage = 12;//limit in each page
$startpoint = ($page * $perpage) - $perpage;
if($cat_id){
  $sql = @mysql_query("select * FROM `products` where  `cat_id` = $cat_id and `status` = true order by `created_at` desc LIMIT $startpoint,$perpage");
}
else{
  $sql = @mysql_query("select * FROM `products` where `status` = true order by `created_at` desc LIMIT $startpoint,$perpage");
}
$i = 0;

//show pages

echo Pages("products",$perpage,"store.php?cat_id=".$cat_id."&&");
$i = 0;
while ($row = mysql_fetch_array($sql)) {
echo '<td style="border-right:1px solid #DCDCDC" width="33%" height="175">';
echo  '<table width="90%" height="100%" border="0" cellpadding="0" cellspacing="0">';
echo  '<tr>';
echo '<td align="center" valign="middle"><a href="store.php?id='.$row[0].'"><img src="images/'.$row[4].'" alt="'.$row[2].'" width="94" height="103" border="0"></a></td>';
echo  '</tr>';
echo  '<tr>';
echo  '<td height="50" align="left" valign="top"><div align="center"><strong>'.$row[2].'</strong><br>$ '.$row[6].'</div></td>';
echo '</tr>';
echo '<tr><td align="center"><input name="" src="images/add_to_cart_new.jpg" type="image"  onclick="submit_addtocart('.$row[0].');"></td></tr>';
echo '</table>';
echo '</td>';
$i = $i+1;
if ($i%3 == 0){ echo '<tr> <td width="33%" height="30">&nbsp;</td><td width="33%" height="30">&nbsp;</td><td width="33%" height="30">&nbsp;</td></tr>';}

}

?>
