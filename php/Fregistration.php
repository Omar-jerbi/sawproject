<?php
    if(!isset($_POST["firstname"])){//quando si accede a questo file direttamnete tramite l'url
        header("Location: ../_index.php");    
        exit;
    }
    
    include_once("../db/connection.php");//$connection

    $f = mysqli_real_escape_string($connection, strtolower(trim($_POST["firstname"])));
    $l = mysqli_real_escape_string($connection, strtolower(trim($_POST["lastname"])));
    $m = mysqli_real_escape_string($connection ,strtolower(trim($_POST["email"])));
    $pw =  password_hash((trim($_POST["pass"])), PASSWORD_DEFAULT);



    $stmt = mysqli_prepare($connection, "SELECT * from utenti where email = ?");
    mysqli_stmt_bind_param($stmt, 's', $m);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
 
  
    if(mysqli_affected_rows($connection) != 0){
        echo '<script>
            alert("utente già registrato");
            </script>';
            header("refresh:0; url= ../registration.php");
    }else{
        $stmt = mysqli_prepare($connection, "INSERT INTO `utenti`(`firstname`, `lastname`, `email`, `pass`) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssss', $f, $l, $m, $pw);
        mysqli_stmt_execute($stmt);

        session_start();
        
        $_SESSION["idutente"] = mysqli_insert_id($connection);
        $_SESSION["login"] = true;
        $_SESSION["firstname"] = $_POST["firstname"];
        $_SESSION["lastname"] = $_POST["lastname"] ;
        $_SESSION["email"] = $_POST["email"];

        echo '<script>
        alert("Benvenuto in PayPerWear! Completa il tuo profilo per iniziare ad utilizzare il servizio");
        alert("Clicca OK e verrai rediretto alla pagina di Modifica del tuo profilo!");
        </script>';

        header("refresh:0; url= ../updateprofile.php");
    }
?>
