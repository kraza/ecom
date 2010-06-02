  <tr><td height="20" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr> 
    <td height="31" align="left" valign="middle" background="images/shop.gif" style="background-repeat:no-repeat">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="footermenu"><strong><font color="#FFFFFF">shop 
    by categories</font></strong></span></td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <?php while ($row = mysql_fetch_array($category_result, MYSQL_NUM)) { if  (($cat_id ) and ($cat_id == $row[0])) {$cat_name = $row[1] ;}?>
        <tr>
          <td style="border-bottom:1px solid #D8D8D8" height="26" align="center" valign="middle">
            <table width="90%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%" height="22" align="center"><img src="images/bullet.gif" width="7" height="9"></td>
                <td width="90%" height="22" align="left" valign="middle"><a href="store.php?cat_id=<?php echo $row[0];?>" class="menu2"><?php echo $row[1];?></a></td>
              </tr>
            </table>
          </td>
        </tr>
        <?php } ?>
      </table>
    </td>
  </tr>
  
