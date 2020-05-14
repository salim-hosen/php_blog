<?php
  class Database{
    
	private $servername = "localhost";
    private $dbname     = "db_blog";
    private $username   = "root";
    private $password   = "";
	/*
	private $servername = "localhost";
    private $dbname     = "id5855783_blog";
    private $username   = "id5855783_blog_salim";
    private $password   = "";
	*/
    public $con = NULL;

    public function __construct(){
      $this->conDB();
    }

    public function conDB(){
      try{
        $this->con = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname,$this->username,$this->password);
        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
      }
    }


    public function execQuery($sql,$data=array(),$method){
      $query = $this->con->prepare($sql);
      if(!empty($data) && is_array($data)){
        foreach ($data as $key => $value) {
          $query->bindValue(":$key",$value);
        }
      }
      
	  $res = $query->execute();
	  
	  
      if($method === "select"){
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
  		  return $res?$res:false;
  	  }else{
  		  return $res?true:false;
	    }
    }

  }
?>
