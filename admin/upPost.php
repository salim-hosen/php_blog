<?php
	require_once "../main.php";
	$post = new Post($db,$validate);
	$res = $post->getPostForUpdate();
?>
<div class="postPage">
      <h2>Update This Post<button class="close" type="button">Close</button></h2>
      <div class="upBody">
       <form id='upForm' method='post' enctype='multipart/form-data'>
          <table class='form'>
			<?php
				if(!empty($res)){
			?>
              <tr>
                <td><label>Title</label></td>
                <td><input required type='text' value="<?php echo $res[0]['title'];?>" name='title' /></td>
                <td rowspan="4"><img src="../uploads/thumbnail/<?php echo $res[0]['image'];?>" id="showImage" alt="image"/></td>
              </tr>
              <tr>
                <td><label>Category</label></td>
                <td>
                  <select required id='category' name='category'>
                    <option value="">Select Cateogy</option>
                    <?php
                      $sql = "select * from tbl_category order by catId desc";
                      $res2 = $db->execQuery($sql,NULL,"select");
                      if($res2){
                        foreach ($res2 as $key) {
                    ?>
                    <option <?php
						if($res[0]['catId'] == $key['catId'])echo "selected";
					?> value="<?php echo $key['catId'];?>"><?php echo $key['catName'];?></option>
                    <?php
                        }
                      }else{
                        echo "<option value=''>No Category Found</option>";
                      }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td><label>Date Picker</label></td>
                <td><input required type='date' value="<?php echo $res[0]['postDate'];?>" name='date' /></td>
              </tr>
              <tr>
                  <td><label>Upload Image</label></td>
                  <td><input type='file' id='image' name='image'/></td>
              </tr>
              <tr>
                  <td><label>Content</label></td>
                  <td colspan="2"><textarea required name='content'><?php echo $res[0]['content'];?></textarea></td>
              </tr>
              <tr>
                  <td>
                    <input type='hidden' name='action' value='upPost' />
                    <input type='hidden' name='postId' value="<?php echo $res[0]['postId'];?>" />
                    <input type='hidden' name='oldImage' value="<?php echo $res[0]['image'];?>" />
                  </td>
                  <td>
                    <input id='addPostBtn' type='submit' name='upPost' Value='Update' />
                    <input class="cancel" type='submit' name='cancel' Value='Cancel' />
                  </td>
              </tr>
			  <?php
				}else{
					echo "<tr><td>Failed to Load Data.</td></tr>";
				}
			  ?>
          </table>
        </form>
      </div>
    </div>