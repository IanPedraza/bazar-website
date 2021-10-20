<?php 
  if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['userId'])) {
    header('Location:login.php');
  }

  $userId = $_SESSION['userId'];

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

  if (mysqli_query($db, "insert into products(seller_id, title, description, status, price, stock, isDeleted) values ('".$userId."', '".$title."', '".$description."', '".$status."', '".$price."', '".$stock."', false);")) {
    $productId = mysqli_insert_id($db);

    for($i = 0 ; $i < $numberOfPhotos; $i++) { 
      mysqli_query($db, "insert into images(product_id, image) values(".$productId.", '".$images[$i]."');");
    }
    
    header("Location:account.php");
  } else {
    $errorRigisteringProduct = "No se pudo registrar el producto";
    require_once 'new.php';
  }
  
  mysqli_close($db);
?>