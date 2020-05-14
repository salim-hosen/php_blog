<?php


  // Import Library Files
  include "config/config.php";
  include "lib/Database.php";
  require_once "lib/Session.php";


  // Import All Classes
  spl_autoload_register(function($file){
    require_once "classes/".$file.".php";
  });

  // All Objects
  $db = new Database();
  $validate = new Validate($db);

?>
