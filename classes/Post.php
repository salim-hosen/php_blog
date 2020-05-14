<?php
	require '../vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer; 
    use Intervention\Image\ImageManagerStatic as Image;

  class Post{
    private $db;
    private $validate;

    public function __construct($db,$validate){
      $this->db        =  $db;
      $this->validate  =  $validate;
    }

    public function addPost(){
     
	  $this->validate->data("title")->isEmpty()->checkLength()->isExists(array("title" => $_POST['title']),"tbl_post");
      $this->validate->data("category")->isEmpty();
      $this->validate->data("date")->isEmpty();
      if(empty($_POST['content_body'])){
        echo "<b>Error! </b>Content is Empty.";
        exit();
      }else if(strlen($_POST['content_body']) < 300 ){
		echo "Article should be at least 300 characters Long.";
		exit();
	  }

      $permitted = array("jpg","jpeg","png","gif");
      $fileName = $_FILES['image']['name'];
      $fileSize = $_FILES['image']['size'];
      $tmpName  = $_FILES['image']['tmp_name'];

      if($this->validate->submit()){
        $ext = strtolower($fileName);
        $ext = explode(".",$ext);
        $ext = end($ext);
        $newName = substr(md5(time()),0,10).".".$ext;

        Session::init();
        $status = $_SESSION['status'];
        $data = array(
          "catId"    => $this->validate->value['category'],
          "title"    => $this->validate->value['title'],
          "image"    => $newName,
          "postDate" => $this->validate->value['date'],
          "content"  => $_POST['content_body'],
          "status"   => $status
        );

        if(empty($fileName)){
          $data['image'] = "noImage.png";
        }else if($fileSize > 1048576 || $fileSize <= 0 ){
          echo "Image Size is should be below 1MB.";
          exit();
        }else if(in_array($ext,$permitted) === false){
          echo "You can Upload Only ".implode(", ",$permitted)." Files.";
          exit();

        }
		
		$filePath = "../uploads/".$newName;
		
        if(!empty($fileName)){
			
			move_uploaded_file($tmpName,$filePath);
			
			$thumbnailpath = '../uploads/thumbnail/'.$newName;
			$img = Image::make($filePath);
			$img->resize(280, 180, function ($constraint) {
				$constraint->aspectRatio();
			});
			$img->save($thumbnailpath);
        }

        $sql = "insert into tbl_post(catId,title,image,postDate,content,status)values(:catId,:title,:image,:postDate,:content,:status)";
        $res = $this->db->execQuery($sql,$data,"insert");
        
	    //$last_id = $this->db->con->lastInsertId();
			  
		if($res){
          echo "success";
		  /*
			// Code for Sending Latest post to subscriber through email.
		   //  Work Very slow on gmail smtp
		   
		  $sql = "select * from tbl_subscriber";
		  $res = $this->db->execQuery($sql,NULL,'select');
		  
		  if($res){
	
			  $subject = "New sBlog Post - ".$data['title'];
			  $href = BASE_URL."/post.php?postId=".$last_id;
			  
			  $message = "<p>A new Blog post has been published in sBlog.</p><p>To see the Post <a href='".$href."'>Click Here</a></p>";
			  
			  foreach($res as $key){
				  $this->sendMail($key['email'],$message,$subject);  
			  }
		  }
		  
		  */
          exit();
        }else{
          echo "<b>Error!</b> Failed to Add Post.";
          exit();
        }
      }else{
        echo "Error Occured.";
        exit();
      }
    }

    public function getPostList(){
      $sql = "select tbl_post.*,tbl_category.catName from tbl_post inner join tbl_category on tbl_post.catId=tbl_category.catId order by postId desc";
      $res = $this->db->execQuery($sql,NULL,"select");
      if($res){
        return $res;
      }else{
        return false;
      }
    }

    public function deletePost(){
		
      $this->validate->data("postId");

      $sql = "delete from tbl_post where postId=:postId";
      $data = array("postId" => $this->validate->value['postId']);
      $res = $this->db->execQuery($sql,$data,"delete");
      if($res){
        if($_POST['image'] !== "../uploads/noImage.png"){
          
		  $name = explode('/',$_POST['image']);
		  $name = end($name);
		  if(file_exists("../uploads/".$name))unlink("../uploads/".$name);
		  $name = "../uploads/thumbnail/".$name;
		  if(file_exists($name))unlink($name);
        }
        echo "success";
        exit();
      }else{
        echo "Failed to Delete Post.";
        exit();
      }
    }

    public function getPostForUpdate(){
      $sql = "select * from tbl_post where postId=:postId limit 1";
      $data = array("postId" => $_POST['postId']);
      $res = $this->db->execQuery($sql,$data,"select");
      return $res;
    }

    public function updatePost(){
      $this->validate->data("title")->isEmpty()->checkLength();
      $this->validate->data("category")->isEmpty();
      $this->validate->data("date")->isEmpty();

      if(empty($_POST['content'])){
        echo "<b>Error! </b>Content is Empty.";
        exit();
      }

      $permitted = array("jpg","jpeg","png","gif");
      $fileName = $_FILES['image']['name'];
      $fileSize = $_FILES['image']['size'];
      $tmpName  = $_FILES['image']['tmp_name'];

      Session::init();
      $status = $_SESSION['status'];

      if($this->validate->submit()){
        if(empty($fileName)){
          $data = array(
            "catId"    => $this->validate->value['category'],
            "title"    => $this->validate->value['title'],
            "postDate" => $this->validate->value['date'],
            "content"  => $_POST['content'],
            "status"   => $status,
            "postId"   => $_POST['postId']
          );
          $sql = "update tbl_post set catId=:catId,title=:title,postDate=:postDate,content=:content,status=:status where postId=:postId";
          $res = $this->db->execQuery($sql,$data,"update");
          if($res){
            echo "success";
            exit();
          }else{
            echo "<b>Error!</b> Failed to Update Post.";
            exit();
          }
        }else{
          $ext = strtolower($fileName);
          $ext = explode(".",$ext);
          $ext = end($ext);
          $newName = substr(md5(time()),0,10).".".$ext;

          $data = array(
            "catId"    => $this->validate->value['category'],
            "title"    => $this->validate->value['title'],
            "image"    => $newName,
            "postDate" => $this->validate->value['date'],
            "content"  => $_POST['content'],
            "status"   => $status,
            "postId"   => $_POST['postId']
          );

          if($fileSize > 1048576){
            echo "Image Size is should be below 1MB.";
            exit();
          }else if(in_array($ext,$permitted) === false){
            echo "You can Upload Only ".implode(", ",$permitted)." Files.";
            exit();
          }

          $sql = "update tbl_post set catId=:catId,title=:title,image=:image,postDate=:postDate,content=:content,status=:status where postId=:postId";
          $res = $this->db->execQuery($sql,$data,"update");
          if($res){
            if($_POST['oldImage'] !== "noImage.png"){
              unlink("../uploads/".$_POST['oldImage']);
              unlink("../uploads/thumbnail/".$_POST['oldImage']);
            }
            
			$filePath = "../uploads/".$newName;
			
			move_uploaded_file($tmpName,$filePath);
			
			$thumbnailpath = '../uploads/thumbnail/'.$newName;
			$img = Image::make($filePath);
			$img->resize(280, 180, function ($constraint) {
				$constraint->aspectRatio();
			});
			$img->save($thumbnailpath);
			
            echo "success";
            exit();
          }else{
            echo "<b>Error!</b> Failed to Update Post.";
            exit();
          }
        }
      }else{
        echo "Error Occured.";
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
  }
?>
