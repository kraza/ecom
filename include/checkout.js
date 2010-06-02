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

function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid E-mail ID")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Invalid E-mail ID")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

 		 return true					
	}

function validateForm(contact)
{
        alert('testtest testest est');
		if(""==document.getElementById('txtShippingFirstName').value)
		{
		alert("Enter first name");
		return false;
		}
		
		if(""==document.getElementById('txtShippingLastName').value)
		{
		alert("Enter last name");
		return false;
		}
		
		if(""==document.getElementById('txtShippingAddress1').value)
		{
		alert("Please provide street address  we cannot ship to a PO Box ");
		return false;
		}
		
		if(""==document.getElementById('txtShippingCity').value)
		{
		alert("Enter city");
		return false;
		}
		if(""==document.getElementById('txtShippingState').value)
		{
		alert("Enter state");
		return false;
		}		
		if(""==document.getElementById('txtShippingPostalCode').value)
		{
		alert("Enter postal/zip code");
		return false;
		}
		if(""==document.getElementById('txtShippingPhone').value)
		{
		alert("Enter phone number");
		return false;
		}
		
		
		if(""==document.getElementById('txtShippingEmail').value)
		{
		alert("Please Enter Email Id");
		return false;
		}
		emailID=document.getElementById('txtShippingEmail');
		if (echeck(emailID.value)==false){
		emailID.value=""
		emailID.focus()
		return false
	    }
		
		if(""==document.getElementById('txtPaymentFirstName').value)
		{
		alert("Enter first name");
		return false;
		}
		
		if(""==document.getElementById('txtPaymentLastName').value)
		{
		alert("Enter last name");
		return false;
		}
		
		if(""==document.getElementById('txtPaymentAddress1').value)
		{
		alert("Enter address");
		return false;
		}
		
		if(""==document.getElementById('txtPaymentCity').value)
		{
		alert("Enter city");
		return false;
		}
		if(""==document.getElementById('txtPaymentState').value)
		{
		alert("Enter state");
		return false;
		}		
		if(""==document.getElementById('txtPaymentPostalCode').value)
		{
		alert("Enter postal/zip code");
		return false;
		}
		if(""==document.getElementById('txtPaymentPhone').value)
		{
		alert("Enter phone number");
		return false;
		}
}

function checkShippingAndPaymentInfo()
{
	with (window.document.frmCheckout) {
		if (isEmpty(txtShippingFirstName, 'Enter first name')) {
			return false;
		} else if (isEmpty(txtShippingLastName, 'Enter last name')) {
			return false;
		} else if (isEmpty(txtShippingAddress1, 'Enter shipping address')) {
			return false;
		} else if (isEmpty(txtShippingPhone, 'Enter phone number')) {
			return false;
		} else if (isEmpty(txtShippingState, 'Enter shipping address state')) {
			return false;
		} else if (isEmpty(txtShippingCity, 'Enter shipping address city')) {
			return false;
		} else if (isEmpty(txtShippingPostalCode, 'Enter the shipping address postal/zip code')) {
			return false;
		} else if (isEmpty(txtPaymentFirstName, 'Enter first name')) {
			return false;
		} else if (isEmpty(txtPaymentLastName, 'Enter last name')) {
			return false;
		} else if (isEmpty(txtPaymentAddress1, 'Enter Payment address')) {
			return false;
		} else if (isEmpty(txtPaymentPhone, 'Enter phone number')) {
			return false;
		} else if (isEmpty(txtPaymentState, 'Enter Payment address state')) {
			return false;
		} else if (isEmpty(txtPaymentCity, 'Enter Payment address city')) {
			return false;
		} else if (isEmpty(txtPaymentPostalCode, 'Enter the Payment address postal/zip code')) {
			return false;
		} else {
			return true;
		}
	}
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