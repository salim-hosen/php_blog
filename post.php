<?php
  include "inc/header.php";

  if(isset($_GET['postId'])){
    $singlePost = $blog->getPostbyId();
  }
  
?>
      <section class="main container">
        <section class="listpost">
          <div class="compost">
            <?php
              if(!empty($singlePost)){
                $catId = $singlePost[0]['catId'];
            ?>
            <h2><?php echo ucfirst($singlePost[0]['title']);?></h2>
            <p class="poster">Posted by <span><b><?php if($singlePost[0]['status'] === '1'){
              echo "Admin";
            }else if($singlePost[0]['status'] == '2'){
              echo "Editor";
            }else if($singlePost[0]['status'] == '3'){
              echo "Author";
            }
            ?></b> on <?php echo date("d M Y",strtotime($singlePost[0]['postDate']));?></span></p>
            <div>
              <?php
                if($singlePost[0]['image'] !== "noImage.png"){
              ?>
              <img src="uploads/<?php echo $singlePost[0]['image'];?>" alt=""/>
              <?php }?>
              <div class="desc">
                <?php echo $singlePost[0]['content'];?>
              </div>
            </div>
            <?php
          }else{
            echo "Database Error.";
          }
            ?>
          </div>
		  <?php
			include "inc/disqus.php";
		  ?>
        </section>
        <?php
			include "inc/sidebar.php";
		?>
	</section>
	
      <section class="relatedPost container">
        <div style="overflow:hidden;">
          <h2>Related Posts</h2>
          <?php
            if(isset($catId)){
              $relPost = $blog->getRelatedPost($catId,$_GET['postId']);
              if(!empty($relPost)){
                foreach ($relPost as $key) {
          ?>
          <div class="lpost">
            <a href="post.php?postId=<?php echo $key['postId'];?>">
              <img src="uploads/thumbnail/<?php echo $key['image'];?>" alt=""/>
              <p><?php echo ucfirst($key['title']);?></p>
            </a>
          </div>
          <?php
                }
              }else{
                echo "No Related Post Found.";
              }
          }else{
            echo "No Related Post Found.";
          }
          ?>
        </div>
      </section>
<?php
  include "inc/footer.php";
?>
