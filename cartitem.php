<?php

$file = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $file);
$pfile = $break[count($break) - 1]; 

?>
<td style="border-right:1px solid #DCDCDC" width="33%" height="175">
<form action="" method="post" name="frmCart" id="frmCart">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr bgcolor="#e5e5e5">
      <td><strong>Product Name#</strong></td>
      <td><strong>UnitPrice</strong></td>
      <td><strong>Quantity</strong></td>
      <td><strong>Total Price</strong></td>
      <?php if($pfile != 'checkout.php') {?><td><strong>Remove</strong></td> <? } ?>
    </tr>
    <?php 
    $total_price = 0;
    while ($row = mysql_fetch_array($cart_table)) {  
    $total_price = $total_price + $row[4];
    ?>
    <tr>
    <td style="border-bottom:1px solid #e5e5e5;">&nbsp; <?php echo $row[1]; ?><input type="hidden" name="id_list[]" value="<?php echo $row[0]; ?>"></td>
    <td style="border-bottom:1px solid #e5e5e5;">&nbsp; <?php echo number_format($row[2], 2, '.', ''); ?><input type="hidden" name="price_list[]" value="<?php echo $row[2]; ?>"></td>
    <?php if($pfile != 'checkout.php') {?>
    <td style="border-bottom:1px solid #e5e5e5;">&nbsp; <input type="text" size="5" name="qt[]" value="<?php echo $row[3]; ?>" /></td>
    <?php } else {?>
    <td style="border-bottom:1px solid #e5e5e5;">&nbsp; <?php echo $row[3];  ?></td>
    <?php }?>
    <td style="border-bottom:1px solid #e5e5e5;">&nbsp; <?php echo number_format($row[4], 2, '.', '');?></td>
    <?php if($pfile != 'checkout.php') {?>
    <td style="border-bottom:1px solid #e5e5e5;">&nbsp;
    <a href='<?php echo "cart.php?action=delete&id=$row[0];" ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="images/booth_image_shopping_cart_img.jpg"  border="0" /></a>
    </td><? } ?>
    </tr>
    <?php } ?>
    <tr bgcolor="#e5e5e5"><td colspan="3" align="right"><strong>Total Amount</strong></td><td colspan="2">&nbsp;<strong><?php echo "$&nbsp;".number_format($total_price, 2, '.', ''); ?></strong><input type="hidden" name="hidtotalamount" id="hidtotalamount" value="<?php echo number_format($total_price, 2, '.', '');?>" /></td></tr>
    <?php if($pfile != 'checkout.php') {?>
    <tr><td colspan="5">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="right"><input type="button" style="width:143px; height:27px; background:url(images/keep_shopping.jpg); border:none;" value=""  ONCLICK="window.location.href='store.php'"></td>
      <td>&nbsp;</td>
      <td colspan="2"><input type="submit" name="btnUpdate" id="btnUpdate"  style="width:123px; height:27px; background:url(images/update_cart.jpg); border:none;" value="" onclick="document.frmCart.action='cart.php?action=update';"/>
      </td>
    </tr>
    <tr><td colspan="5">&nbsp;</td></tr>
    <tr><td colspan="5" align="center"><input type="button" style="width:137px; height:27px; background:url(images/image_proceed_checkout.jpg); border:none;" value=""  ONCLICK="window.location.href='checkout.php?step=1'"></td></tr>
    <?php } ?>
  </table>
</form>
</td>

