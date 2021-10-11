<?php 
  if (!isset($_REQUEST['itemBagId'])) {
    header('Location:bag.php');
  }

  $itemBagId = $_REQUEST['itemBagId'];
  $query = "delete from products_orders where id=".$itemBagId.";";

  // echo $query;

  $db = mysqli_connect("localhost", "root", "");
  mysqli_select_db($db, "bazar");
  
  mysqli_query($db, $query);

  header('Location:bag.php');
?>