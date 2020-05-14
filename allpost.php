<?php
  $limit = 0;
  $prev = 0;
  $next = 0;
  if(isset($_GET['page'])){
    $page = $_GET['page'];
    $prev = $next = $page;
    if($page > '1'){
      $limit = (int)($_GET['page']*4)-4;
    }
  }else{
    header("Location: index.php");
  }
  include "inc/header.php";
  $allPost = $blog->getAllPost($limit);
  $totPage = ceil($blog->totalRows("tbl_post")/4);
?>
      <section class="main container">
        <section class="listpost">
          <?php
            if(!empty($allPost)){
              foreach ($allPost as $key) {
          ?>
          <div class="list">
            <h2><?php echo ucfirst($key['title']);?></h2>
            <div>
              <img src="uploads/thumbnail/<?php echo $key['image'];?>" alt="image"/>
              <div class="desc">
                <p><?php
                  if(strlen($key['content']) > 300){
                    $content = strip_tags($key['content']);
                    $content = trim(substr($content,0,300));
                    $content = substr($content,0,strrpos($content,' '));
                    echo $content." .....";
                  }
                ?></p>
                <a class='readMore' href="post.php?postId=<?php echo $key['postId'];?>">Read More</a>
              </div>
            </div>
          </div>
          <?php
              }
            }else{
              echo "No Content Found for this post.";
            }
          ?>

          <div class="pagination">
            <?php
              if($page > 1 && $page <= $totPage){
            ?>
            <a href="?page=<?php echo --$prev;?>">Previous Page</a>
          <?php } if($page < $totPage){ ;?>
            <a href="?page=<?php echo ++$next;?>">Next Page</a>
          <?php } ?>
          </div>
        </section>
        <?php
			include "inc/sidebar.php";
		?>
      </section>
<?php
  include "inc/footer.php";
?>
