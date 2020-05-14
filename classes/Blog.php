<?php
  class Blog{
    private $db;
    private $validate;

    public function __construct($db,$validate){
      $this->db        =  $db;
      $this->validate  =  $validate;
    }

    public function getTitle(){
      $sql = "select * from tbl_title limit 1";
      $res = $this->db->execQuery($sql,NULL,"select");
      return $res;
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

    public function getLatestPost(){
      $sql = "select tbl_post.*,tbl_category.catName from tbl_post inner join tbl_category on tbl_post.catId=tbl_category.catId order by postId desc limit 4";
      $res = $this->db->execQuery($sql,NULL,"select");
      if($res){
        return $res;
      }else{
        return false;
      }
    }

    public function getPopularPost(){
      $sql = "select tbl_post.*,tbl_category.catName from tbl_post inner join tbl_category on tbl_post.catId=tbl_category.catId order by views desc limit 4";
      $res = $this->db->execQuery($sql,NULL,"select");
      if($res){
        return $res;
      }else{
        return false;
      }
    }

    public function getPostbyId(){
      $sql = "select * from tbl_post where postId=:postId limit 1";
      $data = array("postId" => $_GET['postId']);
      $res = $this->db->execQuery($sql,$data,"select");
      if($res){
        $sql = "update tbl_post set views = :views where postId = :postId";
        $data = array("views" => $res[0]['views']+1,"postId" => $res[0]['postId']);
        $this->db->execQuery($sql,$data,"update");
        return $res;
      }else{
        return false;
      }
    }

    public function getRelatedPost($catId,$postId){
      $sql = "select * from tbl_post where catId=:catId and postId!=:postId limit 4";
      $data = array("catId" => $catId,"postId" => $postId);
      $res = $this->db->execQuery($sql,$data,"select");
      return $res;
    }

    public function totalRows($table){
      $sql = "select * from ".$table;
      $res = $this->db->execQuery($sql,NULL,"select");
      if(empty($res)){
        return 0;
      }else{
        return count($res);
      }
    }

    public function getAllPost($limit){
      $sql = "select * from tbl_post order by postId desc limit ".$limit.",4";
      $res = $this->db->execQuery($sql,NULL,"select");
      return $res;
    }

    public function getPostbyCat($catId){
      $sql = "select * from tbl_post where catId=:catId order by postId desc";
      $res = $this->db->execQuery($sql,array("catId"=>$catId),"select");
      return $res;
    }

    public function search(){
      $this->validate->data("search");
      $sv = $this->validate->value['search'];
      $sql = "select * from tbl_post where title like :title or content like :content order by postId desc";
      $data = array("title" => "%$sv%","content" => "%$sv%");
      $res = $this->db->execQuery($sql,$data,"select");
      return $res;
    }

    public function addSubscriber(){
      $this->validate->data("email")->isEmpty()->checkEmail()->isExists(array("email"=>$this->validate->value['email']),"tbl_subscriber");

      if($this->validate->submit()){
        $sql = "insert into tbl_subscriber(email)values(:email)";
        $data = array("email" => $this->validate->value['email']);
        $res = $this->db->execQuery($sql,$data,"insert");
        if($res){
          echo "success";
          exit();
        }else{
          echo "<b>Error!</b> Failed to Subscribe.";
          exit();
        }
      }else{
        echo "<b>Error!</b> Failed to Subscribe.";
        exit();
    }
  }

  public function contactMsg(){
    $this->validate->data("email")->isEmpty()->checkEmail();
    $this->validate->data("message")->isEmpty();
    if($this->validate->submit()){
      $sql = "insert into tbl_contact(email,message)values(:email,:message)";
      $data = array("email" => $this->validate->value['email'],"message" => $this->validate->value['message']);
      $res = $this->db->execQuery($sql,$data,"insert");
      if($res){
        echo "success";
        exit();
      }else{
        echo "<b>Error!</b> Failed to Contact.";
        exit();
      }
    }else{
      echo "<b>Error!</b> Failed to Contact.";
      exit();
  }
}

  }
?>
