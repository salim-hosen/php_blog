<aside class="sidebar">
          <div class="category">
            <h2>Categories</h2>
            <div>
              <?php
                if($catList){
                  foreach ($catList as $key) {
              ?>
              <a href="categories.php?catId=<?php echo $key['catId'];?>"><?php echo ucfirst($key['catName']);?></a>
              <?php
                  }
                }else{
                  echo "<p>No Category Found.</p>";
                }
              ?>
            </div>
          </div>
          <div class="popular">
            <h2>Popular Post</h2>
            <div>
              <?php
                if(!empty($popularPost)){
                  foreach ($popularPost as $key) {
              ?>
              <a href="post.php?postId=<?php echo $key['postId'];?>" class="popPost">
                <div class="popImage">
                  <img src="uploads/thumbnail/<?php echo $key['image'];?>" alt="latest"/>
                </div>
                <div class="popDesc">
                  <h4><?php echo ucfirst($key['title']);?></h4>
                  <p>
                    <?php
                    if(strlen($key['content']) > 50){
                      $content = strip_tags($key['content']);
                      $content = substr($content,0,50);
                      $content = substr($content,0,strrpos($content,' '));
                      echo $content." ...";
                    }
                    ?>
                  </p>
                </div>
              </a>
              <?php
                  }
                }else{
                  echo "<p>No Popular Post Found.</p>";
                }
              ?>
            </div>
          </div>
        </aside>