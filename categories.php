<?php
  if(isset($_GET['catId'])){
    $catId = $_GET['catId'];
  }else{
    header("Location: index.php");
  }
  include "inc/header.php";
  $catPost = $blog->getPostbyCat($catId);
?>
      <section class="main container">
        <section class="listpost">
          <?php
            if(!empty($catPost)){
              foreach ($catPost as $key) {
          ?>
          <div class="list">
            <h2><?php echo ucfirst($key['title']);?></h2>
            <div>
              <img src="uploads/thumbnail/<?php echo $key['image'];?>" alt="image"/>
              <div class="desc">
                <?php
                if(strlen($key['content']) > 300){
                  $content = strip_tags($key['content']);
                  $content = substr($content,0,300);
                  $content = substr($content,0,strrpos($content,' '));
                  echo $content." .....";
                }
                ?>
                <a class="readMore" href="post.php?postId=<?php echo $key['postId'];?>">Read More</a>
              </div>
            </div>
          </div>
          <?php
              }
            }else{
              echo "No Content Found for this post.";
            }
          ?>
        </section>
        <?php
			include "inc/sidebar.php";
		?>
      </section>
<?php
  include "inc/footer.php";
?>
