<?php
  require_once "../main.php";

  if(isset($_POST['action']) && $_POST['action'] === "addCat"){
    $html = "<h2>Add Category</h2><div class='addcatPage'>
              <form id='addCatForm'>
                <input required type='text' name='category' placeholder='Enter Category Name' />
                <input type='submit' name='catSubmit' value='Add'/>
              </form>
            </div>";
    if($html){
      echo $html;
      exit();
    }else{
      echo "<div class='addcatPage'><p>Failed to Load Content.</p></div>";
      exit();
    }

  }

  $cat = new Category($db,$validate);

  if(isset($_POST['action']) && $_POST['action'] === "addCategory"){
    $cat->addCategory();
  }

  if(isset($_POST['action']) && $_POST['action'] === "getCatList"){
    $res = $cat->getCategoryList();
    $i = 1;
    $html = "<h2>Category List</h2><div class='catList'><table id='myTable'><thead><tr><th>Serial</th><th>Category Name</th><th>Action</th></tr></thead><tbody>";
    if($res){
      foreach ($res as $key) {
        $html .= "<tr><td>".$i++."</td><td><input id='".$key['catId']."' type='text' value='".$key['catName']."'/></td><td><a id='catEdit' href=''>Update</a><a id='catDel' href=''>Delete</a></td></tr>";
      }
    }else{
      $html .= "<tr><td colspan='3' style='text-align: center;'><hr />No Category Found<hr /></td></tr>";
    }
    $html .= "</tbody></table></div>";
    echo $html;
    exit();
  }

  if(isset($_POST['action']) && $_POST['action'] === "upCategory"){
    $cat->updateCategory();
  }

  if(isset($_POST['action']) && $_POST['action'] === "delCategory"){
    $cat->deleteCategory();
  }
?>
