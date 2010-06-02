<?php

require_once ('Pagination/pagination.php');
include("db/db_connect.php");
require_once ('db/cart-functions.php');
require('db/checkout-functions.php');
require_once('query.php');

if (isCartEmpty()) {
  // the shopping cart is still empty
	// so checkout is not allowed
	//header('Location: cart.php');
	header('Location: cart_list.php');
}
else if (isset($_GET['step']) && (int)$_GET['step'] > 0 && (int)$_GET['step'] <= 3) {
	$step = (int)$_GET['step'];

	$includeFile = '';
	if ($step == 1) {
		$includeFile = 'shippingAndPaymentInfo.php';
		$pageTitle   = 'Checkout - Step 1 of 2';
	} else if ($step == 2) {
		$includeFile = 'checkoutConfirmation.php';
		$pageTitle   = 'Checkout - Step 2 of 2';
	} else if ($step == 3) {
		
		if($_SESSION['pay_mode']=='contact'){
		//$orderId     = saveOrder();
		//$orderAmount = getOrderAmount($orderId);
		//$_SESSION['orderAmount']=$orderAmount;
		//$_SESSION['orderId'] = $orderId;
		header('Location: index.php');
		exit;
		}else{
		
				//	paynet();
				
		$maxid=mysql_query("SELECT max(`od_id`) as id FROM `tbl_order`");
		$maxres=mysql_fetch_array($maxid);
		$orderId=$maxres['id']+1;
	include"lphp.php";
	$mylphp=new lphp;

	# constants
	$myorder["host"]       = "secure.linkpt.net";
	$myorder["port"]       = "1129";
	$myorder["keyfile"]    = "/home/boothima/public_html/1001231946.pem"; # Change this to the name and location of your certificate file 
	$myorder["configfile"] = "1001231946";        # Change this to your store number 

	# transaction details
	$myorder["ordertype"]         = "Sale";
	$myorder["result"]            = "Live";
	$myorder["transactionorigin"] = "ECI";
	$myorder["oid"]               = $orderId;
	$myorder["ponumber"]          = $orderId;
	$myorder["taxexempt"]         = "NO";
	$myorder["terminaltype"]      = "UNSPECIFIED";
	$myorder["ip"]                = "";

	# totals
	$myorder["subtotal"]    = $_SESSION['final_total'];
	$myorder["tax"]         = $_POST["tax"];
	$myorder["shipping"]    = $_POST["shipping"];
	$myorder["vattax"]      = $_POST["vattax"];
	$myorder["chargetotal"] = $_SESSION['final_total'];

	# card info
	$myorder["cardnumber"]   = $_POST["creditcardnum"];
	$myorder["cardexpmonth"] = $_POST["creditcardmonth"];
	$myorder["cardexpyear"]  = $_POST["creditcardyear"];
	$myorder["cvmindicator"] ="provided";
	$myorder["cvmvalue"]     = $_POST["csu"];

	# BILLING INFO
	 $myorder["name"]     = $_POST["hidPaymentFirstName"].' '.$_POST["hidPaymentLastName"];
	$myorder["company"]  = $_POST["company"];
	$myorder["address1"] = $_POST["hidPaymentAddress1"];
	$myorder["address2"] = $_POST["hidPaymentAddress2"];
	$myorder["city"]     = $_POST["hidPaymentCity"];
	$myorder["state"]    = $_POST["hidPaymentState"];
	$myorder["country"]  = "US";
	$myorder["phone"]    = $_POST["hidPaymentPhone"];
	$myorder["fax"]      = $_POST["fax"];
	$myorder["email"]    = $_POST["hidShippingEmail"];
	$myorder["addrnum"]  = $_POST["addrnum"];
	$myorder["zip"]      = $_POST["hidPaymentPostalCode"];

	# SHIPPING INFO
	$myorder["sname"]     =  $_POST["hidShippingFirstName"].' '.$_POST["hidShippingLastName"];
	$myorder["saddress1"] = $_POST["hidShippingAddress1"];
	$myorder["saddress2"] = $_POST["hidShippingAddress2"];
	$myorder["scity"]     = $_POST["hidShippingCity"];
	$myorder["sstate"]    = $_POST["hidShippingState"];
	$myorder["szip"]      = $_POST["hidShippingPostalCode"];
	$myorder["scountry"]  = "US";

	# MISC
	$myorder["comments"] = $_POST["order_notes"];
	$myorder["referred"] = $_POST["referred"];

  	if ($_POST["debugging"])
		$myorder["debugging"]="true";


#   Send transaction. Use one of two possible methods 
//	$result = $mylphp->process($myorder);       # use shared library model
	$result = $mylphp->curl_process($myorder);  # use curl methods

	
	/*if ($result["r_approved"] != "APPROVED")    // transaction failed, print the reason
	{
		print "Status:  $result[r_approved]<br>\n";
		print "Error:  $result[r_error]<br><br>\n";
	}
	else	// success
	{		
		print "Status: $result[r_approved]<br>\n";
		print "Transaction Code: $result[r_code]<br><br>\n";
	} */

# if verbose output has been checked,
# print complete server response to a table
	/*if ($_POST["verbose"])
	{
		echo "<table border=1>";

		while (list($key, $value) = each($result))
		{
			# print the returned hash 
			echo "<tr>";
			echo "<td>" . htmlspecialchars($key) . "</td>";
			echo "<td><b>" . htmlspecialchars($value) . "</b></td>";

			echo "</tr>";
		}
		
		echo "</table><br>\n";
	} */
		
		//echo "1";
		

		
		// our next action depends on the payment method
		// if the payment method is COD then show the 
		// success page but when paypal is selected
		// send the order details to paypal
		if ($result["r_approved"] != "APPROVED")    // transaction failed, print the reason
	{
	//echo "2";
			$st=$result[r_error];
		 header('Location: checkout.php?step=1&err="'.$st.'"');
		 exit;
		//print "Status:  $result[r_approved]<br>\n";
		//print "Error:  $result[r_error]<br><br>\n";
	}
	else
	{// success
    $orderId     = saveOrder();
		$orderAmount = getOrderAmount($orderId);
		$_SESSION['orderAmount']=$orderAmount;
		$_SESSION['orderId'] = $orderId;
    $st=$result[r_approved];
    $tr=$result[r_code];
    $query="update tbl_order set status='$st', transaction='$tr' where od_id=$orderId";
		mysql_query($query);
    header('Location: success.php');
	
	exit;
		//print "Status: $result[r_approved]<br>\n";
		//print "Transaction Code: $result[r_code]<br><br>\n";
	} 

		
		}
		
		
		//if ($_POST['hidPaymentMethod'] == 'cod') {
		//	header('Location: success.php');
		//	exit;
		//} else {
		//   ;exit;
			//$includeFile = 'paypal/payment.php';	
		//}
	}
} else {
	// missing or invalid step number, just redirect
	header('Location: index.php');
}

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
          <td align="left" valign="top">
            <table width="755" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="center" valign="top">
                <td width="175">
              <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"><?php require_once("sidebar.php"); ?>
                <tr><td height="70" align="left" valign="middle">&nbsp;</td></tr>
                <tr> <td height="325" align="center" valign="top"><img src="images/feel.jpg" width="176" height="319"></td></tr>
              </table></td>
                <td width="6">&nbsp;</td>
                <td width="561"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td height="20" align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td height="31" align="left" valign="middle" background="images/greenbar.gif" style="background-repeat:no-repeat" >&nbsp;&nbsp;&nbsp;<span class="footermenu"><strong><font color="#FFFFFF">store </font></strong></span></td>
                    </tr>
                    <tr> 
                      <td height="20">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr align="center" valign="top"><?php require_once("cartitem.php"); ?> </tr></table></td>
                    </tr>
                    <tr><td><?php require_once "include/$includeFile"; ?></td></tr>
                    <tr> 
                      <td height="10" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr align="center" valign="top">&nbsp; </tr>
                      </table></td>
                    </tr>
                   
                   
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <?php require_once("bottom.php");?>
</table>
</body>
</html>
