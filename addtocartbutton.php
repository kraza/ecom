<script language="JavaScript" type="text/javascript">
function submit_addtocart(catId)
{
//alert("hello"+catId);
window.location.href="cart.php?action=add&p="+catId;
//document.myform.submit();
}

 function setPaymentInfo(isChecked)
		{
			with (window.document.frmCheckout) {
				if (isChecked) {
					txtPaymentFirstName.value  = txtShippingFirstName.value;
					txtPaymentLastName.value   = txtShippingLastName.value;
					txtPaymentAddress1.value   = txtShippingAddress1.value;
					txtPaymentAddress2.value   = txtShippingAddress2.value;
					txtPaymentCity.value       = txtShippingCity.value;
					txtPaymentPostalCode.value = txtShippingPostalCode.value;
					txtPaymentState.value      = txtShippingState.value;
					txtPaymentPhone.value      = txtShippingPhone.value;
					
					txtPaymentFirstName.readOnly  = true;
					txtPaymentLastName.readOnly   = true;
					txtPaymentAddress1.readOnly   = true;
					txtPaymentAddress2.readOnly   = true;			
					txtPaymentCity.readOnly       = true;
					txtPaymentState.readOnly      = true;			
					txtPaymentPostalCode.readOnly = true;
					txtPaymentPhone.readOnly      = true;
		
				} else {
					txtPaymentFirstName.readOnly  = false;
					txtPaymentLastName.readOnly   = false;
					txtPaymentAddress1.readOnly   = false;
					txtPaymentAddress2.readOnly   = false;
					txtPaymentCity.readOnly       = false;
					txtPaymentState.readOnly      = false;
					txtPaymentPostalCode.readOnly = false;
					txtPaymentPhone.readOnly      = false;
		
				}
			}
		}


  function setcredit(isChecked)
		{
			with (window.document.frmCheckout) {
				if (isChecked) {
					creditcardnum.value= '';
					csu.value='';
					creditcardmonth.value ='';
					creditcardyear.value ='';					
					
					creditcardnum.readOnly  = true;
					csu.readOnly   = true;
					creditcardmonth.disabled   = true;
					creditcardyear.disabled   = true;			
	
				} else {
					creditcardnum.readOnly  = false;
					csu.readOnly   = false;
					creditcardmonth.disabled   = false;
					creditcardyear.disabled   = false;
		
				}
			}
		}



  function echeck(str) {
		
				var at="@"
				var dot="."
				var lat=str.indexOf(at)
				var lstr=str.length
				var ldot=str.indexOf(dot)
				if (str.indexOf(at)==-1){
					document.getElementById("s_email").innerHTML = "<font color=\"#FF0000\">Invalid E-mail ID</font>";
				    return false;
				}
		
				if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
					document.getElementById("s_email").innerHTML = "<font color=\"#FF0000\">Invalid E-mail ID</font>";
				    return false;
				}
		
				if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
					document.getElementById("s_email").innerHTML = "<font color=\"#FF0000\">Invalid E-mail ID</font>";
				    return false;
				}
		
				 if (str.indexOf(at,(lat+1))!=-1){
					document.getElementById("s_email").innerHTML = "<font color=\"#FF0000\">Invalid E-mail ID</font>";
				    return false;
				}
		
				 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
					document.getElementById("s_email").innerHTML = "<font color=\"#FF0000\">Invalid E-mail ID</font>";
				    return false;
				}
		
				 if (str.indexOf(dot,(lat+2))==-1){
					document.getElementById("s_email").innerHTML = "<font color=\"#FF0000\">Invalid E-mail ID</font>";
				   return false;
				}
				
				 if (str.indexOf(" ")!=-1){
					document.getElementById("s_email").innerHTML = "<font color=\"#FF0000\">Invalid E-mail ID</font>";
				    return false;
				}
		
				 return true					
			}

function validateForm(contact)
		{
				var varify=true;
				if(""==document.getElementById('txtShippingFirstName').value)
				{   document.getElementById("s_f").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				    varify=false;
				}
				else{ document.getElementById("s_f").innerHTML = '';}
				
				
				if(""==document.getElementById('txtShippingLastName').value)
				{ document.getElementById("s_l").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				  varify=false;
				}
				else{ document.getElementById("s_l").innerHTML = '';}
				
				if(""==document.getElementById('txtShippingAddress1').value)
				{  document.getElementById("s_ad").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				   varify=false;
				}
				else{ document.getElementById("s_ad").innerHTML = '';}
								
				if(""==document.getElementById('txtShippingCity').value)
				{  document.getElementById("s_c").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				   varify=false;
				}
				else{ document.getElementById("s_c").innerHTML = '';}
				
				if(""==document.getElementById('txtShippingState').value)
				{ document.getElementById("s_s").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				  varify=false;
				}
				else{ document.getElementById("s_s").innerHTML = '';}
										
				if(""==document.getElementById('txtShippingPostalCode').value)
				{	document.getElementById("s_z").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				    varify=false;
				}
				else{ document.getElementById("s_z").innerHTML = '';}
								
				if(""==document.getElementById('txtShippingPhone').value)
				{	document.getElementById("s_p").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				    varify=false;
				}
				else{ document.getElementById("s_p").innerHTML = '';}				
				
				if(""==document.getElementById('txtShippingEmail').value)
				{	document.getElementById("s_email").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				    varify=false;
				}
				if(document.getElementById('txtShippingEmail').value!=''){
					emailID=document.getElementById('txtShippingEmail');
					if (echeck(emailID.value)==false){
					//emailID.value=""
					emailID.focus()
					varify=false;
					//return false
					}
				else{ document.getElementById("s_email").innerHTML = '';}	
				}	
				
				if(document.getElementById('chkSame').checked==true)
					    {
						    	
									txtPaymentFirstName.readOnly  = false;
									txtPaymentLastName.readOnly   = false;
									txtPaymentAddress1.readOnly   = false;
									txtPaymentAddress2.readOnly   = false;
									txtPaymentCity.readOnly       = false;
									txtPaymentState.readOnly      = false;
									txtPaymentPostalCode.readOnly = false;
									txtPaymentPhone.readOnly      = false;
									
								
								txtPaymentFirstName.value  = txtShippingFirstName.value;
								txtPaymentLastName.value   = txtShippingLastName.value;
								txtPaymentAddress1.value   = txtShippingAddress1.value;
								txtPaymentAddress2.value   = txtShippingAddress2.value;
								txtPaymentCity.value       = txtShippingCity.value;
								txtPaymentPostalCode.value = txtShippingPostalCode.value;
								txtPaymentState.value      = txtShippingState.value;
								txtPaymentPhone.value      = txtShippingPhone.value;
						
								txtPaymentFirstName.readOnly  = true;
								txtPaymentLastName.readOnly   = true;
								txtPaymentAddress1.readOnly   = true;
								txtPaymentAddress2.readOnly   = true;			
								txtPaymentCity.readOnly       = true;
								txtPaymentState.readOnly      = true;			
								txtPaymentPostalCode.readOnly = true;
								txtPaymentPhone.readOnly      = true;
						
						
						}
				
				
				if(""==document.getElementById('txtPaymentFirstName').value)
				{ document.getElementById("p_f").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				  varify=false;
				}
				else{ document.getElementById("p_f").innerHTML = '';}				
				
				if(""==document.getElementById('txtPaymentLastName').value)
				{ document.getElementById("p_l").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				  varify=false;
				}
				else{ document.getElementById("p_l").innerHTML = '';}				
				
				if(""==document.getElementById('txtPaymentAddress1').value)
				{ document.getElementById("p_ad").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				  varify=false;
				}
				else{ document.getElementById("p_ad").innerHTML = '';}
				
				if(""==document.getElementById('txtPaymentCity').value)
				{ document.getElementById("p_c").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				  varify=false;
				}
				else{ document.getElementById("p_c").innerHTML = '';}
								
				if(""==document.getElementById('txtPaymentState').value)
				{  document.getElementById("p_s").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				   varify=false; }
				else{ document.getElementById("p_s").innerHTML = '';}
										
				if(""==document.getElementById('txtPaymentPostalCode').value)
				{ document.getElementById("p_z").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				  varify=false;	}
				else{ document.getElementById("p_z").innerHTML = '';}
								
				if(""==document.getElementById('txtPaymentPhone').value)
				{	document.getElementById("p_p").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				    varify=false;}
				else{document.getElementById("p_p").innerHTML = ''; }
						
		        if(!document.getElementById('contactmeaboutcc').checked && ""==document.getElementById('creditcardnum').value)
				{
                   document.getElementById("con_cr").innerHTML = "<font color=\"#FF0000\">* Please Enter Payment Information!</font>";
				    varify=false;}
				else{document.getElementById("con_cr").innerHTML = ''; }

			
					if(document.getElementById('creditcardnum').value!="" && !document.getElementById('contactmeaboutcc').checked)
				       {
					    				   
					    if(document.getElementById('csu').value=="")
						  {  document.getElementById("crd_v").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				            varify=false;}
				      else{document.getElementById("crd_v").innerHTML = ''; }
					  
						if(document.getElementById('creditcardmonth').value=="" || document.getElementById('creditcardyear').value=="")
						  {  document.getElementById("crd_d").innerHTML = "<font color=\"#FF0000\">* Required</font>";
				             varify=false;}
				       else{document.getElementById("crd_d").innerHTML = ''; }
						
					   }
					   
				if(varify==true){	   
	
				document.frmCheckout.action="<?php echo $_SERVER['PHP_SELF']; ?>?step=2";
		        document.frmCheckout.submit();
		       }
			 return varify;  
		}

function trim(str)
	{
		return str.replace(/^\s+|\s+$/g,'');
	}
function checkNumber(textBox)
	{
		while (textBox.value.length > 0 && isNaN(textBox.value)) {
			textBox.value = textBox.value.substring(0, textBox.value.length - 1)
		}
		
		textBox.value = trim(textBox.value);
	}
 /*Form validation End here*/ 
  

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

function shipcal() 

 { 

 //document.frmCheckout.mode.value='checkoutCart'; 

// document.frmCheckout.step.value=1; 

 //document.checkout.pcode.value=document.cart_large.pcode.value; 

 //document.cart_large.submit(); 
  document.frmCheckout.action ='checkout.php?step=1';
	document.frmCheckout.submit(); 

}

</script>
