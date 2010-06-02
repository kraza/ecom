<?php
                       if(!$mode) { 
                       $conform ="return confirm('Are you sure you want to delete this category');";
                       echo '<p><strong>Category List</strong></p><p>&nbsp;</p>';
                      $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                      $page = ($page == 0 ? 1 : $page);
                      $perpage = 6;//limit in each page
                      $startpoint = ($page * $perpage) - $perpage;
                      
                      $sql = @mysql_query("select * FROM `category` order by id desc LIMIT $startpoint,$perpage");
                    $i = 0;
                    $active = False;
                    echo '<table width="500" border="0"><tr><td><strong>Product</strong></td><td><strong>Status</strong></td><td><strong>Action</strong></td></tr>';
                    
                    while($row = mysql_fetch_array($sql)) {
                      $active = True;
                      echo '<tr><td>'.$row[1].'</td><td>';
                      if($row[3])
                        echo 'Active';
                      else
                        echo 'InActive';
                      
                      echo '</td><td><A HREF="category.php?id='.$row[0].'&&mode=edit">Edit</a> / <A HREF="add_products.php?type=category&&mode=delete&&id='.$row[0].'" onclick = "'.$conform.'">Delete</a></td></tr>';
                      
                    }
                     echo '</table>'; 
                     
                      //show pages
                      if($active){
                      echo Pages("category",$perpage,"category.php?&&");
                      }
                      else{echo "No Product added in this category.";}
                      echo '<br/><br/> </br><a href="category.php?mode=cat_add">Add New </a>';
                      echo $mode;
                      echo '<hr>';
                      }
                      
                    ?>
                
                  <?php if($mode) { 
                  ?>
                  <p><strong>Add Category </strong></p>
                  
                   <form method="POST" action="add_products.php?mode=<?php echo $mode;?>&&type=category">
                    <table width="500" border="0">
                    <tr>
                      <td width="132"><strong>Category Name</strong></td>
                      <td width="352"><input type="text" name="name" value="<?php echo $edit_row[1];?>">
                      <input type="hidden" name="category_id" value="<?php echo $category_id; ?>"></td>
                    </tr>
                    <tr>
                      <td><strong>Description</strong></td>
                      <td><textarea name="description" rows="5" cols="40"> <?php echo $edit_row[2];?></textarea></td>
                    </tr>
                    <tr>
                      <td><strong>Status</strong></td>
                      <td><select name="status" id="status" >
                      <option value="1">Active</option>
                      <option value="0" <?php if(!$edit_row[3] && ($mode == 'edit')) {?> SELECTED <?php } ?>>InActive</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"><input type="submit" name="submit" value="Submit"/> <input type="reset" name="reset" value="Reset"/> </td>
                    </tr>
                    
                  </table>
                  </form>
                  <?php } ?>
