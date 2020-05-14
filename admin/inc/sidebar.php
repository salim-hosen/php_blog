<?php
  require_once "../main.php";
  $users = new Users($db,$validate);
  $unread = $users->unreadMessage();
  $sts = Session::get("status");
?>
      <section class="admMain container">
        <aside class="admSidebar">
          <?php
            if($sts == '1' || $sts == '2'){
          ?>
          <div class="admCategory">
            <p><i class="lic fas fa-list-alt"></i>Category<i class="ps fas fa-angle-down"></i></p>
            <ul>
              <li id="addCat">Add Category</li>
              <li id="catList">Category List</li>
            </ul>
          </div>
          <?php
            }
          ?>
          <div class="admPost">
            <p><i class="lic fas fa-file-alt"></i>Post<i class="ps fas fa-angle-down"></i></p>
            <ul>
              <li id="addPostPage">Add Post</li>
              <li id="postListPage">Post List</li>
            </ul>
          </div>
          <?php
            if($sts == '1'){
          ?>
          <div class="blogTitle">
            <p><i class="lic fas fa-edit"></i>Blog Title<i class="ps fas fa-angle-down"></i></p>
            <ul>
              <li id="titlePage">Change Title</li>
            </ul>
          </div>
          <div class="inbox">
            <p><i class="lic fas fa-envelope"></i>Inbox (<b style='color: #008000;'><?php echo $unread;?></b>)<i class="ps fas fa-angle-down"></i></p>
            <ul>
              <li id="contact">Message</li>
            </ul>
          </div>
          <div class="subscribers">
            <p><i class="lic fas fa-users"></i>Subscribers<i class="ps fas fa-angle-down"></i></p>
            <ul>
              <li id="manageSubscribers">Manage Subscribers</li>
            </ul>
          </div>
          <div class="users">
            <p><i class="lic fas fa-user"></i>Users<i class="ps fas fa-angle-down"></i></p>
            <ul>
              <li id="addUser">Add User</li>
              <li id="manageUsers">Manage Users</li>
            </ul>
          </div>
          <?php
            }
          ?>
          <div class="admin">
            <p><i class="lic fas fa-cog"></i>User Settings<i class="ps fas fa-angle-down"></i></p>
            <ul>
              <li id="profilePage">Edit Profile</li>
              <li><a id="logout" href="?logout=yes">Logout</a></li>
            </ul>
          </div>
        </aside>
