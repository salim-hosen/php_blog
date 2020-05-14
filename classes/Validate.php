<?php
  class Validate{
    protected $errors = array();
    protected $key;
    public $value = array();
    private $db;

    public function __construct($db){
      $this->db = $db;
    }

    public function data($key){
      $this->key = $key;
      $this->value[$this->key] = trim($_POST[$this->key]);
      $this->value[$this->key] = stripcslashes($this->value[$this->key]);
      $this->value[$this->key] = htmlspecialchars($this->value[$this->key]);
      return $this;
    }

    public function isEmpty(){
      if(empty($this->value[$this->key])){
          $this->errors[$this->key] = "<b>Error!</b> ".ucfirst($this->key)." is Empty.";
          echo $this->errors[$this->key];
          exit();
      }
      return $this;
    }

    public function checkLength(){
      if(strlen($this->value[$this->key])<5){
        $this->errors[$this->key] = "<b>Error!</b> ".ucfirst($this->key)." is too Short.";
        echo $this->errors[$this->key];
        exit();
      }
      return $this;
    }

    public function checkEmail(){
      if(!filter_var($this->value[$this->key],FILTER_VALIDATE_EMAIL)){
        $this->errors[$this->key] = "<b>Error!</b> Invalid ".ucfirst($this->key)." Address.";
        echo $this->errors[$this->key];
        exit();
      }
      return $this;
    }

    public function isExists($param=array(),$table=NULL){
        $sql = "";
        $i = 1;
        foreach ($param as $key => $value) {
          if($i === 1){
            $sql .= "select * from ".$table." where ".$key."=:".$key;
          }else{
            if($i === count($param)){
              $sql .= " and ".$key."!=:".$key;
            }else{
              $sql .= " and ".$key."=:".$key;
            }
          }
          $i++;
        }

        $res = $this->db->execQuery($sql,$param,"select");

        if($res){
            $this->errors[$this->key] = ucfirst($this->key)." Already Exists.";
            echo $this->errors[$this->key];
            exit();
        }
        return $this;
    }

    public function submit(){
      if(empty($this->errors)){
        return true;
      }else{
        return false;
      }
    }

  }
?>
