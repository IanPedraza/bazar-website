<?php 
  if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['userId'])) {
    header('Location:login.php');
  }

  $userId = $_SESSION['userId'];

  $productId = $_REQUEST['productId'];
  $title = $_REQUEST['title'];
  $description = $_REQUEST['description'];
  $status = $_REQUEST['status'];
  $price = $_REQUEST['price'];
  $stock = $_REQUEST['stock'];
  $photos = $_FILES['photos'];

  $numberOfPhotos = count($photos['name']);

  for($i = 0 ; $i < $numberOfPhotos; $i++) {
    $tmpName = $photos['name'][$i];

    if (empty($tmpName)) {
      continue;
    }

    $ext = pathinfo($tmpName, PATHINFO_EXTENSION);    
    
    $tmpFilePath = $photos['tmp_name'][$i];

    $newName = uniqid().".".$ext;

    copy($tmpFilePath, "./assets/productsImages/".$newName);

    $images[$i] = $newName;
  }

  $numberOfPhotos = count($images);

  $db = mysqli_connect("localhost", "root", "");
  mysqli_select_db($db, "bazar");

  if(mysqli_query($db, "update products set title='".$title."', description='".$description."', status='".$status."', price='".$price."', stock='".$stock."' where product_id='".$productId."';")) {
    
    for($i = 0 ; $i < $numberOfPhotos; $i++) { 
      mysqli_query($db, "insert into images(product_id, image) values(".$productId.", '".$images[$i]."');");
    }

    header("Location:account.php");
  } else {
    $errorRigisteringProduct = "No se pudo actualizar el producto";
    require_once 'product-detail_edit.php';
  }
  
  mysqli_close($db);
?>