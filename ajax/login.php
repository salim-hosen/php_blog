<?php
  require_once "../main.php";
  $login = new Login($db,$validate);
  if(isset($_POST['action']) && $_POST['action'] === "userLogin"){
    $login->matchLogin();
  }
?>
