<?php
require_once("addtocartbutton.php");
echo '<td style="border-right:1px solid #DCDCDC" width="33%" height="175">';
echo  '<table width="70%" height="100%" border="0" cellpadding="0" cellspacing="0" align="center">';
echo  '<tr>';
echo '<td >Name</td><td>'.$info_row[2].'</td>';
echo  '</tr>';
echo  '<tr>';
echo '<td >Description</td><td>'.$info_row[3].'</td>';
echo  '</tr>';
echo  '<tr>';
echo '<td >Price</td><td>$ '.$info_row[6].'</td>';
echo  '</tr>';
echo  '<tr>';
echo '<td >Image</td><td><img src="images/'.$info_row[4].'" alt="'.$info_row[2].'" width="180" height="153" border="0"><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#">View large</a></td>';
echo  '</tr>';
echo '<tr><td colspan="2" align="center"><br /><br /><input name="" src="images/add_to_cart_new.jpg" type="image"  onclick="submit_addtocart('.$info_row[0].');"></td></tr>';
echo '</table>';
echo '</td>';

?>
