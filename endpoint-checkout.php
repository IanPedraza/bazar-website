<?php 
  if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $db = mysqli_connect("localhost", "root", "");
  mysqli_select_db($db, "bazar");  
  
  if (!isset($_SESSION['bagId'])) {
    $errorCheckout = "No se pudo hacer el pedido.";
    require_once "checkout.php";
  }

  $bagId = $_SESSION['bagId'];

  $client_name = $_REQUEST['client_name'];
  $address = $_REQUEST['address'];
  $zip_code = $_REQUEST['zip_code'];
  $state = $_REQUEST['state'];
  $phone = $_REQUEST['phone'];
  $email = $_REQUEST['email'];

  if(mysqli_query($db, "update orders set client_name='".$client_name."', address='".$address."', zip_code='".$zip_code."', state='".$state."', phone_number='".$phone."', email='".$email."' where order_id='".$bagId."';")) {
    unset($_SESSION['bagId']);
    header('Location:order-sent.php');
  } else {
    $errorCheckout = "No se pudo hacer el pedido.";
    require_once "checkout.php";
  }
?>