<?php
  
  // Cache Controll
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  header("Cache-Control: max-age=2592000");
  
  ini_set('display_errors',1);
  error_reporting(E_ALL);
  
  require_once "../lib/Session.php";

  Session::init();
  if(!isset($_SESSION['userLogin'])){
    exit(header("Location: login.php"));
  }

  if(isset($_GET["logout"]) && $_GET['logout'] === "yes"){
    session_destroy();
    header("Location: login.php");
  }
?>
<!doctype html>

<html lang="en-US">
  <head>
    <title>Simple Blog Site</title>
    <link href="../css/style.css" type="text/css" rel="stylesheet"/>
    <link href="../fa/css/fontawesome-all.min.css" type="text/css" rel="stylesheet"/>
    <link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
  </head>
  <body style="font-family: arial;">
    <div id="wrapper">
      <header class="headerSection">
        <div class="header_menu container">
          <a href="../index.php" target="_blank"><i class="hm fas fa-home"></i>Visit Blog</a>
        </div>
      </header>
