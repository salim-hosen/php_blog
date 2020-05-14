<?php
require_once "../main.php";

$blog = new Blog($db,$validate);
if(isset($_POST['action']) && $_POST['action'] === "titlePage"){
  $res = $blog->getTitle();
  if($res){
    $html = "<div class='profile'>
              <h2>Change Blog Title</h2>
            <form id='titleForm' autocomplete='off'>
              <table>
                <tbody>
                  <tr>
                    <td><label>Title</label></td>
                    <td><input required type='text' name='title' value='".$res[0]['title']."'/></td>
                  </tr>
                  <tr>
                    <td><label>Title Description</label></td>
                    <td><input type='text' name='titleDesc' value='".$res[0]['titleDesc']."'/></td>
                  </tr>
                  <tr>
                    <td><input type='hidden' name='tId' value='".$res[0]['tId']."'/></td>
                    <td><input type='submit'  value='Change' /></td>
                  </tr>
                </tbody>
              </table>
            </form>
          </div>";
        echo $html;
        exit();
      }else{
        echo "<div class='title'><p>Failed to Load Title.</p></div>";
        exit();
      }
}

if(isset($_POST['action']) && $_POST['action'] === "upTitle"){
  $blog->updateTitle();
}

if(isset($_POST['action']) && $_POST['action'] === "subscribe"){
  $blog->addSubscriber();
}

if(isset($_POST['action']) && $_POST['action'] === "contact"){
  $blog->contactMsg();
}
?>
