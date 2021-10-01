<?php 
    session_start();
    
    $user = $_REQUEST['user'];
    $password = $_REQUEST['password'];

    $db = mysqli_connect("localhost", "root", "");
    mysqli_select_db($db, "bazar");

    $query = mysqli_query($db, "select seller_id, user, password from sellers where user='".$user."'");

    if($data = mysqli_fetch_array($query) ){
        if($data['password'] == $password){
            $_SESSION['userId'] = $data['seller_id'];
            header("Location:account.php");
        } else {
            $errorPassword = "Contraseña Incorrecta";
            require_once 'login.php';
        }
    } else {
        $errorUser = "El usuario no existe";
        require_once 'login.php';
    }

    mysqli_free_result($query);
    mysqli_close($db);
?>