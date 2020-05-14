<?php
  require_once "../main.php";

  if(isset($_POST['action']) && $_POST['action'] === "addPostPage"){
    $sql = "select * from tbl_category";
    $res = $db->execQuery($sql,NULL,"select");
    $option = "<option value=''>Select Category</option>";
	if($res){
		foreach ($res as $key) {
		  $option .= "<option value='".$key['catId']."'>".$key['catName']."</option>";
		}
	}
    $html = "<div class='postPage'>
                    <h2>Add New Post</h2>
                    <div class='block'>
                     <form id='postForm' method='post' enctype='multipart/form-data'>
                        <table class='addPostform'>
                            <tr>
                              <td><label>Title</label></td>
                              <td><input required type='text' placeholder='Enter Post Title...' name='title' /></td>
                            </tr>
                            <tr>
                              <td><label>Category</label></td>
                              <td><select required id='select' name='category'>".$option."</select></td>
                            </tr>
                            <tr>
                              <td><label>Date Picker</label></td>
                              <td><input required type='date' name='date' /></td>
                            </tr>
                            <tr>
                                <td><label>Upload Image</label></td>
                                <td><input type='file' id='image' name='image'/></td>
                            </tr>
                            <tr>
                                <td><label>Content</label></td>
                                <td colspan='2'><textarea rows='4' required name='content_body'></textarea></td>
                            </tr>
    						            <tr>
                                <td><input type='hidden' name='action' value='addPost'/></td>
                                <td><input id='addPostBtn' type='submit' Value='Add' /></td>
                            </tr>
                        </table>
                        </form>
                    </div>
                </div>";
    if($html){
      echo $html;
      exit();
    }else{
      echo "<div class='postPage'><p>Failed to Load Content</p></div>";
      exit();
    }
  }

  $post = new Post($db,$validate);

  if(isset($_POST['action']) && $_POST['action'] === "addPost"){
    $post->addPost();
  }

  if(isset($_POST['action']) && $_POST['action'] === "delPost"){
    $post->deletePost();
  }

  if(isset($_POST['action']) && $_POST['action'] === "upPost"){
    $post->updatePost();
  }
?>
