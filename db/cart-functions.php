<?php 
include("db_connect.php");
//require_once 'config.php';
//require_once 'site_setup.php';
/*********************************************************
*                 SHOPPING CART FUNCTIONS 
*********************************************************/
 
function addToCart()
{
	// make sure the product id exist
	if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
		$productId = (int)$_GET['p'];
	} else {
		//header('Location: index.php');
	}
	
	// does the product exist ?
/*	$sql = "SELECT pd_id, pd_qty
	        FROM tbl_product
			WHERE pd_id = $productId";
	$result = dbQuery($sql);
	
	if (dbNumRows($result) != 1) {
		// the product doesn't exist
		header('Location: cart.php');
	} else {
		// how many of this product we
		// have in stock
		$row = dbFetchAssoc($result);
		$currentStock = $row['pd_qty'];

		if ($currentStock == 0) {
			// we no longer have this product in stock
			// show the error message
			setError('The product you requested is no longer in stock');
			header('Location: cart.php');
			exit;
		}

	}*/		
	
	// current session id
  $sid = session_id();
	$_SESSION['ct_session_id']=$sid;
	
  // check if the product is already
	// in cart table for this session
	$sql = "SELECT pd_id,quantity FROM cart_tbl WHERE pd_id = $productId AND sid = '$sid'";
  $query_product = "SELECT `price` from products where `id` = $productId";
  $query = mysql_query($query_product)or die (mysql_error());
  $result = mysql_query($sql)or die (mysql_error());
  $price= mysql_fetch_row($query);
  $cart_table_value = mysql_fetch_row($result);
	$total_record=mysql_num_rows($result);
  if ($total_record == 0) {
    $quantity = 1;
    $totalprice = $price[0];
    $sql = "INSERT INTO cart_tbl (sid, pd_id, quantity, totalprice, created_at, updated_at) VALUES ('$sid', '$productId', '$quantity','$totalprice' ,CURDATE(),CURDATE() )";
    $result = mysql_query($sql)or die (mysql_error());
	} 
  else {
    $quantity = $cart_table_value[1] + 1;
    $totalprice = $quantity * $price[0];
    
		// update product quantity in cart table
    $sql = "UPDATE cart_tbl SET  totalprice='$totalprice' , quantity='$quantity', updated_at = CURDATE() WHERE sid = '$sid' AND pd_id = $productId";		
    $result = mysql_query($sql)or die(mysql_error());		
	}	
	
	// an extra job for us here is to remove abandoned carts.
	// right now the best option is to call this function here
	//deleteAbandonedCart();
	header('Location: cart_list.php');
	//header('Location: ' . $_SESSION['shop_return_url']);				
}

/*
	Get all item in current session
	from shopping cart table
*/
function getCartContent()
{
	$cartContent = array();

	$sid = session_id();	
	$sql="SELECT * FROM cart_tbl  WHERE sid = '$sid'";
	$result=mysql_query($sql)or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$cartContent[] = $row;
	}
	/*$sql = "SELECT ct_id, ct.pd_id, ct_qty, pd_name, pd_price, pd_thumbnail, pd.cat_id
			FROM tbl_cart ct, tbl_product pd, tbl_category cat
			WHERE ct_session_id = '$sid' AND ct.pd_id = pd.pd_id AND cat.cat_id = pd.cat_id";

	$result = dbQuery($sql);
	
	while ($row = dbFetchAssoc($result)) {
		if ($row['pd_thumbnail']) {
			$row['pd_thumbnail'] = WEB_ROOT . 'images/product/' . $row['pd_thumbnail'];
		} else {
			$row['pd_thumbnail'] = WEB_ROOT . 'images/no-image-small.png';
		}
		$cartContent[] = $row;
	}*/
	
	return $cartContent;
}

/*
	Remove an item from the cart
*/
function deleteFromCart($cartId = 0)
{
	if (!$cartId && isset($_GET['id']) && (int)$_GET['id'] > 0) {
		$cartId = (int)$_GET['id'];
	}
	if ($cartId) {	
    $sql  = "DELETE FROM cart_tbl WHERE id = $cartId";
		$result = mysql_query($sql)or die(mysql_error());
	}
	header('Location: cart_list.php');
}

/*
	Update item quantity in shopping cart
*/
function updateCart()
{
  $qty = $_POST['qt'];
  $id_list = $_POST['id_list'];
  $price_list = $_POST['price_list'];
	$numItem=count($qty);
	
	for ($i = 0; $i < $numItem; $i++) {
		$itemQty = $qty;
    $itemId = $id_list;
    $id = (int)$itemId[$i];
  	$newQty = (int)$itemQty[$i];
    $price = $price_list[$i];
    $totalprice = $newQty * $price;
    if ($newQty < 1) {
      $sql  = "DELETE FROM cart_tbl WHERE id = $id";
      $result = mysql_query($sql)or die(mysql_error());
		} else {		
    $sql = "UPDATE cart_tbl SET  totalprice='$totalprice', quantity='$newQty', updated_at = CURDATE() WHERE id = '$id' ";		
    $result = mysql_query($sql)or die(mysql_error());		
    }
  }
		header('Location: cart_list.php');
	exit;
}

function isCartEmpty()
{
	$isEmpty = false;
	
	$sid = session_id();
  $sql = "SELECT `id` FROM cart_tbl WHERE sid = '$sid'";
	$result=mysql_query($sql)or die(mysql_error());
	
	if (mysql_num_rows($result) == 0) {
		$isEmpty = true;
	}	
	
	return $isEmpty;
}

/*
	Delete all cart entries older than one day
*/
function deleteAbandonedCart()
{
	$yesterday = date('Y-m-d H:i:s', mktime(0,0,0, date('m'), date('d') - 1, date('Y')));
	$sql = "DELETE FROM tbl_cart
	        WHERE ct_date < '$yesterday'";
	dbQuery($sql);		
}




// function calculates shipping cost

function ShippingCalc(){ 

	$_SESSION['upsquotezip']=$_SESSION['zip']; // shipment destination zip

	$_SESSION['upsquotecity']=$_SESSION['city']; // shipment destination city

	$query = "SELECT * FROM `tbl_cart` WHERE `ct_session_id` = '".$_SESSION['ct_session_id']."' ORDER BY `pd_id`";

	$SQLresult=mysql_query($query);

	$_SESSION['totweight1']=0;
	$_SESSION['totweight2']=0;
	 //set total weight of products in cart to zero initially



	while($row=mysql_fetch_row($SQLresult)){

		$query2 = "SELECT `pd_id`,`banner_size`,`pole_size`,`banner_qty`,`pole_qty` FROM `tbl_cart` WHERE `ct_id` = '$row[0]';";

		$SQLresult2=mysql_query($query2);

		$row2=mysql_fetch_row($SQLresult2);
if($row2[2]!=''){
$pole_q=mysql_query('select weight_pole from tbl_weight_pole where product_id='.$row2[0].' and size="'.$row2[2].'"');
$pole_r=mysql_fetch_array($pole_q);
$_SESSION['totweight1']=$_SESSION['totweight1']+($pole_r['weight_pole']*$row2[4]);
}
if($row2[1]!=''){
$banner_q=mysql_query('select weight_banner from tbl_weight_banner where product_id='.$row2[0].' and size="'.$row2[1].'"');
$banner_r=mysql_fetch_array($banner_q);
$_SESSION['totweight2']=$_SESSION['totweight2']+($banner_r['weight_banner']*$row2[3]);
}
		 // added weght of each product in total weight

	}// end row loops

	$weight=$_SESSION['totweight1']+$_SESSION['totweight2']=0;;

	if($weight<1){$weight=30;} //if total weight is less then 1 then set weight as 30

	$notes='';

	$city=$_SESSION['city']; //customer city

	$state=$_SESSION['state'];// customer state

	$zip=$_SESSION['zip']; // customer Zip

	$cid=$_SESSION['ct_session_id'];
	
	$country='US'; // customer country
	//$_SESSION['country']=$post['country'];
	// setting the code for each country as required by UPS
	
	if($country=='United States'){$country='US';}
	if($country=='Canada'){$country='CA';}
	if($country=='United Kingdom'){$country='GB';}
	if($country=='Mexico'){$country='MX';}
	if($country=='Albania'){$country='AL';}
	if($country=='Algeria'){$country='DZ';}
	if($country=='American Samoa'){$country='AS';}
	if($country=='Angola'){$country='AO';}
	if($country=='Anguilla'){$country='AI';}
	if($country=='Antigua'){$country='AG';}
	if($country=='Argentina'){$country='AR';}
	if($country=='Armenia'){$country='AM';}
	if($country=='Aruba'){$country='AW';}
	if($country=='Australia'){$country='AU';}
	if($country=='Austria'){$country='AT';}
	if($country=='Azerbaijan'){$country='AZ';}
	if($country=='Bahamas'){$country='BS';}
	if($country=='Bahrain'){$country='BH';}
	if($country=='Bangladesh'){$country='BD';}
	if($country=='Barbados'){$country='BB';}
	if($country=='Belarus'){$country='BY';}
	if($country=='Belgium'){$country='BE';}
	if($country=='Belize'){$country='BZ';}
	if($country=='Benin'){$country='BJ';}
	if($country=='bm_en_home'){$country='BM';}
	if($country=='Bolivia'){$country='BO';}
	if($country=='Bosnia Herzegovina'){$country='BA';}
	if($country=='Botswana'){$country='BW';}
	if($country=='Brazil'){$country='BR';}
	if($country=='British Virgin Islands'){$country='VG';}
	if($country=='Brunei'){$country='BN';}
	if($country=='Bulgaria'){$country='BG';}
	if($country=='Cambodia'){$country='KH';}
	if($country=='Cameroon'){$country='CM';}
	if($country=='Chile'){$country='CL';}
	if($country=='China'){$country='CN';}
	if($country=='Colombia'){$country='CO';}
	if($country=='Congo'){$country='CG';}
	if($country=='Costa Rica'){$country='CR';}
	if($country=='Croatia'){$country='HR';}
	if($country=='Cyprus'){$country='CY';}
	if($country=='Czech Republic'){$country='CZ';}
	if($country=='Denmark'){$country='DK';}
	if($country=='Dominica'){$country='DM';}
	if($country=='Dominican Republic'){$country='DO';}
	if($country=='Ecuador'){$country='EC';}
	if($country=='Egypt'){$country='EG';}
	if($country=='El Salvador'){$country='SV';}
	if($country=='Estonia'){$country='EE';}
	if($country=='Fiji'){$country='FJ';}
	if($country=='Finland'){$country='FI';}
	if($country=='France'){$country='FR';}
	if($country=='French Guiana'){$country='GF';}
	if($country=='Georgia'){$country='GE';}
	if($country=='Germany'){$country='DE';}
	if($country=='Ghana'){$country='GH';}
	if($country=='Greece'){$country='GR';}
	if($country=='Guatemala'){$country='GT';}
	if($country=='Guyana'){$country='GY';}
	if($country=='Haiti'){$country='HT';}
	if($country=='Hong Kong'){$country='HK';}
	if($country=='Hungary'){$country='HU';}
	if($country=='Iceland'){$country='IS';}
	if($country=='India'){$country='IN';}
	if($country=='Indonesia'){$country='ID';}
	if($country=='Ireland'){$country='IE';}
	if($country=='Israel'){$country='IL';}
	if($country=='Italy'){$country='IT';}
	if($country=='Ivory Coast'){$country='CI';}
	if($country=='Jamaica'){$country='JM';}
	if($country=='Japan'){$country='JP';}
	if($country=='Jordan'){$country='JO';}
	if($country=='Kazakhstan'){$country='KZ';}
	if($country=='Kenya'){$country='KE';}
	if($country=='Kosrae Island'){$country='KO';}
	if($country=='Kuwait'){$country='KW';}
	if($country=='Kyrgyzstan'){$country='KG';}
	if($country=='Laos'){$country='LA';}
	if($country=='Latvia'){$country='LV';}
	if($country=='Lebanon'){$country='LB';}
	if($country=='Lesotho'){$country='LS';}
	if($country=='Lithuania'){$country='LT';}
	if($country=='Luxembourg'){$country='LU';}
	if($country=='Macedonia'){$country='MK';}
	if($country=='Malaysia'){$country='MY';}
	if($country=='Maldives'){$country='MV';}
	if($country=='Mali'){$country='ML';}
	if($country=='Malta'){$country='MT';}
	if($country=='Marshall Islands'){$country='MH';}
	if($country=='Mauritius'){$country='MU';}
	if($country=='Mexico'){$country='MX';}
	if($country=='Mongolia'){$country='MN';}
	if($country=='Morocco'){$country='MA';}
	if($country=='Mozambiquee'){$country='MZ';}
	if($country=='Nepal'){$country='NP';}
	if($country=='Netherlands'){$country='NL';}
	if($country=='New Zealand'){$country='NZ';}
	if($country=='Nicaragua'){$country='NI';}
	if($country=='Niger'){$country='NE';}
	if($country=='Nigeria'){$country='NG';}
	if($country=='Northern Mariana Islands'){$country='NB';}
	if($country=='Norway'){$country='NO';}
	if($country=='Oman'){$country='OM';}
	if($country=='Pakistan'){$country='PK';}
	if($country=='Palau'){$country='PW';}
	if($country=='Panama'){$country='PA';}
	if($country=='Papua New Guinea'){$country='PG';}
	if($country=='Paraguay'){$country='PY';}
	if($country=='Peru'){$country='PE';}
	if($country=='Philippines'){$country='PH';}
	if($country=='Poland'){$country='PL';}
	if($country=='Portugal'){$country='PT';}
	if($country=='Puerto Rico'){$country='PR';}
	if($country=='Qatar'){$country='QA';}
	if($country=='Romania'){$country='RO';}
	if($country=='Russia'){$country='RU';}
	if($country=='Saipan'){$country='SP';}
	if($country=='Saudi Arabia'){$country='SA';}
	if($country=='Senegal'){$country='SN';}
	if($country=='Serbia and Montenegro'){$country='CS';}
	if($country=='Seychelles'){$country='SC';}
	if($country=='Singapore'){$country='SG';}
	if($country=='Slovakia'){$country='SK';}
	if($country=='Slovenia'){$country='SI';}
	if($country=='South Africa'){$country='ZA';}
	if($country=='South Korea'){$country='KR';}
	if($country=='Spain'){$country='ES';}
	if($country=='Sri Lanka'){$country='LK';}
	if($country=='St. Kitts and Nevis'){$country='KN';}
	if($country=='St. Lucia'){$country='LC';}
	if($country=='Suriname'){$country='SR';}
	if($country=='Swaziland'){$country='SZ';}
	if($country=='Sweden'){$country='SE';}
	if($country=='Switzerland'){$country='CH';}
	if($country=='Syria'){$country='SY';}
	if($country=='Tadjikistan'){$country='TJ';}
	if($country=='Taiwan'){$country='TW';}
	if($country=='Tanzania'){$country='TZ';}
	if($country=='Thailand'){$country='TH';}
	if($country=='Trinidad and Tobago'){$country='TT';}
	if($country=='Turkey'){$country='TR';}
	if($country=='Turkmenistan'){$country='TM';}
	if($country=='Ukraine'){$country='UA';}
	if($country=='Union Island'){$country='UI';}
	if($country=='United Arab Emirates'){$country='AE';}
	if($country=='Uruguay'){$country='UY';}
	if($country=='US Virgin Islands'){$country='VI';}
	if($country=='Uzbekistan'){$country='UZ';}
	if($country=='Venezuela'){$country='VE';}
	if($country=='Vietnam'){$country='VN';}
	if($country=='Western Samoa'){$country='WS';}
	if($country=='Yap'){$country='YA';}
	if($country=='Yemen'){$country='YE';}
	if($country=='Zambia'){$country='ZM';}
	if($country=='Zimbabwe'){$country='ZW';}
	
	// order is placed on suturday or sunday then set shipdate to monday
	
	$i=0;

	$afterone=date("H",mktime()+3600);

	if($afterone>13){$i++;}

	do{	$i++;

		$shipdate = mktime (0,0,0,date("m",mktime()+3600)  ,date("d",mktime()+3600)+$i,date("Y",mktime()+3600));

		$dayname=strftime("%a", $shipdate);

	}while($dayname=='Sat' || $dayname=='Sun');

	$month=date("m", $shipdate);

	$day=date("d", $shipdate);

	$year=date("Y",$shipdate);

	$date = $year.$month.$day;

	$timeList=UPStime($date, $city, $state, $country, $zip, $weight); // checkes the ups time for shipment

		if(strstr($timeList, '<Candidate>')){

			$citylist=cityXML($timeList);

			$upsFinal[0]='CityList';

			$upsFinal[1]=$citylist;

		}else{

			$upsFinal[0]='MethodList';

			$shippTimeMethods=timeXML($timeList);

			$quoteList=UPSquote($svccode, $country, $zip, $weight);

			$shippQuoteMethods=quoteXML($quoteList, $weight);

			$upsFinal[1]=finalUPS($shippTimeMethods, $shippQuoteMethods);

		}

	return $upsFinal;

}// end main UPS function.


// Ups time for shipment
//UPStime($pickupdate,$country, $zip, $weight){

function UPStime($date, $city, $state, $country, $zip, $weight){

$userid = "laeelin"; //UPS username

$pass = "46824682"; // passowrd

$access_key = "5B9C9F21EDD18580"; // access key

$zip=explode('-',$zip);

$zip=join('',$zip);

$zip=substr($zip,0,5);


//below is xml code to retrieve ups time from ups site
$timeXML = '

<?xml version="1.0"?><AccessRequest xml:lang="en-US"><AccessLicenseNumber>'.$access_key.'</AccessLicenseNumber>

<UserId>'.$userid.'</UserId><Password>'.$pass.'</Password></AccessRequest>



<?xml version="1.0"?>

<TimeInTransitRequest xml:lang="en-US">

   <Request>

      <TransactionReference>

         <CustomerContext>Check Shipment Time</CustomerContext>

         <XpciVersion>1.0002</XpciVersion>

      </TransactionReference>

      <RequestAction>TimeInTransit</RequestAction>

   </Request>

   <TransitFrom>

      <AddressArtifactFormat>

         <PoliticalDivision2>Gainesville</PoliticalDivision2>

         <PoliticalDivision1>FL</PoliticalDivision1>

         <CountryCode>US</CountryCode>

         <PostcodePrimaryLow>32606</PostcodePrimaryLow>

      </AddressArtifactFormat>

   </TransitFrom>

   <TransitTo>

      <AddressArtifactFormat>

         <PoliticalDivision2>'.$city.'</PoliticalDivision2>

         <PoliticalDivision1>'.$state.'</PoliticalDivision1>

         <CountryCode>'.$country.'</CountryCode>

         <PostcodePrimaryLow>'.$zip.'</PostcodePrimaryLow>

      </AddressArtifactFormat>

   </TransitTo>

      <ShipmentWeight>

      <UnitOfMeasurement>

         <Code>LBS</Code>

         <Description>Pounds</Description>

      </UnitOfMeasurement>

      <Weight>'.$weight.'</Weight>

   </ShipmentWeight>

      <InvoiceLineTotal>

      <CurrencyCode>USD</CurrencyCode>

      <MonetaryValue>250.00</MonetaryValue>

   </InvoiceLineTotal>

   <PickupDate>'.$date.'</PickupDate>

</TimeInTransitRequest>';

$ch = curl_init();

$res= curl_setopt ($ch, CURLOPT_URL,"https://www.ups.com/ups.app/xml/TimeInTransit");

curl_setopt ($ch, CURLOPT_HEADER, 0);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $timeXML);

curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

$xml = curl_exec ($ch);
//echo "time  == " .$xml;
curl_close ($ch);

return $xml;

}// end UPStime




//generates UPS quotes for order shipment

function UPSquote($svccode, $country, $zip, $shipweight='10'){

$_SESSION['totweight']=$shipweight;

$rescom='RES'; //residensial

$rate='RDP'; //regular daily pick up

//$dcountry='US';

$userid = "laeelin"; // ups user id

$pass = "46824682"; //ups pass

$access_key = "5B9C9F21EDD18580"; // ups access key

$activity = "activity"; /// UPS activity code

$editweight=$shipweight;

$totalboxes=1;

while($editweight>40){ // 1 box is of 40 lbs, so couning no of boxes as per weight

$editweight=$editweight-40;

$totalboxes++;

}

if($totalboxes>1){$shipweight=$shipweight/$totalboxes;}//if total boxes are greater then 1 set weight of each box



/*

* Minimum required variables:

* $shipweight

* $sZip

* $svccode

* ### UPS Shipping vars

*  01 Next Day Air

*  02 2nd Day Air

*  03 Ground

*  07 Worldwide Express

*  08 Worldwide Expedited

*  11 Standard

*  12 3-Day Select

*  13 Next Day Air Saver

*  14 Next Day Air Early AM

*  54 Worldwide Express Plus

*  59 2nd Day Air AM

*  65 Express Saver

*  go to their website and download the XML manual for further explanation of their codes.

*/


// setting ups service code as per ups.com

if($svccode=='GND'){$svccode='03';}

if($svccode=='3DS'){$svccode='12';}

if($svccode=='2DA'){$svccode='02';}

if($svccode=='1DM'){$svccode='14';}

if($svccode=='1DA'){$svccode='01';}

if($svccode=='1DP'){$svccode='13';}

if($svccode=='STD'){$svccode='11';}

if($svccode=='WWS'){$svccode='08';}

if($svccode=='EXP'){$svccode='07';}

if($svccode=='EHL'){$svccode='54';}

//getting price quote for shipment
$pricexml = '<?xml version="1.0"?><AccessRequest xml:lang="en-US">

<AccessLicenseNumber>'.$access_key.'</AccessLicenseNumber>

<UserId>'.$userid.'</UserId><Password>'.$pass.'</Password></AccessRequest>

<?xml version="1.0"?><RatingServiceSelectionRequest xml:lang="en-US">

<Request><TransactionReference>

<CustomerContext>Rating and Service</CustomerContext>

<XpciVersion>1.0001</XpciVersion></TransactionReference>

<RequestAction>Rate</RequestAction>

<RequestOption>Shop</RequestOption>

</Request>

<PickupType><Code>01</Code></PickupType>

<Shipment><Shipper><Address><PostalCode>32606</PostalCode></Address></Shipper>

<ShipTo><Address><PostalCode>'.$zip.'</PostalCode><CountryCode>'.$country.'</CountryCode></Address></ShipTo>

<Service><Code>'.$svccode.'</Code></Service>

<Package><PackagingType><Code>02</Code><Description>Package</Description></PackagingType>

<Description>Rate Shopping</Description><PackageWeight>

<Weight>'.$shipweight.'</Weight></PackageWeight></Package>

</Shipment></RatingServiceSelectionRequest>';



$ch = curl_init();

$res= curl_setopt ($ch, CURLOPT_URL,"https://www.ups.com/ups.app/xml/Rate");

curl_setopt ($ch, CURLOPT_HEADER, 0);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $pricexml);

curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

$xml = curl_exec ($ch);
//echo "quote:" .$svccode;
//echo "quote:" .$xml;
curl_close ($ch);

return $xml;

}// end UPSquote





function cityXML($cityXML){ // if city entered is wrong then creates citylist for customer to select

$cityXML=explode('<Candidate>',$cityXML);

$count=count($cityXML);

$a=0;

$citys = array();

for($i=1;$i<$count;$i++){

	$cityXML[$i]=strstr($cityXML[$i], '<PoliticalDivision2>');

	$cityXML[$i]=explode('</PoliticalDivision2>', $cityXML[$i]);

	$city=substr($cityXML[$i][0], $endchr);

	if(trim(substr($city,20))!=strtoupper(trim($_SESSION['entered_info']['city']))){

		if(!in_array(substr($city,20),$citys)){

		$citys[$a]=substr($city,20);

		$a++;

		}

	}

}

return $citys;

}




// gets the time for each UPS service
function timeXML($timeXML){

$timeXML=explode('<Service>',$timeXML);

$count=count($timeXML);

$a=0;

//  $shippTimeMethods[code] ... 0 = Code Number ; 1 = Code Desctiption ; 2 = Days ; 3 = ShipDate ; 4 = ArrivalDate

for($i=1;$i<$count;$i++){

	$timeXML2=explode('<Code>', $timeXML[$i]);

	$var=explode('</Code>', $timeXML2[1]);

	$code=$var[0];

	if($code=='GND'){$codenum='03';}

	if($code=='3DS'){$codenum='12';}

	if($code=='2DA'){$codenum='02';}

	if($code=='1DM'){$codenum='14';}

	if($code=='1DA'){$codenum='01';}

	if($code=='1DP'){$codenum='13';}
	
	if($code=='STD'){$codenum='11';}
	
	if($code=='WWS'){$codenum='08';}
	
	if($code=='EXP'){$codenum='07';}

	$times[$code][0]=$codenum;



	$timeXML2=explode('<Description>', $timeXML[$i]);

	$var=explode('</Description>', $timeXML2[1]);

	$times[$code][1]=$var[0];



	$timeXML2=explode('<BusinessTransitDays>', $timeXML[$i]);

	$var=explode('</BusinessTransitDays>', $timeXML2[1]);

	$times[$code][2]=$var[0];



	$timeXML2=explode('<PickupDate>', $timeXML[$i]);

	$var=explode('</PickupDate>', $timeXML2[1]);

	$times[$code][3]=$var[0];



	$timeXML2=explode('<Date>', $timeXML[$i]);

	$var=explode('</Date>', $timeXML2[1]);

	$times[$code][4]=$var[0];

	$a++;

}

return $times;

}



//function that passes the shipping quote



function quoteXML($quoteList, $shipweight){

$markup = $GLOBALS['markup'];

$editweight=$shipweight;

$total_boxes=1;

while($editweight>40){

$editweight=$editweight-40;

$total_boxes++;

}

if($total_boxes>1){$shipweight=40;}

$quoteList=explode('<Service>',$quoteList);

$count=count($quoteList);

$a=0;

//  $shippQuoteMethods ... 0 = Code Desctiption ; 1 = Price

for($i=1;$i<$count;$i++){

	$quoteList2=explode('<Code>', $quoteList[$i]);

	$var=explode('</Code>', $quoteList2[1]);

	$svccode=$var[0];

	if($svccode=='03'){$code='GND';}

	if($svccode=='12'){$code='3DS';}

	if($svccode=='59'){$code='2DS';}

	if($svccode=='02'){$code='2DA';}

	if($svccode=='14'){$code='1DM';}

	if($svccode=='01'){$code='1DA';}

	if($svccode=='13'){$code='1DP';}
	
	if($svccode=='11'){$code='STD';}

	if($svccode=='08'){$code='WWS';}

	if($svccode=='07'){$code='EXP';}

	if($svccode=='54'){$code='EHL';}
	$quotes[$code][0]=$svccode;


	$quoteList2=explode('<TotalCharges><CurrencyCode>USD</CurrencyCode><MonetaryValue>', $quoteList[$i]);

	$var=explode('</MonetaryValue>', $quoteList2[1]);

	$upsquote=$var[0];

	if($svccode=='03'){

		if($upsquote<2){

			$upsquote=14;

		}elseif($upsquote>19){

			//$upsquote=14;

		}

	}elseif($svccode=='12'){

		if($upsquote<3){

			//$upsquote=38;

		}

	}elseif($svccode<'59'){

		if($upsquote<3){

			//$upsquote=68;

		}

	}elseif($svccode=='02'){

		if($upsquote<3){

			//$upsquote=57;

		}

	}elseif($svccode=='14'){

		if($upsquote<3){

			//$upsquote=130;

		}

	}elseif($svccode=='01'){

		if($upsquote<3){

			//$upsquote=100;

		}

	}elseif($svccode=='11'){

		if($upsquote<3){

			//$upsquote=92;

		}

	}else{

			if($upsquote<2){

				//$upsquote=30;

			}

	}

	$upsquote=$upsquote*$total_boxes;

	if($upsquote*.1>$GLOBALS['markup']){

		$upsquote=$upsquote*1.1;

	}else{

		$upsquote=$upsquote+$GLOBALS['markup'];

	}

	$originalups=$upsquote;
	
	//calculating shipping discount

	if($_SESSION['coupon_shipp']=='halfground' || $_SESSION['coupon_shipp']=='free' || $_SESSION['coupon_shipp']=='half' || $_SESSION['coupon_shipp']=='2dafr'){

			if($_SESSION['coupon_shipp']=='free' && $code=='GND'){

			//	$upsquote=$upsquote-22;
				$upsquote=$upsquote;
				if($upsquote<0){$upsquote=0;}

				$_SESSION['couponsavedshipping']=$originalups-$upsquote;

			}elseif($_SESSION['coupon_shipp']=='half'){

				$upsquote=$upsquote/2;

				$_SESSION['couponsavedshipping']=$originalups-$upsquote;

			}elseif($_SESSION['coupon_shipp']=='halfground' && $svccode=='03'){

				$upsquote=$upsquote/2;

				$_SESSION['couponsavedshipping']=$originalups-$upsquote;

			}elseif($_SESSION['coupon_shipp']=='2dafr' && $code=='2DA'){

				$upsquote=$upsquote;
				if($upsquote<0){$upsquote=0;}

				$_SESSION['couponsavedshipping']=$originalups-$upsquote;

			}

		}

	$_SESSION['originalupsprice'][$code]=$originalups+$newmarkup;

	if(strtoupper($post['state'])=='FL' && $code=='GND'){ //half shipping price for FL state

		$upsquote=$upsquote/2;

		$_SESSION['flshipp']='yes';

	}else{

		$_SESSION['flshipp']='no';

	}

/*cocde:GND-->quote:16.75

cocde:3DS-->quote:36.43

cocde:3DS-->quote:62.513

cocde:2DA-->quote:54.93

cocde:1DP-->quote:98.769

cocde:1DM-->quote:140.932

cocde:1DA-->quote:106.601 */

//echo "quote:" .$upsquote;
//echo "quote:" .$svccode;
//echo "quote:";
	/*2:16.75

	2:36.43//3 day select

	2:62.513//2day

	2:54.93

	2:98.769

	2:140.932

	2:106.601*/



	if($upsquote<0){$upsquote=0;}

	$quotes[$code][1]=($upsquote);

	$a++;

}

$_SESSION['upsxml']=$quotes;

return $quotes;

}




// final ups quotes as to appear in drop down

function finalUPS($shippTimeMethods, $shippQuoteMethods){

//  $final[] ... 0 = Short Code ; 1 = Code Number ; 2 = Code Desctiption ; 3 = Days ; 4 = ShipDate ; 5 = ArrivalDate ; 6 = Price

//  $shippTimeMethods[code] ... 0 = Code Number ; 1 = Code Desctiption ; 2 = Days ; 3 = ShipDate ; 4 = ArrivalDate

//  $shippQuoteMethods[code] ... 0 = Code Desctiption ; 1 = Price

$count = count($shippQuoteMethods);

for($i=0;$i<$count;$i++){

	$current=current($shippQuoteMethods);

	$code=key($shippQuoteMethods);

	if($code=='1DA'){

		$shippTimeMethods[$code][0]='01';

		$shippTimeMethods[$code][1]='UPS Next Day Air';

	}elseif($code=='2DA'){

		$shippTimeMethods[$code][0]='02';

		$shippTimeMethods[$code][1]='UPS 2nd Day Air';

	}elseif($code=='3DS'){

		$shippTimeMethods[$code][0]='12';

		$shippTimeMethods[$code][1]='UPS 3 Day Select';

	}elseif($code=='GND'){

		$shippTimeMethods[$code][0]='03';

		$shippTimeMethods[$code][1]='UPS Ground';

	}
elseif($code=='STD'){

		$shippTimeMethods[$code][0]='11';

		$shippTimeMethods[$code][1]='Canada Standard';

	}
	elseif($code=='WWS'){

		$shippTimeMethods[$code][0]='08';

		$shippTimeMethods[$code][1]='Worldwide Expedited';

	}
	elseif($code=='EXP'){

		$shippTimeMethods[$code][0]='07';

		$shippTimeMethods[$code][1]='Worldwide Express';

	}
	elseif($code=='EHL'){

		$shippTimeMethods[$code][0]='54';

		$shippTimeMethods[$code][1]='Worldwide Express Plus';

	}
	next($shippQuoteMethods);

}

$count=0;

$i=0;

$current='';

$code='';





$count = count($shippTimeMethods);

$a=0;

for($i=0;$i<$count;$i++){

	$code=key($shippTimeMethods);

	$current=current($shippTimeMethods);

	if(strlen($current[0])>1){
//making final UPS quote array
		$final[$a][0]=$code;

		$final[$a][1]=$current[0];

		$final[$a][2]=$current[1];

		$final[$a][3]=$current[2];

		$final[$a][4]=$current[3];

		$final[$a][5]=$current[4];

		$final[$a][6]=$shippQuoteMethods[$final[$a][0]][1];

		if($code=='GND'){

			$_SESSION['shipgnddis']=$final[$a][6];

		}
		if($code=='2DA'){

			$_SESSION['shipgnddis1']=$final[$a][6];

		}

		$a++;

	}

	next($shippTimeMethods);

}

return $final;

}



?>
