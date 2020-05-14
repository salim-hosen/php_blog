<?php include "inc/header.php";?>
<?php include "inc/sidebar.php";?>
        <section class="admContent">
          <div class="welcome">
            <h2>Welcome <span style='color:#606060;'><?php
              echo Session::get("username");
            ?></span></h2>
            <p>You are logged as <?php
              $status = Session::get("status");
              if($status == '1'){
                echo "Admin";
              }else if($status == '2'){
                echo "Editor";
              }else if($status == "3"){
                echo "Author";
              }
            ?></p>
          </div>
        </section>
      </section>
      <div class="lcon">
        <div class="loader"></div>
      </div>
<?php include "inc/footer.php";?>
