<style type="text/css">
* table{ border:none; font-size:11px; outline:none;}
</style>
<?php
/*
Line 1 : Make sure this file is included instead of requested directly
Line 2 : Check if step is defined and the value is two
Line 3 : The POST request must come from this page but the value of step is one
*/
/*if (!defined('WEB_ROOT')
    || !isset($_GET['step']) || (int)$_GET['step'] != 2
	|| $_SERVER['HTTP_REFERER'] != 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?step=1') {
	exit;
}
*/
$errorMessage = '&nbsp;';

/*
 Make sure all the required field exist is $_POST and the value is not empty
 Note: txtShippingAddress2 and txtPaymentAddress2 are optional
*/
$requiredField = array('txtShippingFirstName', 'txtShippingLastName', 'txtShippingAddress1', 'txtShippingPhone', 'txtShippingState',  'txtShippingCity', 'txtShippingPostalCode',
                       'txtPaymentFirstName', 'txtPaymentLastName', 'txtPaymentAddress1', 'txtPaymentPhone', 'txtPaymentState', 'txtPaymentCity', 'txtPaymentPostalCode');
					   
/*if (!checkRequiredPost($requiredField)) {
	$errorMessage = 'Input not complete';
}
*/					   
$cartContent = getCartContent();
?>
<script type="text/JavaScript">
function submitform()
{
  document.frmCheckout.action="<?php echo $_SERVER['PHP_SELF']; ?>?step=3";
  document.frmCheckout.submit();
}

function submitformback()
{
  document.frmCheckout.action="checkout.php?step=1";
  document.frmCheckout.submit();
}

<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
    var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<body onLoad="MM_preloadImages('images/confirm_order_orange.jpg','images/modify_shipping_info_orange.jpg')">
<table cellpadding="0" cellspacing="0" width="95%" border="0" align="center">
  <form method="post" name="frmCheckout" id="frmCheckout">
	<tr>
	    <td colspan="3" align="center">
		    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="infoTable">
		
		<?php if($_POST['order_notes']!=''){?>
		<tr><td colspan="3">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		       <tr><td colspan="3"  align="center" bgcolor="#e5e5e5"><strong>Order Notes</strong></td></tr>
		       <tr height="50"><td width="30%" align="right" ><strong>Order Notes:</strong></td> 
		       <td width="8%">&nbsp;</td> 
		       <td width="62%">&nbsp;<?php
			                              $text = $_POST['order_notes'];
                                          $newtext = wordwrap($text, 30, "<br />\n");
                                          echo $newtext;
			                              /*echo $_POST['order_notes'];*/ ?><input type="hidden" name="hidOrdernotes" id="hidOrdernotes" value="<?php echo $_POST['order_notes'];?>"/></td></tr>
		</table>
		</td></tr>
		<?php }?>
		<?php
		$_SESSION['ord_notes']=$_POST['order_notes']; 
		$_SESSION['s_fname']=$_POST['txtShippingFirstName']; 
		$_SESSION['s_lname']=$_POST['txtShippingLastName']; 
		$_SESSION['s_add1']=$_POST['txtShippingAddress1']; 
		$_SESSION['s_add2']=$_POST['txtShippingAddress2']; 
		$_SESSION['city']=$_POST['txtShippingCity']; 
		$_SESSION['state']=$_POST['txtShippingState']; 
		$_SESSION['zip']=$_POST['txtShippingPostalCode']; 
		$_SESSION['s_phone']=$_POST['txtShippingPhone']; 
		$_SESSION['s_email']=$_POST['txtShippingEmail'];
		
		$_SESSION['chk_s']=$_REQUEST['chkSame']; 
		$_SESSION['p_fname']=$_POST['txtPaymentFirstName']; 
		$_SESSION['p_lname']=$_POST['txtPaymentLastName']; 
		$_SESSION['p_add1']=$_POST['txtPaymentAddress1']; 
		$_SESSION['p_add2']=$_POST['txtPaymentAddress2']; 
		$_SESSION['p_city']=$_POST['txtPaymentCity']; 
		$_SESSION['p_state']=$_POST['txtPaymentState']; 
		$_SESSION['p_zip']=$_POST['txtPaymentPostalCode'];
		$_SESSION['p_phone']=$_POST['txtPaymentPhone']; 
		
		if($_POST['contactmeaboutcc']!="")
		   {  $_SESSION['pay_mode']="contact";}
		   
		if($_POST['creditcardnum']!="")
 		  {
			$_SESSION['pay_mode']="card";
			$_SESSION['pay_creditcardnum']=$_POST['creditcardnum'];
			$_SESSION['pay_c_vaild']=$_POST['csu'];
			$_SESSION['pay_c_exp_m']=$_POST['creditcardmonth'];
			$_SESSION['pay_c_exp_y']=$_POST['creditcardyear'];
		  }
		   $_SESSION['pay_notestext']=$_POST['notestext'];
		   $_SESSION['pay_wherefrom']=$_POST['wherefrom'];	
		?>
		
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
		    <td>
			        <table width="450" border="0"  cellpadding="5" cellspacing="1" class="infoTable">
						<tr class="infoTableHeader"> 
							<td colspan="2" align="center" bgcolor="#e5e5e5"><strong>Shipping Address</strong></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>First Name</strong></td>
							<td class="content"><?php echo $_POST['txtShippingFirstName']; ?>
								<input name="hidShippingFirstName" type="hidden" id="hidShippingFirstName" value="<?php echo $_POST['txtShippingFirstName']; ?>"></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Last Name</strong></td>
							<td class="content"><?php echo $_POST['txtShippingLastName']; ?>
								<input name="hidShippingLastName" type="hidden" id="hidShippingLastName" value="<?php echo $_POST['txtShippingLastName']; ?>"></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Address1</strong></td>
							<td class="content"><?php echo $_POST['txtShippingAddress1']; ?>
								<input name="hidShippingAddress1" type="hidden" id="hidShippingAddress1" value="<?php echo $_POST['txtShippingAddress1']; ?>"></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Address2</strong></td>
							<td class="content"><?php echo $_POST['txtShippingAddress2']; ?>
								<input name="hidShippingAddress2" type="hidden" id="hidShippingAddress2" value="<?php echo $_POST['txtShippingAddress2']; ?>"></td>
						</tr>


						<tr> 
							<td width="120" class="label"><strong>City</strong></td>
							<td class="content"><?php echo $_POST['txtShippingCity']; ?>
								<input name="hidShippingCity" type="hidden" id="hidShippingCity" value="<?php echo $_POST['txtShippingCity']; ?>" ></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Province / State</strong></td>
							<td class="content"><?php echo $_POST['txtShippingState']; ?> <input name="hidShippingState" type="hidden" id="hidShippingState" value="<?php echo $_POST['txtShippingState']; ?>" ></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Postal Code</strong></td>
							<td class="content"><?php echo $_POST['txtShippingPostalCode']; ?>
								<input name="hidShippingPostalCode" type="hidden" id="hidShippingPostalCode" value="<?php echo $_POST['txtShippingPostalCode']; ?>"></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Phone Number</strong></td>
							<td class="content"><?php echo $_POST['txtShippingPhone'];  ?>
								<input name="hidShippingPhone" type="hidden" id="hidShippingPhone" value="<?php echo $_POST['txtShippingPhone']; ?>"></td>
						</tr>
					<tr> 
						<td width="120" class="label"><strong>Email Id</strong></td>
						<td class="content"><?php echo $_POST['txtShippingEmail']; ?><input name="hidShippingEmail" type="hidden" id="hidShippingEmail"value="<?php echo $_POST['txtShippingEmail']; ?>"></td>
					</tr>												
					</table>
		    </td>
		    
			<td>&nbsp;</td>
		    
			<td valign="top">
			    <table width="450" border="0"  cellpadding="5" cellspacing="1" class="infoTable" align="right">
						<tr class="infoTableHeader"> 
						
							<td colspan="2"  align="center" bgcolor="#e5e5e5"><strong>Payment Address</strong><input type="hidden" name="hiddCHK" id="hiddCHK" value="<?php echo $_REQUEST['chkSame']; ?>"></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>First Name</strong></td>
							<td class="content"><?php echo $_POST['txtPaymentFirstName']; ?>
								<input name="hidPaymentFirstName" type="hidden" id="hidPaymentFirstName" value="<?php echo $_POST['txtPaymentFirstName']; ?>"></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Last Name</strong></td>
							<td class="content"><?php echo $_POST['txtPaymentLastName']; ?>
								<input name="hidPaymentLastName" type="hidden" id="hidPaymentLastName" value="<?php echo $_POST['txtPaymentLastName']; ?>"></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Address1</strong></td>
							<td class="content"><?php echo $_POST['txtPaymentAddress1']; ?>
								<input name="hidPaymentAddress1" type="hidden" id="hidPaymentAddress1" value="<?php echo $_POST['txtPaymentAddress1']; ?>"></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Address2</strong></td>
							<td class="content"><?php echo $_POST['txtPaymentAddress2']; ?> <input name="hidPaymentAddress2" type="hidden" id="hidPaymentAddress2" value="<?php echo $_POST['txtPaymentAddress2']; ?>"> 
							</td>
						</tr>


						<tr> 
							<td width="120" class="label"><strong>City</strong></td>
							<td class="content"><?php echo $_POST['txtPaymentCity']; ?>
								<input name="hidPaymentCity" type="hidden" id="hidPaymentCity" value="<?php echo $_POST['txtPaymentCity']; ?>"></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Province / State</strong></td>
							<td class="content"><?php echo $_POST['txtPaymentState']; ?> <input name="hidPaymentState" type="hidden" id="hidPaymentState" value="<?php echo $_POST['txtPaymentState']; ?>" ></td>
						</tr>						
						<tr> 
							<td width="120" class="label"><strong>Postal Code</strong></td>
							<td class="content"><?php echo $_POST['txtPaymentPostalCode']; ?>
								<input name="hidPaymentPostalCode" type="hidden" id="hidPaymentPostalCode" value="<?php echo $_POST['txtPaymentPostalCode']; ?>"></td>
						</tr>
						<tr> 
							<td width="120" class="label"><strong>Phone Number</strong></td>
							<td class="content"><?php echo $_POST['txtPaymentPhone'];  ?> <input name="hidPaymentPhone" type="hidden" id="hidPaymentPhone" value="<?php echo $_POST['txtPaymentPhone']; ?>"></td>
						</tr>						
				</table>

		    </td>

		</tr>
		
		
		
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td colspan="3">
				<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="infoTable">
				 <tr align="center" bgcolor="#e5e5e5"><td colspan="2"><strong>Shipping Information</strong></td></tr>
				 <tr>
				<td width="218" class="infoTableHeader"><strong>Shipping Method:</strong></td>
				<td width="791" class="content"><?php echo $_SESSION['pcode'];?></td>
				  
				</tr>
				 
				<?php if($_SESSION["coupon_code"]!=""){?>
				<tr>
				<td width="218" class="infoTableHeader"><strong>Coupon</strong></td>
				<td class="content"><?php echo $_SESSION["coupon_code"];?></td>
				 </tr> <?php }?>
				<?php if($_POST['wherefrom']){?>
				<tr>
				<td width="218" class="infoTableHeader"><strong>Hear About</strong></td>
				<td class="content"><?php echo $_POST['wherefrom'];?></td>
				 </tr> <?php }?>
				<?php if($_POST['notestext']!=""){?>
				<tr>
				<td width="218" class="infoTableHeader"><strong>Additional Notes</strong></td>
				<td class="content"><?php $t=$_POST['notestext']; $af = wordwrap($t, 30, "<br />\n"); echo $af;  ?></td>
				</tr>
				<?php }?>
				<tr align="center" bgcolor="#e5e5e5"><td colspan="2"><strong>Payment Information</strong></td></tr>
				<tr>
				<td width="218" class="infoTableHeader"><strong>Payment Method </strong></td>
				<td width="791" class="content"><?php if($_POST['contactmeaboutcc'])echo "Contact for Payment information";
				                          else echo "CreditCard";?>
				  <input name="hidPaymentMethod" type="hidden" id="hidPaymentMethod" value="<?php echo $_POST['optPayment']; ?>" />
				  <input type="hidden" name="creditcardnum" id="creditcardnum" value="<?php echo $_POST['creditcardnum']; ?>">
                  <input type="hidden" name="csu" id="csu" value="<?php echo $_POST['csu']; ?>">
                  <input type="hidden" name="creditcardmonth" id="creditcardmonth" value="<?php echo $_POST['creditcardmonth']; ?>">
                   <input type="hidden" name="creditcardyear" id="creditcardyear" value="<?php echo $_POST['creditcardyear']; ?>">
                   <input type="hidden" name="ordertype" id="ordertype" value="Sale">
                   <input type="hidden" name="hresult" id="hresult" value="Live">
                   <input type="hidden" name="creditcardyear" id="creditcardyear" value="<?php echo $_POST['creditcardyear']; ?>">
				</tr>
				
				<?php if($_POST['creditcardnum']!=""){?>
				<tr>
				<td width="218" class="infoTableHeader"><strong>Last four digits of Card Number:</strong></td>
				<td class="content"><?php  $t=$_POST['creditcardnum']; echo $af=substr($t, -4);  ?>
				
				</tr>
				<?php }?>
				<?php if($_POST['creditcardnum']!=""){?>
				<tr>
				<td width="218" class="infoTableHeader"><strong>Expiration:</strong></td>
				<td class="content">Month: <?php echo $_POST['creditcardmonth'];?>&nbsp; Year:<? echo $_POST['creditcardyear'];?>
				</tr>
				<?php }?>
				</table>
			</td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
	      <td align="right">&nbsp;<!--<input name="btnBack" type="button" id="btnBack" value="&lt;&lt; Modify Shipping/Payment Info" onClick="window.location.href='checkout.php?step=1';" class="box">-->
	                                              <a href="#" onClick="javascript: submitformback();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','images/modify_shipping_info_orange.jpg',1)"><img src="images/modify_shipping_info_light_org.jpg" name="Image2" width="149" height="27" border="0" id="Image2" /></a></td>
		   <td>&nbsp;</td>
	      <td align="left"> <!--<input name="btnConfirm" type="submit" id="btnConfirm" value="Confirm Order &gt;&gt;" class="box">-->
	       <a href="#"  onclick="javascript: submitform();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','images/confirm_order_orange.jpg',1)">
		   <img src="images/confirm_order_light_org.jpg" name="Image1" width="116" height="27" border="0" id="Image1" /></a></td>
		</tr>

</form></table>	
