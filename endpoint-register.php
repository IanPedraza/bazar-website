<?php
    $name = $_REQUEST['name'];
    $number = $_REQUEST['phone_number'];
    $city = $_REQUEST['city'];
    $state = $_REQUEST['state'];
    $user = $_REQUEST['user'];
    $password = $_REQUEST['password'];
    $password_confirm = $_REQUEST['password_confirm'];

    $db = mysqli_connect("localhost", "root", "");
    mysqli_select_db($db, "bazar");

    $result = mysqli_query($db, "select user, password from sellers where user='".$user."'");

    if(mysqli_fetch_array($result) ){
        $existenciaError = "El usuario ya existe";
        require_once 'register.php';
    } else {
        if($password == $password_confirm){
            if (mysqli_query($db, "insert into sellers (name, phone_number, city, state, user, password) values ('$name', '$number', '$city', '$state', '$user', '$password');")) {
                header("Location:login.php");
            } else {
                $errorRegistro = "No se pudo realizar el registro";
                require_once 'register.php';
            }
        } else {
            $incorrectPassword = "Las contraseñas no coinciden";
            require_once 'register.php';
        }
    }
    
    mysqli_free_result($result);
    mysqli_close($db);
?>