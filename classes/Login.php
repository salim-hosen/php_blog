<?php
  class Login{
    private $db;
    private $validate;

    public function __construct($db,$validate){
      $this->db        =  $db;
      $this->validate  =  $validate;
    }

    public function matchLogin(){
      $this->validate->data("username")->isEmpty();
      $this->validate->data("password")->isEmpty();

      $sql = "select * from tbl_user where username=:username and password=:password";
      $data = array("username" => $this->validate->value['username'],"password" => md5($this->validate->value['password']));
      $res = $this->db->execQuery($sql,$data,"select");

      if($res && $this->validate->submit()){
        Session::init();
        Session::set("userLogin",true);
        Session::set("userId",$res[0]['userId']);
        Session::set("username",$res[0]['username']);
        Session::set("status",$res[0]['status']);
        echo "success";
        exit();
      }else{
        echo "<b>Error!</b> Username and Password did not Match.";
        exit();
      }
    }
  }
?>
