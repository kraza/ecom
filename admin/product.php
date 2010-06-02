<?php
                       if($cat_id and !$mode) { 
                       $conform ="return confirm('Are you sure you want to delete this product.');";
                       echo '<p><strong> Product List for '.$cat_name.'</strong></p>';
                      $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                      $page = ($page == 0 ? 1 : $page);
                      $perpage = 6;//limit in each page
                      $startpoint = ($page * $perpage) - $perpage;
                      
                      $sql = @mysql_query("select * FROM `products` where `cat_id`=$cat_id order by id desc LIMIT $startpoint,$perpage");
                    $i = 0;
                    $active = False;
                    echo '<table width="500" border="0"><tr><td><strong>Product</strong></td><td><strong>Image</strong></td><td><strong>Status</strong></td><td><strong>Action</strong></td></tr>';
                    
                    while($row = mysql_fetch_array($sql)) {
                      $active = True;
                      echo '<tr><td>'.$row[2].'</td><td><img src="../images/'.$row[4].'" alt="'.$row[2].'" width="80" height="80" /></td><td>';
                      if($row[5])
                        echo 'Active';
                      else
                        echo 'InActive';
                      echo '</td><td><A HREF="products.php?cat_id='.$cat_id.'&&product_id='.$row[0].'&&mode=edit">Edit</a> / <A HREF="add_products.php?id='.$cat_id.'&&mode=delete&&product_id='.$row[0].'" onclick = "'.$conform.'">Delete</a></td></tr>';
                      
                    }
                     echo '</table>'; 
                     
                      //show pages
                      if($active){
                      echo Pages("products",$perpage,"products.php?cat_id=".$cat_id."&&");
                      }
                      else{echo "No Product added in this category.";}
                      echo '<br/><br/> </br><a href="products.php?cat_id='.$cat_id.'&&mode=add">Add New </a>';
                      echo '<hr>';
                      }
                      
                    ?>
                
                  <?php if($mode) { 
                    echo ' <p><strong>'.ucfirst($mode).' product for '.$cat_name.'</strong></p>'
                  ?>
                  <form method="POST" action="add_products.php?mode=<?php echo $mode;?>" enctype="multipart/form-data">
                  <table width="500" border="0">
                    
                    <tr>
                      <td width="132"><strong>Product Name</strong></td>
                      <td width="352"><input type="text" name="product_name" value="<?php echo $edit_row[2];?>"><input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
                      <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"></td>
                    </tr>
                    <tr>
                      <td><strong>Image</strong></td>
                      <td><input type="file" name="img" /><?php if($product_id){?><img src="../images/<?php echo $edit_row[4];?>" alt="'.$row[2].'" width="180" height="150" /><?php }?></td>
                    </tr>
                    <tr>
                      <td><strong>Price</strong></td>
                      <td><input type="text" name="price" value= "<?php echo $edit_row[6];?>"> <font color="red">(in $)</font></td>
                    </tr>
                    <tr>
                      <td><strong>Status</strong></td>
                      <td><select name="status" id="status" >
                      <option value="1">Active</option>
                      <option value="0" <?php if(!$edit_row[5] && ($mode == 'edit')) {?> SELECTED <?php } ?>>InActive</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td><strong>Description</strong></td>
                      <td><textarea name="description" rows="5" cols="40"> <?php echo $edit_row[3];?></textarea></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"><input type="submit" name="submit" value="Submit"/> <input type="reset" name="reset" value="Reset"/> </td>
                    </tr>
                  </table>
                  </form>
                  <?php } ?>
