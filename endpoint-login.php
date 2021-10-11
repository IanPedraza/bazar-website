<?php 
    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];

    $db = mysqli_connect("localhost", "root", "");
    mysqli_select_db($db, "bazar");

    $query = mysqli_query($db, "select seller_id, password from sellers where email='".$email."'");

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