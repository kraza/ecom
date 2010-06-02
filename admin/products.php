<?php
session_start();
require_once ('pagination.php');
include("../db/db_connect.php");
if (!$_SESSION['authorized']) 
{
  header("Location: index.php");	
  exit;
}
require_once('formvalue.php');
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
              <td width="130" height="30" align="center" valign="middle"><div align="left" class="style2"><br></div></td>
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
                <td width="176"><?php require_once("sidebar.php"); ?></td>
              </tr>
                <tr> 
                      <td height="325" align="center" valign="top">&nbsp;</td>
                    </tr>
                </table></td>
                <td width="10">&nbsp;</td>
                <td width="559"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                   <?php require_once("msg.php");?>
                    <tr> 
                      <td colspan="2" align="center" valign="top">
                        <p>&nbsp;</p>
                        <?php require_once("product.php");?>
                      </td>
                    </tr>
                </table>
                <p>&nbsp;</p></td>
                <td width="10">&nbsp;</td>
              </tr>
            </table>
          </td>
          </tr>
          <?php require_once("../bottom.php");?>
  </table>
</body>
</html>
