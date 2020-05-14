<?php
	include '../main.php';
	$user = new Users($db,$validate);
	$msg = $user->viewMessage();
	$user->readMessage();

?>
<div class="msgPage">
  <h2>Message Details<button class="close" type="button">Close</button></h2>
    <div class="msgBody">
      <div class="showingMsg"><p><b>Message</b></p><?php
        if(!empty($msg)){
          echo $msg[0]['message'];
        }else{
          echo "Database Error. Message is not Found.";
        }
      ?>
      </div>
      <div class="replying">
        <form action="" method="POST" id="replyMsg">
          <table>
            <tbody>
              <tr>
                <td><textarea name='message'></textarea></td>
              </tr>
              <tr>
                <td>
                  <input type="hidden" value="<?php echo $msg[0]['email'];?>" name="email"/>
                  <input type="submit" value="Reply"/>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
</div>
