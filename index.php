<?php
  include "inc/header.php";
  $title = $blog->getTitle();
  $latestPost = $blog->getLatestPost();
?>
      <section class="titleSection">
          <div class="title">
            <?php
              if($title){
            ?>
            <h2><?php echo $title[0]['title'];?></h2>
            <p><?php echo $title[0]['titleDesc'];?></p>
            <?php
              }
            ?>
          </div>
      </section>
      <section>
        <section class="latest container">
          <div style="overflow:hidden;">
            <h2>Latest Posts</h2>
            <?php
              if($latestPost){
                foreach ($latestPost as $key) {

            ?>
            <div class="lpost">
              <a href="post.php?postId=<?php echo $key['postId'];?>">
                <img src="uploads/thumbnail/<?php echo $key['image'];?>" alt="latest"/>
                <p><?php echo ucfirst($key['title']);?></p>
              </a>
            </div>
            <?php
                }
              }else{
                echo "<p>No New Post Found</p>";
              }
            ?>
          </div>
          <div class="allpost">
            <a href="allpost.php?page=1">See All Posts</a>
          </div>
        </section>
        <section class="popular container">
          <h2>Popular Posts</h2>
          <?php
            if($popularPost){
              foreach ($popularPost as $key) {

          ?>
          <div class="ppost">
            <a href="post.php?postId=<?php echo $key['postId'];?>">
              <img src="uploads/thumbnail/<?php echo $key['image'];?>" alt="latest"/>
              <p><?php echo ucfirst($key['title']);?></p>
            </a>
          </div>
          <?php
              }
            }else{
              echo "<p>No Popular Post Found</p>";
            }
          ?>
        </section>
        <section class="catSubs container">
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
          <div class="subscribe">
            <h2>Subscribe</h2>
            <div class="subsInfo">
              <form id="subscribeForm" method="post" action="">
                <!--<label>Your Email</label>-->
                <input maxlength="80" type="email" required name="email" placeholder="Your Email"/>
                <input type="submit" value="Subscribe"/>
              </form>
            </div>
          </div>
          <div class="contact">
            <h2>Contact</h2>
            <div>
              <form action="" id="contactForm" method="post">
                <table>
                  <tbody>
                    <tr>
                      <td><label>Email</label></td>
                      <td><input type="email" required name="email" placeholder="Your Email"/></td>
                    </tr>
                    <tr>
                      <td><label>Message</label></td>
                      <td><textarea name="message" maxlength="250" required></textarea></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><input type="submit" value="Submit"/></td>
                    </tr>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </section>
      </section>
<?php
  include "inc/footer.php";
?>
