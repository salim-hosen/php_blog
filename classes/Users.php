
<?php

use PHPMailer\PHPMailer\PHPMailer;
require '../vendor/autoload.php';

  class Users{
    private $db;
    private $validate;

    public function __construct($db,$validate){
      $this->db        =  $db;
      $this->validate  =  $validate;
    }

    public function getProfile(){
      Session::init();
      $userId = Session::get("userId");
      $sql = "select * from tbl_user where userId=:userId limit 1";
      $data = array("userId" => $userId);
      $res = $this->db->execQuery($sql,$data,"select");
      return $res;
    }

    public function getTitle(){
      $sql = "select * from tbl_title limit 1";
      $res = $this->db->execQuery($sql,NULL,"select");
      return $res;
    }

    public function updateProfile(){

      Session::init();
      $userId = Session::get("userId");

      $this->validate->data("username")->isEmpty()->checkLength();
      $this->validate->data("email")->isEmpty()->checkEmail()->isExists(array("email"=>$_POST['email'],"userId"=>$userId),"tbl_user");

      if($this->validate->submit()){
        if(empty($_POST['password'])){
          $sql = "update tbl_user set username=:username,email=:email where userId=:userId";
          $data = array("username" => $this->validate->value['username'],"email"=>$this->validate->value['email'],"userId"=>$userId);
          $res = $this->db->execQuery($sql,$data,"update");
          if($res){
            echo "success";
            exit();
          }else{
            echo "<b>Error!</b> Failed to Update Profile.";
            exit();
          }
        }else{
          $this->validate->data("password")->isEmpty()->checkLength();
          $sql = "update tbl_user set username=:username,password=:password,email=:email where userId=:userId";
          $data = array("username" => $this->validate->value['username'],"password"=>md5($this->validate->value['password']),"email"=>$this->validate->value['email'],"userId"=>$userId);
          $res = $this->db->execQuery($sql,$data,"update");
          if($res){
            echo "success";
            exit();
          }else{
            echo "<b>Error!</b> Failed to Update Profile.";
            exit();
          }
        }
      }else{
        echo "<b>Error!</b> Failed to Update Profile.";
        exit();
      }
    }

    public function updateTitle(){
        $this->validate->data("title")->isEmpty()->checkLength();

        if($this->validate->submit()){
          $this->validate->data("titleDesc");
          $sql = "update tbl_title set title=:title,titleDesc=:titleDesc where tId=:tId";
          $data = array("title" => $this->validate->value['title'],"titleDesc" => $this->validate->value['titleDesc'],"tId"=>$_POST['tId']);
          $res = $this->db->execQuery($sql,$data,"update");
          if($res){
            echo "success";
            exit();
          }else{
            echo "<b>Error!</b> Failed to Update Title.";
            exit();
          }
        }else{
          echo "<b>Error!</b> Failed to Update Title.";
          exit();
        }
    }

    public function getSubscribers(){
      $sql = "select * from tbl_subscriber";
      $res = $this->db->execQuery($sql,NULL,"select");
      return $res;
    }

    public function deleteSubscribers(){
      $sql = "delete from tbl_subscriber where subId=:subId";
      $res = $this->db->execQuery($sql,array("subId" => $_POST['id']),"delete");
      if($res){
        echo "success";
        exit();
      }else{
        echo "Failed to Delete.";
        exit();
      }
    }

    public function getMessages(){
      $sql = "select * from tbl_contact order by status desc";
      $res = $this->db->execQuery($sql,NULL,"select");
      return $res;
    }

    public function deleteMessage(){
      $sql = "delete from tbl_contact where conId=:conId";
      $res = $this->db->execQuery($sql,array("conId" => $_POST['id']),"delete");
      if($res){
        echo "success";
        exit();
      }else{
        echo "Failed to Delete.";
        exit();
      }
    }

    public function viewMessage(){
      $sql = "select message,email from tbl_contact where conId=:conId";
      $res = $this->db->execQuery($sql,array("conId"=>$_POST['id']),"select");
      return $res;
    }

    public function replyMessage(){
      
	  $this->validate->data("message")->isEmpty();
	  
	  $email = $_POST['email'];
	  $message = $this->validate->value['message'];
	  $subject = "Reply from sBlog";
	  
      if($this->validate->submit() && $this->sendMail($email,$message,$subject)){
	    echo "success";
      }else{
        echo "Failed to Send Email.";
        exit();
      }
    }
	
	public function sendMail($email,$message,$subject){
		
			$mail = new PHPMailer;

			$mail->isSMTP();

			$mail->SMTPDebug = 0;

			//$mail->Host = 'smtp.gmail.com';

			$mail->Host = gethostbyname('smtp.gmail.com');

			$mail->SMTPOptions = array(
			  'ssl' => array(
				  'verify_peer' => false,
				  'verify_peer_name' => false,
				  'allow_self_signed' => true
			  )
			  );

			$mail->Port = 587;

			$mail->SMTPSecure = 'tls';

			$mail->SMTPAuth = true;

			$mail->Username = "salimhosen583@gmail.com";

			$mail->Password = "$@l!M@01762473884";

			$mail->setFrom('salimhosen583@gmail.com');

			$mail->addReplyTo('salimhosen583@gmail.com');

			$mail->addAddress($email);

			$mail->Subject = $subject;

			$mail->msgHTML($message);

			$mail->AltBody = $message;

			if (!$mail->send()) {
				return false;
			} else {
				return true;
			}
		
	}

    public function unreadMessage(){
      $sql = "select * from tbl_contact where status = '1'";
      $res = $this->db->execQuery($sql,NULL,"select");
      if(empty($res)){
        return 0;
      }else{
        return count($res);
      }
    }

    public function readMessage(){
      $sql = "update tbl_contact set status='0' where conId=:conId";
      $res = $this->db->execQuery($sql,array("conId"=>$_POST['id']),"update");
      return false;
    }

    public function addUser(){
      $this->validate->data("username")->isEmpty()->checkLength()->isExists(array("username"=>$this->validate->value['username']),"tbl_user");
      $this->validate->data("email")->isEmpty()->checkEmail()->isExists(array("email"=>$this->validate->value['email']),"tbl_user");
      $this->validate->data("password")->isEmpty()->checkLength();
      $this->validate->data("role")->isEmpty();
      if($this->validate->submit()){
        $sql = "insert into tbl_user(username,email,password,status)values(:username,:email,:password,:status)";
        $data = array(
          "username" => $this->validate->value['username'],
          "email" => $this->validate->value['email'],
          "password" => md5($this->validate->value['password']),
          "status" => $this->validate->value['role'],
        );
        $res = $this->db->execQuery($sql,$data,"insert");
        if($res){
          echo "success";
          exit();
        }else{
          echo "Failed to Add User.";
          exit();
        }
      }else{
        echo "Failed to Add User.";
        exit();
      }
    }

    public function getUsers(){
      $sql = "select * from tbl_user";
      $res = $this->db->execQuery($sql,NULL,"select");
      return $res;
    }

    public function deleteUser(){
      $sql = "delete from tbl_user where userId=:userId";
      $res = $this->db->execQuery($sql,array("userId" => $_POST['userId']),"delete");
      if($res){
        echo "success";
        exit();
      }else{
        echo "Failed to Delete User.";
        exit();
      }
    }

    public function resetPassword(){
		
      $this->validate->data("email")->isEmpty()->checkEmail();
      
	  $email = $this->validate->value['email'];
      
	  $sql = "select email,vcode from tbl_user where email = :email";
      
	  $res = $this->db->execQuery($sql,array("email" => $email),"select");
      
	  if(!empty($res[0]['vcode'])){
        echo "Email Already Sent.";
        exit();
      }
	  
      if($res && $this->validate->submit()){

                                        // Passing `true` enables exceptions
          try {

              $vcode = md5(time());
              //Content
			  
              $subject = 'sBlog Users Password Reset';
              
			  $message = "<p>To Reset Password follow the following link. <a href='".BASE_URL."/admin/newPassword.php?email=
              ".urlencode($email)."&vcode=".$vcode."'>Click Here.</a></p>";
             
			 /*$mail->AltBody = "To Reset Password copy the following link in your address bar and hit enter. ".BASE_URL."/admin/newPassword.php?email=
              ".urlencode($email)."&vcode=".$vcode;
				*/
				
              $this->sendMail($email,$message,$subject);
			  
              $sql = "update tbl_user set vcode = :vcode where email=:email";
              $data = array("vcode" => $vcode,"email" => $email);
              $res = $this->db->execQuery($sql,$data,"update");
              if($res){
                echo "success";
                exit();
              }else{
                echo "Failed to Send Email.";
                exit();
              }
          } catch (Exception $e) {
              echo 'Message could not be sent. Mailer Error: ';
              echo $mail->ErrorInfo;
              exit();
          }
      }else{
        echo "Email Address Not Found.";
        exit();
      }
    }

    public function updateNewPassword(){

      $this->validate->data("password")->isEmpty()->checkLength();
      $this->validate->data("code")->isEmpty();
      $this->validate->data("email");

      $sql = "select userId from tbl_user where email=:email and vcode=:vcode";
      $res = $this->db->execQuery($sql,array("email" => $this->validate->value['email'],"vcode" => $this->validate->value['code']),"select");
      $userId = $res[0]['userId'];
      if($res){
        $sql = "update tbl_user set password=:password where userId=:userId and email=:email";
        $data = array("password" => md5($this->validate->value['password']),"userId" => $userId,"email" => $this->validate->value['email']);
        $res = $this->db->execQuery($sql,$data,"update");
        if($res){
          $sql = "update tbl_user set vcode='' where userId=:userId";
          $this->db->execQuery($sql,array("userId" => $userId),"update");
          echo "success";
          exit();
        }else{
          echo "Failed to Change Password. Try Again.";
          exit();
        }
      }else{
        echo "Verification Code has been Expired.";
        exit();
      }
    }
  }
?>
