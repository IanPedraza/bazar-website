<?php 
  if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $db = mysqli_connect("localhost", "root", "");
  mysqli_select_db($db, "bazar");  

  if (!isset($_SESSION['bagId'])) {
    $_SESSION['bagId'] = uniqid();
    $bagId = $_SESSION['bagId'];

    $query = "insert into orders(order_id, client_name, address, zip_code, state, phone_number, email) values('".$bagId."', '', '', '', '', '', '');";
    mysqli_query($db, $query);
  }

  $productId = $_REQUEST['productId'];
  $bagId = $_SESSION['bagId'];
  $query = "insert into products_orders(product_id, order_id) values(".$productId.", '".$bagId."');";

  if (mysqli_query($db, $query)) {
    header('Location:bag.php');
  } else {
    $errorMessage = "No se pudo agregar el producto a la bolsa";
    require_once "product-detail.php";
  }

?>