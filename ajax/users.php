<?php
  require_once "../main.php";
  $users = new Users($db,$validate);

  if(isset($_POST['action']) && $_POST['action'] === "profilePage"){
    $res = $users->getProfile();

    if($res){
      $html = "<div class='profile'>
                <h2>Update Profile</h2>
              <form id='profileForm' autocomplete='off'>
                <table>
                  <tbody>
                    <tr>
                      <td><label>Username</label></td>
                      <td><input required type='text' name='username' value='".$res[0]['username']."'/></td>
                    </tr>
                    <tr>
                      <td><label>Email</label></td>
                      <td><input required type='email' name='email' value='".$res[0]['email']."'/></td>
                    </tr>
                    <tr>
                      <td><label>New Password</label></td>
                      <td><input type='password' name='password' placeholder='Optional'/></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><input type='submit' name='profileSubmit' value='Update' /></td>
                    </tr>
                  </tbody>
                </table>
              </form>
            </div>";
          echo $html;
          exit();
        }else{
          echo "<div class='profile'><p>Failed to Load Profile.</p></div>";
          exit();
        }
  }

  if(isset($_POST['action']) && $_POST['action'] === "upProfile"){
    $users->updateProfile();
  }

  if(isset($_POST['action']) && $_POST['action'] === "delSubscribers"){
    $users->deleteSubscribers();
  }

  if(isset($_POST['action']) && $_POST['action'] === "delMsg"){
    $users->deleteMessage();
  }

  if(isset($_POST['action']) && $_POST['action'] === "replyMsg"){
    $users->replyMessage();
  }

  if(isset($_POST['action']) && $_POST['action'] === "addUser"){
    $users->addUser();
  }

  if(isset($_POST['action']) && $_POST['action'] === "delUser"){
    $users->deleteUser();
  }

  if(isset($_POST['action']) && $_POST['action'] === "resetPassword"){
    $users->resetPassword();
  }

  if(isset($_POST['action']) && $_POST['action'] === "newPassword"){
    $users->updateNewPassword();
  }
?>
