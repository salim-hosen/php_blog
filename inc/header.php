<?php

  // Cache Controll
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  header("Cache-Control: max-age=2592000");

  ini_set('display_errors',1);
  error_reporting(E_ALL);
  
  require_once "main.php";
  
  $pageName = basename($_SERVER['PHP_SELF']);
  $blog = new Blog($db,$validate);
  $cat  = new Category($db,$validate);

  $catList = $cat->getCategoryList();
  $popularPost = $blog->getPopularPost();

?>
<!doctype html>

<html lang="en-US">
  <head>
    <?php
      if($pageName === "allpost.php"){
      ?>
        <title>Showing All Post</title>
        <meta name="keywords" content="<?php
          $cl = "";
          if(!empty($catList)){
            foreach ($catList as $key) {
              $cl .= $key['catName'].', ';
            }
            echo $cl;
          }else{
            echo KEYWORDS;
          }
        ?>"/>
        <meta name="description" content="Showing all post of categories <?php echo $cl;?>"/>
      <?php
      }else if($pageName === "categories.php"){
      ?>
        <title>Categories wise Posts</title>
        <meta name="keywords" content="<?php
          if(isset($_GET['catId'])){
            $catId = htmlspecialchars($_GET['catId']);
            $sql = "select catName from tbl_category where catId=:catId";
            $catName = $db->execQuery($sql,array("catId" => $catId),"select");
            if(!empty($catName)){
              echo $catName[0]['catName'];
            }else{
              echo KEYWORDS;
            }
          }
        ?>"/>
        <meta name="description" content="Showing all post of <?php if(!empty($catName))echo $catName[0]['catName'];?> Category."/>
      <?php
      }else if($pageName === "post.php"){
        if(isset($_GET['postId'])){
          $postId = htmlspecialchars($_GET['postId']);
          $sql = "select tbl_post.*,tbl_category.catName from tbl_post inner join tbl_category on tbl_post.catId=tbl_category.catId where postId=:postId";
          $postName = $db->execQuery($sql,array("postId" => $postId),"select");
        }
      ?>
      <title><?php
      if(!empty($postName)){
        echo $postName[0]['title'];
      }else{
        echo KEYWORDS;
      }
      ?></title>
      <meta name="keywords" content="<?php if(!empty($postName))echo $postName[0]['catName'];else echo KEYWORDS?>"/>
      <meta name="description" content="<?php if(!empty($postName)){
        if(strlen($postName[0]['content']) > 100){
          $cntn = strip_tags($postName[0]['content']);
          $cntn = trim(substr($cntn,0,100));
          $cntn = substr($cntn,0,strrpos($cntn,'.'));
          echo $cntn.".";
        }
      }else{
        echo DESCRIPTION;
      }?>"/>
      <?php
      }else if($pageName === "search.php"){
      ?>
        <title>Search Results</title>
        <meta name="keywords" content="<?php echo KEYWORDS;?>"/>
        <meta name="description" content="Search Results for <?php if(isset($_POST['search']))echo $_POST['search'];else echo KEYWORDS?>"/>
      <?php
      }else{
      ?>
      <title>Simple Blog Site</title>
      <meta name="keywords" content="<?php echo KEYWORDS;?>"/>
      <meta name="description" content="<?php echo DESCRIPTION;?>"/>
    <?php
      }
    ?>
    <meta name="author" content="Salim Hosen"/>
    <meta name="language" content="English"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/responsive.css" type="text/css" rel="stylesheet"/>
    <link href="fa/css/fontawesome-all.min.css" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
	
	<style>
		.compost h2{
			border:none;
		}
	</style>
  
  </head>
  <body style="font-family: 'Source Sans Pro', sans-serif;">
    <div id="wrapper">
      <header class="headerSection">
        <div class="header_menu container">
          <a href="index.php"><i class="hm fas fa-home"></i>Home</a>
          <div class="search">
            <form style="position:relative;" name="searchBox" autocomplete="off" action="search.php" method="post">
              <input maxlength="80" type="text" name="search" placeholder="Search Here"/>
              <button id="searchBtn" type="submit"><i class="sr fas fa-search"></i></button>
            </form>
          </div>
        </div>
      </header>
<div class="modal">
  <div id="msg">
    <span id="cross">&times;</span>
    <div class="msgContent">

    </div>
  </div>
</div>
<div>
  <?php

  ?>
</div>
