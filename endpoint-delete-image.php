<?php 
  if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['userId'])) {
    header('Location:login.php');
  }

  $userId = $_SESSION['userId'];

  $nameImage = $_REQUEST['nameImage'];

  $db = mysqli_connect("localhost", "root", "");
  mysqli_select_db($db, "bazar");

  if(mysqli_query($db, "delete from images where image='".$nameImage."';")) {

    header("Location:account.php");
  } else {
    $errorRigisteringProduct = "No se pudo eliminar la imagen";
    require_once 'product-detail_edit.php';
  }
  
  mysqli_close($db);
?>