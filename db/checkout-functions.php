<?php

include("db_connect.php");

/*********************************************************
*                 CHECKOUT FUNCTIONS 
*********************************************************/
function saveOrder()
{
	$orderId       = 0;
	$shippingCost  = 5;
	$requiredField = array('txtShippingFirstName', 'txtShippingLastName', 'txtShippingAddress1','txtShippingAddress2','txtShippingCity','txtShippingState','txtShippingPostalCode','txtShippingPhone','txtShippingEmail', 'txtPaymentFirstName', 'txtPaymentLastName', 'txtPaymentAddress1', 'txtPaymentAddress2', 'txtPaymentCity','txtPaymentState', 'txtPaymentPostalCode', 'txtPaymentPhone');
						   
	//if (checkRequiredPost($requiredField)) {
	    extract($_POST);
		
		// make sure the first character in the 
		// customer and city name are properly upper cased
		$hidShippingFirstName = $hidShippingFirstName;
		$hidShippingLastName  = $hidShippingLastName;
		$hidPaymentFirstName  = $hidPaymentFirstName;
		$hidPaymentLastName   = $hidPaymentLastName;
		$hidShippingCity      = $hidShippingCity;
		$hidPaymentCity       = $hidPaymentCity;
	    $hidOrdernotes=$hidOrdernotes;
		$hidDiscount=$hidDiscount;			
		$cartContent = getCartContent();
		$numItem     = count($cartContent);
		     
		$coupon=$_SESSION["coupon_code"];
		$pay_mode=$_SESSION['pay_mode'];
		$p_notes=$_SESSION['pay_notestext'];
		$p_where=$_SESSION['pay_wherefrom'];
		$pcode=$_SESSION["pcode"];
		$ship_method=$_SESSION["shipprice"];
		$tax=$_SESSION["tax"];	
		$final_amt=$_SESSION['final_total'];
		// save order & get order id
		$sql = "INSERT INTO tbl_order(od_date, od_last_update, od_shipping_first_name, od_shipping_last_name, od_shipping_address1, 
		                              od_shipping_address2, od_shipping_phone, od_shipping_state, od_shipping_city, od_shipping_postal_code, od_shipping_email, od_shipping_cost, od_payment_first_name, od_payment_last_name, od_payment_address1, od_payment_address2, od_payment_phone, od_payment_state, od_payment_city, od_payment_postal_code, order_notes ,discount_percent,payment_mode ,hear_abt ,add_note, coupon_code,ship_method,tax,pcode,final_amt,od_status)
                VALUES (NOW(), NOW(), '$hidShippingFirstName', '$hidShippingLastName', '$hidShippingAddress1','$hidShippingAddress2', '$hidShippingPhone', '$hidShippingState', '$hidShippingCity', '$hidShippingPostalCode','$hidShippingEmail','$shippingCost','$hidPaymentFirstName', '$hidPaymentLastName', '$hidPaymentAddress1', '$hidPaymentAddress2', '$hidPaymentPhone', '$hidPaymentState', '$hidPaymentCity', '$hidPaymentPostalCode', '$hidOrdernotes' ,'$hidDiscount', '$pay_mode' ,'$p_where' ,'$p_notes','$coupon','$ship_method','$tax','$pcode','$final_amt','Not Shipped')";
		mysql_query($sql)or die(mysql_error());
		//$result = dbQuery($sql);
		
		// get the order id
		$orderId =mysql_insert_id();
		//$orderId = dbInsertId();

		if($_SESSION['pay_creditcardnum'])
		  {
		  	$pay_creditcardnum=$_SESSION['pay_creditcardnum'];
			$pay_c_vaild=$_SESSION['pay_c_vaild'];
			$pay_c_exp_m=$_SESSION['pay_c_exp_m'];
			$pay_c_exp_y=$_SESSION['pay_c_exp_y'];
		$update_sql=mysql_query("update tbl_order set card_num='$pay_creditcardnum' ,card_vaild_num='$pay_c_vaild' ,card_exp_mnth='$pay_c_exp_m', card_exp_yr='$pay_c_exp_y' where od_id=$orderId");
		  }
		
		$ordernum=date("Ymd").'-BI'.$orderId;
		$update_sql=mysql_query("update tbl_order set order_number='$ordernum' where od_id=$orderId");
		if ($orderId) {
			// save order items
			for ($i = 0; $i < $numItem; $i++) {
			extract($cartContent[$i]);	
			$b_s=addslashes($banner_size);
			$p_s=addslashes($pole_size);
		 	$p_m_n=addslashes($pd_model_number);
			$p_n=addslashes($pd_name);
			
			
			 $sql="INSERT INTO `tbl_order_item` (`order_id` ,`order_number`,`pd_id` ,`pd_model_number`,`pd_name` ,`banner_size` ,`banner_qty` ,`banner_unitprice` ,
				`pole_size` ,`pole_qty` ,`pole_unitprice` ,`color`,`color2`,`banner_custom_text`,`logo_image`,`info_status`)VALUES ('$orderId','$ordernum', '$pd_id','$p_m_n' ,'$p_n', '$b_s', '$banner_qty', '$banner_unitprice', '$p_s', '$pole_qty', '$pole_unitprice','$color', '$color2' ,'$banner_custom_text' ,'$logo_image' ,'$info_status')";
				mysql_query($sql)or die(mysql_error());
				/*$sql = "INSERT INTO tbl_order_item(od_id, pd_id, od_qty)
					VALUES ($orderId, {$cartContent[$i]['pd_id']}, {$cartContent[$i]['ct_qty']})";
			    $result = dbQuery($sql);*/					
			}
		
			
			// update product stock
			for ($i = 0; $i < $numItem; $i++) {
				/*$sql = "UPDATE tbl_product 
				        SET pd_qty = pd_qty - {$cartContent[$i]['ct_qty']}
						WHERE pd_id = {$cartContent[$i]['pd_id']}";
				mysql_query($sql)or die(mysql_error());*/
				//$result = dbQuery($sql);					
			}
			
			
			// then remove the ordered items from cart
			for ($i = 0; $i < $numItem; $i++) {
				$sql = "DELETE FROM tbl_cart
				        WHERE ct_id = {$cartContent[$i]['ct_id']}";
				mysql_query($sql)or die(mysql_error());
				//$result = dbQuery($sql);					
			}							
		}					
	//}
	
	return $orderId;
}

/*
	Get order total amount ( total purchase + shipping cost )
*/
function getOrderAmount($orderId)
{
	$orderAmount = 0;
	
  $sql="SELECT * FROM `tbl_order_item` WHERE order_id=$orderId";
  $result=mysql_query($sql)or die(mysql_error());
  while ($row = mysql_fetch_assoc($result)) {
		$cartContent[] = $row;
	}
     $numItem     = count($cartContent);
		for ($i = 0; $i < $numItem; $i++) {
			extract($cartContent[$i]);
			$total_banner=$banner_unitprice*$banner_qty;
			$total_pole=$pole_unitprice*$pole_qty;
			
			$total_pro_price=$total_pole+$total_banner;
			$orderAmount +=$total_pro_price;
			}
/*	$sql = "SELECT SUM(pd_price * od_qty)
	        FROM tbl_order_item oi, tbl_product p 
		    WHERE oi.pd_id = p.pd_id and oi.od_id = $orderId
			
			UNION
			
			SELECT od_shipping_cost 
			FROM tbl_order
			WHERE od_id = $orderId";
	$result=mysql_query($sql)or die(mysql_error());
	//$result = dbQuery($sql);
     $result_row= mysql_num_rows($result);
	if ($result_row == 2) {
		$row=mysql_fetch_row($result);
		//$row = dbFetchRow($result);
		$totalPurchase = $row[0];
		$row=mysql_fetch_row($result);
		//$row = dbFetchRow($result);
		$shippingCost = $row[0];
		
		$orderAmount = $totalPurchase + $shippingCost;
	}*/	
	
	return $orderAmount;	
}

?>
