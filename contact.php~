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
.style3 {font-size: 13px; line-height:18px; text-decoration:none; font-weight:bold; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;}
.style4 {
	font-size: 13px;
	font-weight: bold;
}
.style5 {font-size: 12px; font-weight: bold; }
-->
</style>
<script language="javascript">
function opnwin()
{
    opnew=window.open('http://www.therajan.net/chat.html','windowname','width=240,height=420,location=no, scrollbar=no');
}
</script>
<SCRIPT LANGUAGE="JavaScript">
var randomnumber=Math.floor(Math.random()*11001);


function validateForm() {
		
		var errmess=" ";
		retval=true;
		
   		fname=document.dataform.name.value;
		p1=document.dataform.tel.value;
	  	comm=document.dataform.message.value;
	  	email=document.dataform.email.value;
 		rand=document.dataform.rand.value;
		document.dataform.randomn.value = randomnumber;;
		if ((email=="") || (email.indexOf('@',1)==-1) || (email.indexOf('.',1)==-1))
  	{
  		errmess= errmess + "\nPlease enter a valid email address";
  		retval=false;
 	 }
  
 	 if (fname=="")
  		{
		errmess= errmess+"\nPlease Enter your Name";
		retval=false;
		}  
		
		 		 
  	if  (p1=="")
		{
      	errmess = errmess + "\nPlease Enter Phone #";
     	 retval=false;
     	 }
	if(comm=="")
		{
      	errmess = errmess + "\nPlease Enter your Message";
      	retval=false;
      	}
	  
	if (rand !=randomnumber)	
	{
	 errmess= errmess+"\nPlease Enter right Security code";
		retval=false;
	} 
   if (retval==false)
      	{
     		 alert(errmess);
      	}
   return retval;
   }
</script>
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
                      <td height="31" align="left" valign="middle" background="images/greenbar.gif" style="background-repeat:no-repeat" >&nbsp;&nbsp;&nbsp;<span class="footermenu"><strong><font color="#FFFFFF">our </font></strong></span><span class="style3"><strong><font color="#FFFFFF">c</font></strong></span><span class="footermenu"><strong><font color="#FFFFFF">ontact </font></strong></span><span class="style3"><strong><font color="#FFFFFF">i</font></strong></span><span class="footermenu"><strong><font color="#FFFFFF">nformation</font></strong></span></td>
                    </tr>
                    <tr> 
                      <td height="20">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td align="center" valign="top"><div align="left">
                        <p class="cart">Phone</p>
                        <p><span class="style2">Cell.: 1-951-377-2122<BR>
                          PH..:   1-800-999-7410
                        </span></p>
                        <p class="cart">Email</p>
                        <p> <span class="style2">For Sales &amp; Customer Service:&nbsp;&nbsp;<a href="mailto:Jerry@haredesigns.com">Jerry@haredesigns.com</a><br>
  For Comments:&nbsp;&nbsp;<a href="mailto:feedback@haredesigns.com">Feedback@haredesigns.com</a></span> </p>
                        <p class="cart">Mail</p>
                        <p class="style2">HAREDESIGNS<br>
                            3134, Saratoga St., Riverside<br>
                            California, 92503</p>
                        <p class="cart">or, Fill in the online form below: </p>
                        <form action="thanks.php" method="post" name="dataform" id="dataform"  onSubmit="return validateForm()">
                            <table width="50%" border="0" align="left" cellpadding="0" cellspacing="0">
                              <tbody>
                                <tr>
                                  <td width="101" height="29" class="style47"><div align="left" class="style2">Name:</div></td>
                                  <td width="201" class="style47"><div align="left">
                                    <input name="name" id="name" type="text">                                  
                                  </div></td>
                                </tr>
                                <tr>
                                  <td width="101" class="style47"><div align="left" class="style2">Email:</div></td>
                                  <td width="201" class="style47"><div align="left">
                                    <input name="email" id="email" type="text">                                  
                                  </div></td>
                                </tr>
                                <tr>
                                  <td width="101" height="32" class="style47"><div align="left" class="style2">Phone:</div></td>
                                  <td width="201" class="style47"><div align="left">
                                    <input name="tel" id="tel" type="text">                                  
                                  </div></td>
                                </tr>
                                <tr>
                                  <td width="101" class="style47"><div align="left" class="style2">Message:</div></td>
                                  <td width="201" class="style47"><div align="left">
                                    <textarea name="message" rows="5" id="message"></textarea>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td width="101" class="style47"><div align="left"></div></td>
                                  <td width="201" class="style47"><div align="left"><br>
                                    <table cellpadding=5 cellspacing=0 bgcolor="">
                                      <tr bgcolor="">
                                        <td colspan="2" class="style83"><span class="style77">Security Code</span></td>
                                        </tr>
                                      <tr>
                                        <td bgcolor="#E8E8E8" class="style83" ><b>
                                          <script type="text/javascript">


document.write(randomnumber);
number=randomnumber;

		

                                      </script>
                                          </b></td>
                                        </tr>
                                      <tr>
                                        <td class="style83"><input type="text" name="rand"  maxlength="100" size="10">
                                          <input type="hidden" name="randomn" readonly="readonly" maxlength="100" size="10" >                                          </td>
                                        </tr>
                                      </table>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td width="101" class="style16">&nbsp;</td>
                                  <td width="201" class="style16"><div align="left">
                                    <input name="Submit" value="Send" type="submit">
                                    <input name="Submit2" value="Clear" type="reset">                                  
                                  </div></td>
                                </tr>
                              </tbody>
                            </table>
                          </form></p>
                      </div></td>
                    </tr>
                    
                  </table></td>
              </tr>
            </table></td>
        </tr>
<?php require_once("bottom.php");?>
</table>
</body>
</html>
