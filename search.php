<?php
  include "inc/header.php";

  if(isset($_POST['search'])){
    $searchres = $blog->search();
  }
  
?>
      <section class="main container">
        <section class="listpost">
          <h2 id="sresults">Search Results:</h2>
          <?php
            if(!empty($searchres)){
              foreach ($searchres as $key) {
          ?>
          <div class="list">
            <h2><?php echo ucfirst($key['title']);?></h2>
            <div>
              <img src="uploads/thumbnail/<?php echo $key['image'];?>" alt="image"/>
              <div class="desc">
              <p>  <?php
                if(strlen($key['content']) > 300){
                  $content = strip_tags($key['content']);
                  $content = substr($content,0,300);
                  $content = substr($content,0,strrpos($content,' '));
                  echo $content." .....";
                }
                ?>
              </p>
                <a class="readMore" href="post.php?postId=<?php echo $key['postId'];?>">Read More</a>
              </div>
            </div>
          </div>
          <?php
              }
            }else{
              echo "No Content Found.";
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
