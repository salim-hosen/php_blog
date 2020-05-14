<?php
  class Category{
    private $db;
    private $validate;

    public function __construct($db,$validate){
      $this->db        =  $db;
      $this->validate  =  $validate;
    }

    public function addCategory(){
      $this->validate->data("category")->isEmpty();

      $sql = "select * from tbl_category where catName=:catName";
      $data = array("catName" => $this->validate->value['category']);
      $res1 = $this->db->execQuery($sql,$data,"select");
      if($res1){
        echo "Category Already Exists.";
        exit();
      }else{
        if($this->validate->submit()){
          $sql = "insert into tbl_category(catName)values(:catName)";
          $res2 = $this->db->execQuery($sql,$data,"insert");
          if($res2){
            echo "success";
            exit();
          }else{
            echo "Failed to Insert Category.";
            exit();
          }
        }else{
          echo "Error Occured.";
          exit();
        }
      }
    }

    public function getCategoryList(){
      $sql = "select * from tbl_category order by catId desc";
      $res = $this->db->execQuery($sql,NULL,"select");
      return $res;
    }

    public function updateCategory(){
      $this->validate->data("category");
      $this->validate->data("catId");

      $sql = "select * from tbl_category where catName=:catName";
      $data = array("catName" => $this->validate->value['category']);
      $res1 = $this->db->execQuery($sql,$data,"select");
      if($res1){
        echo "Category Already Exists or Nothing Changed.";
        exit();
      }

      $sql = "update tbl_category set catName=:catName where catId=:catId";
      $data = array("catId" => $this->validate->value['catId'],"catName" => $this->validate->value['category']);
      $res = $this->db->execQuery($sql,$data,"update");
      if($res){
        echo "success";
        exit();
      }else{
        echo "Failed to Update Category.";
        exit();
      }
    }

    public function deleteCategory(){
      $this->validate->data("catId");

      $sql = "delete from tbl_category where catId=:catId";
      $data = array("catId" => $this->validate->value['catId']);
      $res = $this->db->execQuery($sql,$data,"delete");
      if($res){
        echo "success";
        exit();
      }else{
        echo "Failed to Delete Category.";
        exit();
      }
    }
  }
?>
