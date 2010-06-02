<?php
/*if (!defined('WEB_ROOT')
    || !isset($_GET['step']) || (int)$_GET['step'] != 1) {
	exit;
}*/

$errorMessage = '&nbsp;';
?>
<script language="JavaScript" type="text/javascript" src="../site/checkout.js"></script>
<table width="550" border="1" align="center" cellpadding="10" cellspacing="0">
    <tr> 
        <td><strong>Step 1 Of 3 : Enter Shipping And Payment Information</strong> </td>
    </tr>
</table>
<p id="errorMessage"><?php echo $errorMessage; ?></p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?step=2" method="post" name="frmCheckout" id="frmCheckout" 
onsubmit="return validateForm(frmCheckout);" >
    <table width="550" border="1" align="center" cellpadding="5" cellspacing="1" class="entryTable">
        <tr class="entryTableHeader"> 
            <td colspan="2"><strong>Shipping Information</strong></td>
        </tr>
        <tr> 
            <td width="150" class="label">First Name</td>
            <td class="content"><input name="txtShippingFirstName" type="text" class="box" id="txtShippingFirstName" size="30" maxlength="50"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Last Name</td>
            <td class="content"><input name="txtShippingLastName" type="text" class="box" id="txtShippingLastName" size="30" maxlength="50"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address1</td>
            <td class="content"><input name="txtShippingAddress1" type="text" class="box" id="txtShippingAddress1" size="50" maxlength="100"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address2</td>
            <td class="content"><input name="txtShippingAddress2" type="text" class="box" id="txtShippingAddress2" size="50" maxlength="100"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Phone Number</td>
            <td class="content"><input name="txtShippingPhone" type="text" class="box" id="txtShippingPhone" size="30" maxlength="32" onkeyup="checkNumber(this);"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Province / State</td>
            <td class="content"><input name="txtShippingState" type="text" class="box" id="txtShippingState" size="30" maxlength="32"></td>
        </tr>
        <tr> 
            <td width="150" class="label">City</td>
            <td class="content"><input name="txtShippingCity" type="text" class="box" id="txtShippingCity" size="30" maxlength="32"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Postal / Zip Code</td>
            <td class="content"><input name="txtShippingPostalCode" type="text" class="box" id="txtShippingPostalCode" size="10" maxlength="10" onkeyup="checkNumber(this);"></td>
        </tr>
    </table>
    <p>&nbsp;</p>
    <table width="550" border="1" align="center" cellpadding="5" cellspacing="1" class="entryTable">
        <tr class="entryTableHeader"> 
            <td width="150"><strong>Payment Information</strong></td>
            <td><input type="checkbox" name="chkSame" id="chkSame" value="checkbox" onClick="setPaymentInfo(this.checked);"> 
                <label for="chkSame" style="cursor:pointer">Same as shipping information</label></td>
        </tr>
        <tr> 
            <td width="150" class="label">First Name</td>
            <td class="content"><input name="txtPaymentFirstName" type="text" class="box" id="txtPaymentFirstName" size="30" maxlength="50"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Last Name</td>
            <td class="content"><input name="txtPaymentLastName" type="text" class="box" id="txtPaymentLastName" size="30" maxlength="50"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address1</td>
            <td class="content"><input name="txtPaymentAddress1" type="text" class="box" id="txtPaymentAddress1" size="50" maxlength="100"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address2</td>
            <td class="content"><input name="txtPaymentAddress2" type="text" class="box" id="txtPaymentAddress2" size="50" maxlength="100"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Phone Number</td>
            <td class="content"><input name="txtPaymentPhone" type="text" class="box" id="txtPaymentPhone" size="30" maxlength="32" onkeyup="checkNumber(this);"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Province / State</td>
            <td class="content"><input name="txtPaymentState" type="text" class="box" id="txtPaymentState" size="30" maxlength="32"></td>
        </tr>
        <tr> 
            <td width="150" class="label">City</td>
            <td class="content"><input name="txtPaymentCity" type="text" class="box" id="txtPaymentCity" size="30" maxlength="32"></td>
        </tr>
        <tr> 
            <td width="150" class="label">Postal / Zip Code</td>
            <td class="content"><input name="txtPaymentPostalCode" type="text" class="box" id="txtPaymentPostalCode" size="10" maxlength="10" onkeyup="checkNumber(this);"></td>
        </tr>
    </table>
    <p>&nbsp;</p>
	<TABLE border="0" cellspacing="0" cellpadding="2" width="550" align="center">

  <TR bgcolor="#ECE9D8">

    <TD height="35" colspan="3" align="center" valign="middle" bgcolor="#274B85" class="subhead" >Payment Information</TD>

  </TR>

  <TR>

    <TD align="left" colspan="3" class="cformpl"><input name="contactmeaboutcc" type="checkbox" value="contact" onclick="paycheck1();" />    

    Please click here and we will contact you for Payment information.</TD>

  </TR>

  <TR>

    <TD height="50" colspan="2" align="left" class="cformpl">&nbsp;<IMG border="0" src="images/amexlogo.gif"> </TD>

    <TD width="325" height="50" class="cformpl"><span class="cform">How did you hear about us?<br>

      </span>

        <SELECT name="wherefrom" style="width:200px;" >

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

    <TD height="50" align="left" class="cformpl">Card Number<br>

        <INPUT type="text" name="creditcardnum" size="22" value="<!--creditcardnum-->" onfocus="paycheck2();">    </TD>

    <TD align="left" class="cformpl"><span class="cformp">Validation&nbsp;Number<br>

          <INPUT type="text" name="csu" size="5" value="<!--csu-->">

    </span></TD>

    <TD width="325" height="50" class="cformpl">&nbsp;</TD>

  </TR>

  <TR>

    <TD height="50" align="left" class="cformpl">Expiration<br>

      <SELECT name="creditcardmonth">

          <option value="01" selected="selected" name="creditcardmonth">01 - January

          <option name="creditcardmonth" value="02">02 - February

          <option name="creditcardmonth" value="03">03 - March

          <option name="creditcardmonth" value="04">04 - April

          <option name="creditcardmonth" value="05">05 - May

          <option name="creditcardmonth" value="06">06 - June

          <option name="creditcardmonth" value="07">07 - July

          <option name="creditcardmonth" value="08">08 - August

          <option name="creditcardmonth" value="09">09 - September

          <option name="creditcardmonth" value="10">10 - October

          <option name="creditcardmonth" value="11">11 - November

          <option name="creditcardmonth" value="12">12 - December

      </SELECT>

        <SELECT name="creditcardyear">

          <option name="creditcardyear" value="09">2009

          <option name="creditcardyear" value="10">2010

          <option name="creditcardyear" value="11">2011

          <option name="creditcardyear" value="12">2012

          <option name="creditcardyear" value="13">2013

          <option name="creditcardyear" value="14">2014

          <option name="creditcardyear" value="15">2015

          <option name="creditcardyear" value="16">2016

          <option name="creditcardyear" value="17">2017

          <option name="creditcardyear" value="18">2018

          <option name="creditcardyear" value="19">2019

          <option name="creditcardyear" value="20">2020

          <option name="creditcardyear" value="21">2021

          <option name="creditcardyear" value="22">2022

          <option name="creditcardyear" value="23">2023

          <option name="creditcardyear" value="24">2024

          <option name="creditcardyear" value="25">2025

      </SELECT>    </TD>

    <TD height="50" align="left" class="cformpl"><a href="card-security-codes.gif" target="_blank" ><img src="images/card-security-codes-small.gif" width="160" height="55" border="0"></a></TD>

    <TD width="325" height="50" class="cformpl">Additional Notes<br>

      <TEXTAREA cols="35" rows="6" name="notestext"><!--notestext-->

      </TEXTAREA></TD>

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

</TABLE>
    <!--<table width="550" border="1" align="center" cellpadding="5" cellspacing="1" class="entryTable">
      <tr>
        <td width="150" class="entryTableHeader">Payment Method </td>
        <td class="content">
        <input name="optPayment" type="radio" id="optPaypal" value="paypal" checked="checked" />
        <label for="optPaypal" style="cursor:pointer">Paypal</label>
        <input name="optPayment" type="radio" value="cod" id="optCod" />
        <label for="optCod" style="cursor:pointer">Cash on Delivery</label></td>
      </tr>
    </table>-->
    <p>&nbsp;</p>
    <p align="center"> 
        <input class="box" name="btnStep1" type="submit" id="btnStep1" value="Proceed &gt;&gt;">
    </p>
</form>
