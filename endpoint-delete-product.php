<?php 
  if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['userId'])) {
    header('Location:login.php');
  }

  $userId = $_SESSION['userId'];

  $productId = $_REQUEST['productId'];

  $db = mysqli_connect("localhost", "root", "");
  mysqli_select_db($db, "bazar");

  if(mysqli_query($db, "update products set isDeleted=true where product_id='".$productId."';")) {

    header("Location:account.php");
  } else {
    $errorRigisteringProduct = "No se pudo eliminar el producto";
    require_once 'product-detail_edit.php';
  }
  
  mysqli_close($db);
?>