<?php
  require_once("addtocartbutton.php");
  
 $_SESSION['shipprice']=0;
 if($_POST['zip']){
 $zip=$_POST['zip'];
 $_SESSION['zip']=$zip;
  $_SESSION['country']=$_POST['country'];
 }else{
 $zip=$_SESSION['zip'];
 
 }
 
if($_POST['pcode']!=''){
 $_SESSION['pcode']=$_POST['pcode'];
 }
 if($_POST['country']=='United States'){
			$ups = new upsaddress("5B9C9F21EDD18580", "laeelin", "46824682");
			 $ups->setZip($zip);
   			 $response = $ups->getResponse();
		 	$b= count($response->list);
			$invalidzip='';
			$invalidzip1='';
			if($b>0){
			//$_SESSION['entered_info']['state']= $response->list[0]->state;
			$cityhtml='';
			$cityhtml='<select name="city">';
			for($i=0;$i<$b;$i++){
			if($response->list[$i]->city == $post['city']){
			$cityhtml.='<option value="'.$response->list[$i]->city.'" selected>'.$response->list[$i]->city.'</option>';
			}else{
			$newcity=$response->list[0]->city;
			$cityhtml.='<option value="'.$response->list[$i]->city.'">'.$response->list[$i]->city.'</option>';
			}
			}
			$cityhtml.='</select>';
			if($b==1){
			$_SESSION['city']=$response->list[0]->city;
			$_SESSION['state']= $response->list[0]->state;
			
			}else{
			$_SESSION['city']=$newcity;
			$postcity=$response->list[0]->$newcity;
			$_SESSION['state']= $response->list[0]->state;
			$poststate= $response->list[0]->state;
			
			//$html = str_replace('<INPUT type="text" name="city" value="'.$post['city'].'" size="30" maxlength="35">', $cityhtml, $html);
			$html = str_replace('<INPUT type="text" name="city" value="<!--city-->" size="30" maxlength="35">', $cityhtml, $html);

$html = str_replace('<INPUT type="text" name="city" value="'.$_SESSION['city'].'" size="30" maxlength="35">', $cityhtml, $html);
			$invalidzip='';
			}
			}else{
			$invalidzip="It appears you have entered an incorrect zip code in shipping address, Please change zip code entered and click update Zip code. If the zip code shown is correct, please click continue after entering shipping information below.  Any questions, please call 866 433-7573.";
			}
							

		}
		
 //$_SESSION['upsquote'] = ShippingCalc($_SESSION['zip'],$_SESSION['ct_session_id'],$_SESSION['country']);

$cartContent = getCartContent();
?>

<style type="text/css">
* table{ border:none; font-size:11px; outline:none;}
</style>

<body onLoad="MM_preloadImages('images/proceed_orange.jpg')"><table cellpadding="0" cellspacing="0" width="100%">
	<!--<tr><td colspan="3" align="center" height="50"><h3>Step 1 Of 3 : Enter Shipping And Payment Information</h3></td></tr>-->
                                       <form  method="post" name="frmCheckout" id="frmCheckout">
									   	<input type="hidden" name="zip" value="<?php echo $_POST['zip'];?>">
										<input type="hidden" name="pcode" value="<?php echo $_POST['pcode'];?>">
										<input type="hidden" name="country" value="<?php echo $_POST['country'];?>">
										
	<tr>
	   <td colspan="3">
	   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="infoTable">
	   
	   <?php if($_GET['err']){?> <tr><td colspan="2" align="center" style="color:#FF0000; font-size:16px;" height="30"><strong><?php echo $_GET['err'];?></strong></td></tr><?php }?>
				<!--<tr class="infoTableHeader"> 
					<td colspan="11"><strong>Ordered Item</strong></td>
				</tr>-->
				
			
		
			 
		
		  </table>
	   
	       <table border="0"  width="100%"  cellpadding="1" cellspacing="0">
		   <tr><td colspan="2" align="center" bgcolor="#FFFFFF">&nbsp;</td></tr>
		   <tr><td colspan="2" align="center" bgcolor="#e5e5e5" height="30"><strong>Select Preferred Shipping Method:</strong>&nbsp;&nbsp;<?php echo pcodeeditor($_SESSION['upsquote']);?>
		   	<?php 




	//----------------------------------------
			
			function pcodeeditor($html){ // prepares ups Quote for drop downbox in checkout step 1 page

//  $final[] ... 0 = Short Code ; 1 = Code Number ; 2 = Code Desctiption ; 3 = Days ; 4 = ShipDate ; 5 = ArrivalDate ; 6 = Price

$allsameday=true;


$upsinfo=$_SESSION['upsquote'][1]; // putting ups quote recieved from UPS in array

$count=count($upsinfo); //counting no. of quotes recieved

$pcode='';

$selected=$_SESSION['pcode'];

if(strlen($selected)<2){ //if there is no selection then setting default value

	if($_SESSION['country']=='United States'){

		$selected='GND';

	}else{

		$selected='INT';

	}

}

if($_SESSION['upsquote'][0]=='MethodList' && count($_SESSION['upsquote'][1])>0){// if there is a good ups quote...

// HTML for ups quote drop down box
	$pcode.='<SELECT name="pcode" onchange="shipcal()">';

	for($i=0;$i<$count;$i++){ //putting loop to display quotes in dropsown

		$ups=current($upsinfo);

		if(($ups[6]>0 || ($_SESSION['coupon_shipp']=='free') && $ups[0]=='GND')){// if price is above zero...


			if($allsameday){ // if every product in cart have same day shipping on

				if($selected==$ups[0]){ // if GND is selected
						
					if(strtoupper(substr($_SESSION['state'],0,2))=='FL' && $ups[0]=='GND'){
					
					 // if state is FL then shipping price set to half
					 
						$pcode.='<option name="pcode" value="'.$ups[0].'" selected>$'.number_format(($ups[6])-$_SESSION['staffUPSdiscount'],2,'.','').' '.$ups[2];
						}else{
							$pcode.='<option name="pcode" value="'.$ups[0].'" selected>$'.number_format($ups[6]-$_SESSION['staffUPSdiscount'],2,'.','').' '.$ups[2];
						}
				}else{ // if GND is not selected
				
					if(strtoupper(substr($_SESSION['state'],0,2))=='FL' && $ups[0]=='GND'){
					$pcode.='<option name="pcode" value="'.$ups[0].'">$'.number_format($ups[6]-$_SESSION['staffUPSdiscount'],2,'.','').' '.$ups[2];
		}else{
		$pcode.='<option name="pcode" value="'.$ups[0].'">$'.number_format($ups[6]-$_SESSION['staffUPSdiscount'],2,'.','').' '.$ups[2];
		}
					
				} // end selected

				if(strlen($ups[5])>0 && $ups[0]=='GND'){ // shwing GND with days to transit option in drop down

					$pcode.=' - '.$ups[3].' estimated transit day(s) </OPTION>';

				}

			}else{

				if($selected==$ups[0]){
				
					if(strtoupper(substr($_SESSION['state'],0,2))=='FL' && $ups[0]=='GND'){
					
					// if state is FL then shipping price set to half
					
					$pcode.='<option name="pcode" value="'.$ups[0].'" selected>$'.number_format(($ups[6])-$_SESSION['staffUPSdiscount'],2,'.','').' '.$ups[2];
					}else{
					$pcode.='<option name="pcode" value="'.$ups[0].'" selected>$'.number_format($ups[6]-$_SESSION['staffUPSdiscount'],2,'.','').' '.$ups[2];
					
					}
					
				}else{
						if(strtoupper(substr($_SESSION['state'],0,2))=='FL' && $ups[0]=='GND'){
						$pcode.='<option name="pcode" value="'.$ups[0].'">$'.number_format($ups[6]-$_SESSION['staffUPSdiscount'],2,'.','').' '.$ups[2];
						}else{
						$pcode.='<option name="pcode" value="'.$ups[0].'">$'.number_format($ups[6]-$_SESSION['staffUPSdiscount'],2,'.','').' '.$ups[2];
						}
				}

				if(strlen($ups[5])>0 && $ups[0]=='GND'){

					$pcode.=' - Estimated '.$ups[3].' estimated transit day(s) </OPTION>';

				}

			}

		}// end if price is above zero...

		next($upsinfo);

	}

	$pcode.='<option name="pcode" value="TBT">Other - Explain in notes</Option>'; 


	$pcode.='</SELECT>';
	}

if($_SESSION['coupon_shipp']=='free' || $_SESSION['coupon_shipp']=='half' ){

			$pcode='<B>Your shipping has been discounted!</B><BR>'.$pcode;

	}elseif($_SESSION['coupon_shipp']=='2dafr'){
	if($_SESSION['entered_info']['country']=='United States' && $_SESSION['state']!='HI' && $_SESSION['state']!='AK'){
	

			//$pcode='<B>Your shipping has been discounted!</B><BR>'.$pcode;

	}
	

	}else{// start return for a bad ups quote

	/*	if($_SESSION['upsquote'][0]=='CityList'){

			$pcode.='Unable to form a shipping quote, Please check your entered city and zip code.<BR>';

		}else{

			$pcode.='Unable to form a shipping quote.<BR>';

		}
		
		$post['pcode']="TBT";
		$_SESSION['entered_info']['pcode']="TBT";
		$pcode.='<SELECT name="pcode" onchange="shipcal()">';

		$pcode.='<option name="pcode" value="TBT">International Shipment (outside the United States)</Option>';

		$pcode.='<option name="pcode" value="TBT">Contact Me For Shipping</Option>';

	 	$pcode.='</SELECT> <input name="Calculate Shipping" value="Calculate Shipping" type="button" onClick="shipcal();">';
*/
		

	}
	

$pcode = str_replace('name="pcode" value="'.$selected.'">', 'name="pcode" value="'.$selected.'" selected>', $pcode);


//$html=str_replace( '<!--pcodestuff-->', $pcode, $html); //putting dropdown in check step 1 page

return $pcode;

}
// end pcodeeditor

			
			//====================================

			?>
		   </td></tr>
		   <tr><td colspan="2" align="center" bgcolor="#FFFFFF"><span style="color:#274B85;"><BR>
		
			
          </span></td></tr>
		   
		   
	       <tr><td colspan="2" align="center" bgcolor="#e5e5e5" height="30"><strong>Order Notes</strong></td></tr>
		   <tr><td colspan="2">&nbsp;</td></tr>
		   <tr><td  width="32%" align="right">Enter Notes&nbsp;</td>
		   <td align="left" valign="middle" width="68%">
		     <textarea name="order_notes" id="order_notes" cols="40" rows="5"> <?php if($_SESSION['ord_notes']){echo $_SESSION['ord_notes'];} ?></textarea></td>
		    </tr>
			<tr><td colspan="2">&nbsp;</td></tr>
		   </table>
	   </td>  
	</tr>
	
	<tr>
		<td width="44%">
		
		<table width="102%" border="0" cellpadding="1" cellspacing="0" class="entryTable" >
        <tr class="entryTableHeader"> 
            <td colspan="2" align="center" bgcolor="#e5e5e5" height="30"><strong>Shipping Address</strong></td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
		<tr> 
            <td width="120" class="label">First Name<!--<font color="#FF0000">*</font>--></td>
            <td width="352" class="content"><input name="txtShippingFirstName" type="text" class="box" id="txtShippingFirstName" size="20"  
			value="<?php if($_SESSION['s_fname']){echo $_SESSION['s_fname'];} ?>"><div id="s_f" style="float:right; margin-right:65px;"></div></td>
        </tr>
        <tr> 
            <td width="120" class="label">Last Name<!--<font color="#FF0000">*</font>--></td>
            <td class="content"><input name="txtShippingLastName" type="text" class="box" id="txtShippingLastName" size="20" 
			value="<?php if($_SESSION['s_lname']){echo $_SESSION['s_lname'];} ?>"><div id="s_l" style="float:right; margin-right:65px;"></div></td>
        </tr>
        <tr> 
            <td width="120" class="label">Address1<!--<font color="#FF0000">*</font>--></td>
            <td class="content"><input name="txtShippingAddress1" type="text" class="box" id="txtShippingAddress1" size="30" 
			value="<?php if($_SESSION['s_add1']){echo $_SESSION['s_add1'];} ?>"><div id="s_ad" style="float:right; margin-right:65px;"></div>
			<br />Please provide street address - we cannot ship to a PO Box.</td>
        </tr>
        <tr> 
            <td width="120" class="label">Address2</td>
            <td class="content"><input name="txtShippingAddress2" type="text" class="box" id="txtShippingAddress2" size="30" 
			value="<?php if($_SESSION['s_add2']){echo $_SESSION['s_add2'];} ?>"></td>
        </tr>

        <tr> 
            <td width="120" class="label">City<!--<font color="#FF0000">*</font>--></td>
            <td class="content"><input name="txtShippingCity" type="text" class="box" id="txtShippingCity" size="20" 
			value="<?php if($_SESSION['city']){echo $_SESSION['city'];} ?>"><div id="s_c" style="float:right; margin-right:65px;"></div></td>
        </tr>
		<tr> 
            <td width="120" class="label">Province / State<!--<font color="#FF0000">*</font>--></td>
            <td class="content"><input name="txtShippingState" type="text" class="box" id="txtShippingState" size="20" 
			value="<?php if($_SESSION['state']){echo $_SESSION['state'];} ?>"><div id="s_s" style="float:right; margin-right:65px;"></div></td>
        </tr>
        <tr> 
            <td width="120" class="label">Postal / Zip Code<!--<font color="#FF0000">*</font>--></td>
            <td class="content"><input name="txtShippingPostalCode" type="text" class="box" id="txtShippingPostalCode" size="10" maxlength="10" onKeyUp="checkNumber(this);" value="<?php echo $_SESSION['zip']; ?>"><div id="s_z"></div></td>
        </tr>
		<tr> 
            <td width="120" class="label">Phone Number<!--<font color="#FF0000">*</font>--></td>
            <td class="content"><input name="txtShippingPhone" type="text" class="box" id="txtShippingPhone" size="20" maxlength="10" onKeyUp="checkNumber(this);" value="<?php if($_SESSION['s_phone']){echo $_SESSION['s_phone'];} ?>"><div id="s_p" style="float:right; margin-right:65px;"></div></td>
        </tr>
		<tr> 
            <td width="120" class="label">Email Id<!--<font color="#FF0000">*</font>--></td>
            <td class="content"><input name="txtShippingEmail" type="text" class="box" id="txtShippingEmail" size="20" 
			value="<?php if($_SESSION['s_email']){echo $_SESSION['s_email'];} ?>"><div id="s_email" style="float:right; margin-right:60px;"></div>
			<br />Your order confirmation and tracking number will be emailed to you.</td>
        </tr>
    </table>		</td>
		
		
		<td width="11%" valign="top">&nbsp;</td>
	  	    
	  <td width="45%" valign="top"><table  width="100%" border="0" cellpadding="1" cellspacing="0" class="entryTable">
        <tr>
          <td colspan="2" align="center" bgcolor="#e5e5e5" height="30"><strong>Payment Address</strong></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="entryTableHeader">
          <td width="120"></td>
          <td><input type="checkbox" name="chkSame" id="chkSame" value="1" onClick="setPaymentInfo(this.checked);"  <?php if($_SESSION['chk_s']==1){echo 'checked="checked"';}?> />
              <label for="chkSame" style="cursor:pointer">Same as shipping information</label></td>
        </tr>
        <tr>
          <td width="120" class="label">First Name<!--<font color="#FF0000">*</font>--></td>
          <td class="content"><input name="txtPaymentFirstName" type="text" class="box" id="txtPaymentFirstName" size="20"  value="<?php if($_SESSION['p_fname']){echo $_SESSION['p_fname'];} ?>"/><div id="p_f" style="float:right; margin-right:65px;"></div></td>
        </tr>
        <tr>
          <td width="120" class="label">Last Name<!--<font color="#FF0000">*</font>--></td>
          <td class="content"><input name="txtPaymentLastName" type="text" class="box" id="txtPaymentLastName" size="20" value="<?php if($_SESSION['p_lname']){echo $_SESSION['p_lname'];} ?>"/><div id="p_l" style="float:right; margin-right:65px;"></div></td>
        </tr>
        <tr>
          <td width="120" class="label">Address1<!--<font color="#FF0000">*</font>--></td>
          <td class="content"><input name="txtPaymentAddress1" type="text" class="box" id="txtPaymentAddress1" size="30"  value="<?php if($_SESSION['p_add1']){echo $_SESSION['p_add1'];} ?>" /><div id="p_ad" style="float:right; margin-right:60px;"></div></td>
        </tr>
        <tr>
          <td width="120" class="label">Address2</td>
          <td class="content"><input name="txtPaymentAddress2" type="text" class="box" id="txtPaymentAddress2" size="30" value="<?php if($_SESSION['p_add2']){echo $_SESSION['p_add2'];} ?>"/></td>
        </tr>
        <tr>
          <td width="120" class="label">City<!--<font color="#FF0000">*</font>--></td>
          <td class="content"><input name="txtPaymentCity" type="text" class="box" id="txtPaymentCity" size="20"  value="<?php if($_SESSION['p_city']){echo $_SESSION['p_city'];} ?>"/><div id="p_c" style="float:right; margin-right:65px;"></div></td>
        </tr>
        <tr>
          <td width="120" class="label">Province / State<!--<font color="#FF0000">*</font>--></td>
          <td class="content"><input name="txtPaymentState" type="text" class="box" id="txtPaymentState" size="20" value="<?php if($_SESSION['p_state']){echo $_SESSION['p_state'];} ?>"/><div id="p_s" style="float:right; margin-right:65px;"></div></td>
        </tr>
        <tr>
          <td width="120" class="label">Postal / Zip Code<!--<font color="#FF0000">*</font>--></td>
          <td class="content"><input name="txtPaymentPostalCode" type="text" class="box" id="txtPaymentPostalCode" size="10" maxlength="10" onKeyUp="checkNumber(this);"  value="<?php if($_SESSION['p_zip']){echo $_SESSION['p_zip'];} ?>"/><div id="p_z" style="float:right; margin-right:65px;"></div></td>
        </tr>
        <tr>
          <td width="120" class="label">Phone Number<!--<font color="#FF0000">*</font>--></td>
          <td class="content"><input name="txtPaymentPhone" type="text" class="box" id="txtPaymentPhone" size="20" onKeyUp="checkNumber(this);"  value="<?php if($_SESSION['p_phone']){echo $_SESSION['p_phone'];} ?>"/><div id="p_p" style="float:right; margin-right:65px;"></div></td>
        </tr>
      </table></td>
	</tr>
	<tr><td colspan="3">&nbsp;</td></tr>
  	<tr>
	    <td colspan="3">
		<TABLE border="0" cellspacing="0" cellpadding="1" width="100%" align="center">
       <TR><TD colspan="3">&nbsp;</TD></TR>
       <TR><TD colspan="3">&nbsp;</TD></TR>
  <TR bgcolor="#ECE9D8">

    <TD height="30" colspan="3" align="center" valign="middle" bgcolor="#e5e5e5"  class="subhead" ><strong>Payment Information</strong></TD>
  </TR>
  <TR><TD colspan="3">&nbsp;<div id="con_cr"></div></TD></TR>
  <TR>

    <TD align="left" colspan="3" class="cformpl"><input name="contactmeaboutcc" id="contactmeaboutcc" type="checkbox" 
	onClick="setcredit(this.checked);" value="contact" <?php if($_SESSION['pay_mode']==contact){echo 'checked="checked"';}?>/>    

    Click here if you would prefer to be contacted for payment.</TD>
  </TR>

  <TR>

    <TD height="50" colspan="2" align="left" class="cformpl">&nbsp;<IMG border="0" src="images/amexlogo.gif"> </TD>

    <TD width="325" height="50" class="cformpl"><span class="cform">How did you hear about us?<br>

      </span>

        <SELECT name="wherefrom" id="wherefrom" style="width:200px;" >

		   <option name="wherefrom" value="Not Answered"> - -Please Select- - </option>

           <option name="wherefrom" value="AOL">AOL Search</option>

          <option name="wherefrom" value="Ask">Ask.com</option>

          <option name="wherefrom" value="Coworker">Coworker</option>

          <option name="wherefrom" value="Supplier">Supplier Referral</option>

          <option name="wherefrom" value="Friend">Friend</option>

          <option name="wherefrom" value="Google">Google</option>

          <option name="wherefrom" value="Investors Business Daily">Investors Business Daily</option>

          <option name="wherefrom" value="MSN">MSN Search</option>

          <option name="wherefrom" value="New York Times">New York Times</option>

          <option name="wherefrom" value="Newspaper Ad">Newspaper Ad</option>

          <option name="wherefrom" value="Other Search">Other Search</option>

          <option name="wherefrom" value="People Magazine">People Magazine</option>

          <option name="wherefrom" value="Previous Customer">Previous Customer</option>

          <option name="wherefrom" value="Radio Ad">Radio Ad</option>

          <option name="wherefrom" value="Television Ad">Television Ad</option>

          <option name="wherefrom" value="USA Today">USA Today</option>

          <option name="wherefrom" value="Wall Street Journal">Wall Street Journal</option>

          <option name="wherefrom" value="Yahoo">Yahoo</option>



          <option name="wherefrom" value="Other">Other</option>
      </SELECT></TD>
  </TR>

  <TR>

    <TD width="251" height="50" align="left" class="cformpl">Card Number<br>

        <INPUT type="text" name="creditcardnum" id="creditcardnum" size="22" value="" onKeyUp="checkNumber(this);"><div id="crd_num"></div>    </TD>

    <TD width="374" align="left" class="cformpl"><span class="cformp">Validation&nbsp;Number<br>

          <INPUT type="text" name="csu" id="csu" size="5" value="" onKeyUp="checkNumber(this);">

    </span><div id="crd_v"></div></TD>

    <TD width="325" height="50" class="cformpl">&nbsp;</TD>
  </TR>

  <TR>

    <TD height="50" align="left" class="cformpl">Expiration<br>

      <SELECT name="creditcardmonth" id="creditcardmonth">
          <option value="">Select Month</option>
          <option value="01" name="creditcardmonth">01 - January</option>
          
		  <option name="creditcardmonth" value="02">02 - February</option>
          <option name="creditcardmonth" value="03">03 - March</option>
          <option name="creditcardmonth" value="04">04 - April</option>
          <option name="creditcardmonth" value="05">05 - May</option>
          <option name="creditcardmonth" value="06">06 - June</option>
          <option name="creditcardmonth" value="07">07 - July</option>
          <option name="creditcardmonth" value="08">08 - August</option>
          <option name="creditcardmonth" value="09">09 - September</option>
          <option name="creditcardmonth" value="10">10 - October</option>
          <option name="creditcardmonth" value="11">11 - November</option>
          <option name="creditcardmonth" value="12">12 - December</option>
      </SELECT>
      <select name="creditcardyear" id="creditcardyear">
        <option value="">Select Year</option>
        <option name="creditcardyear" value="10">2010</option>
        <option name="creditcardyear" value="11">2011</option>
        <option name="creditcardyear" value="12">2012</option>
        <option name="creditcardyear" value="13">2013</option>
        <option name="creditcardyear" value="14">2014</option>
        <option name="creditcardyear" value="15">2015</option>
        <option name="creditcardyear" value="16">2016</option>
        <option name="creditcardyear" value="17">2017</option>
        <option name="creditcardyear" value="18">2018</option>
        <option name="creditcardyear" value="19">2019</option>
        <option name="creditcardyear" value="20">2020</option>
        <option name="creditcardyear" value="21">2021</option>
        <option name="creditcardyear" value="22">2022</option>
        <option name="creditcardyear" value="23">2023</option>
        <option name="creditcardyear" value="24">2024</option>
        <option name="creditcardyear" value="25">2025</option>
      </select> <div id="crd_d"></div></TD>

    <TD height="50" align="left" class="cformpl"><a href="card-security-codes.gif" target="_blank" ><img src="images/card-security-codes-small.gif" width="160" height="55" border="0"></a></TD>

    <TD width="325" height="50" class="cformpl"><!--Additional Notes--><br>
      <!--<textarea cols="35" rows="6" name="notestext" id="notestext"><?php //if($_SESSION['pay_notestext'])echo $_SESSION['pay_notestext'];?>
	 		</textarea>--></TD>
  </TR>

  <TR>

    <TD align="center" valign="middle"><a href="card-security-codes.gif" target="_blank" ><span class="cformpl"> </span></a></TD>

    <TD align="left" class="cformpl">The 3 digits Validation Number is located on the back of the <br>

      Visa, Master and Discover cards.<br>

      The 4 digits Validation Number is on the front of the American Express Card. (click image to enlarge) </TD>

    <TD class="cformpl">&nbsp;</TD>
  </TR>

  <TR>

    <TD align="center" valign="bottom" colspan="3">&nbsp;</TD>
  </TR>
</TABLE>		</td>
	</tr>
	<tr>
      <td colspan="3" align="center"><!--<input class="box" name="btnStep1" type="submit" id="btnStep1" value="Proceed &gt;&gt;">-->
                    <a href="#"  onclick="return validateForm(frmCheckout);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','images/proceed_orange.jpg',1)"> <img src="images/proceed_light_org.jpg" name="Image3" width="86" height="27" border="0" id="Image3" /></a></td>
	</tr>
	</form>
</table>
