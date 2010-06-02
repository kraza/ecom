<?php

include("db/db_connect.php");
require_once('query.php');
require_once 'db/cart-functions.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>HAREDESIGNS.COM</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<Link href="style.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
.style2 {font-size: 12px}
-->
</style>
</head>

<body background="images/pgbg.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="770" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="15" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top" bgcolor="#FFFFFF">
    <table width="755" height="100%" border="0" cellpadding="0" cellspacing="0"><?php require_once("menubar.php"); ?>
      <tr>
          <td align="left" valign="top"><table width="755" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="center" valign="top">
                <td width="179"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"><?php require_once("sidebar.php"); ?>
                <tr><td height="70" align="left" valign="middle">&nbsp;</td></tr>
                <tr><td height="325" align="center" valign="top"><img src="images/feel.jpg" width="176" height="319"></td></tr>
                  </table></td>
                <td width="2">&nbsp;</td>
                <td width="561"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td height="20" align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td height="31" align="left" valign="middle" background="images/greenbar.gif" style="background-repeat:no-repeat" >&nbsp;&nbsp;&nbsp;<span class="footermenu"><strong><font color="#FFFFFF">promotional products </font></strong></span></td>
                    </tr>
                    <tr> 
                      <td height="20">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td align="center" valign="top">&nbsp;</td>
                    </tr>
                    
                  </table></td>
              </tr>
            </table></td>
        </tr>
<?php require_once("bottom.php");?>
</table>
</body>
</html>
