<?php
  require_once "../main.php";
  $post = new Post($db,$validate);
  $postList = $post->getPostList();
  Session::init();
  $sts = Session::get('status');
?>
<h2>Post List</h2>
<div class="postList">
	<table class="firstTable">
		<thead>
			<tr>
              <th width="3%">Serial</th>
              <th width="23%">Title</th>
              <th width="8%">Category</th>
              <th width="4%">Image</th>
              <th width="25%">Content</th>
              <th width="3%">Creator</th>
              <th width="33%">Action</th>
            </tr>
		</thead>
		<tbody>
		<?php
		if($postList){
		$i = 1;
		foreach ($postList as $key) {
        $content = "";
        if(strlen($key["content"]) > 45){
          $content  = strip_tags($key['content']);
          $content  = substr($content,0,45);
          $content .= " ...";
        }else{
          $content = $key["content"];
        }
		?>
			<tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $key["title"];?></td>
                <td><?php echo $key["catName"]?></td>
                <td><img width="60" height="60" src="../uploads/thumbnail/<?php echo $key["image"];?>" alt="image"/></td>
                <td><?php echo $content;?></td>
                <td><?php
                  if($key['status'] == '1'){
                    echo "Admin";
                  }else if($key['status'] == '2'){
                    echo "Editor";
                  }else if($key['status'] == '3'){
                    echo "Author";
                  }
                ?></td>
                <td id="<?php echo $key["postId"];?>">
                  <?php
                    if($sts == '1' || $sts == '2' || ($sts == '3' && $key['status'] == '3')){
                  ?>
                  <a id="postEdit" href="#">Edit</a><a id="postDel" href="#">Delete</a>
                  <?php
                    }else{
                  ?>
                  <a id="viewPost" target="_blank" href="<?php echo BASE_URL."/post.php?postId=".$key['postId'];?>">View</a>
                  <?php
                    }
                  ?>
                </td>
    </tr>
    <?php }
	}else{
	  echo "<tr><td colspan='7'>No Post Found.</td></tr>";
	}
	?>
		</tbody>
	</table>
</div>
