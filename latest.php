<?php
require("addtocartbutton.php");


$sql = @mysql_query("select * FROM `products` where `status` = true order by `created_at` desc LIMIT 6");
$i = 0;

//show pages

$i = 0;
while ($row = mysql_fetch_array($sql)) {
echo '<td style="border-right:1px solid #DCDCDC" width="33%" height="175">';
echo  '<table width="90%" height="100%" border="0" cellpadding="0" cellspacing="0">';
echo  '<tr>';
echo '<td align="center" valign="middle"><a href="store.php?id='.$row[0].'"><img src="images/'.$row[4].'" alt="'.$row[2].'" width="94" height="103" border="0"></a></td>';
echo  '</tr>';
echo  '<tr>';
echo  '<td height="30" align="left" valign="top"><div align="center"><strong>'.$row[2].'</strong><br>$'.$row[6].'</div></td>';
echo '</tr>';
//echo '<tr><td align="center"><input name="" src="images/add_to_cart_new.jpg" type="image"  onclick="submit_addtocart('.$row[0].');"></td></tr>';
echo '<tr><td height="50" align="center" valign="top"><input name="" src="images/add_to_cart_new.jpg" type="image"  onclick="submit_addtocart('.$row[0].');"></td></tr>';
echo '</table>';
echo '</td>';
$i = $i+1;
if ($i%3 == 0){ echo '</tr><td colspan="3" background="images/bg.gif"><img src="images/bg.gif" width="1" height="1"></td><tr>';}

}

?>
