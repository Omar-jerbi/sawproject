<?php



if(!isset($_POST["email"])||!isset($_POST["pass"])){//quando si accede a questo file direttamnete tramite l'url
    header("Location: https://saw21.dibris.unige.it/~S4540263/_index.php");    
    exit;
}


if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    echo '<script>
    alert("Dati errati, riprova!");
    </script>';
    header("refresh:0; url=  https://saw21.dibris.unige.it/~S4540263/login.php");
    exit;
}

//include_once("../db/connection.php");//$connection
include(__DIR__."/../db/connection.php");

$m = mysqli_real_escape_string($connection ,htmlspecialchars($_POST["email"]));
$pw =  trim($_POST["pass"]);

$stmt = mysqli_prepare($connection, "SELECT * from utenti where email = ?");
mysqli_stmt_bind_param($stmt, 's', $m);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if(mysqli_affected_rows($connection) == 0){
    echo '<script>
    alert("Dati errati, riprova!");
    </script>';
    header("refresh:0; url=  https://saw21.dibris.unige.it/~S4540263/formlogin.php");
    exit;
}else{
    $arr = mysqli_fetch_array($res);
    
    $pwdb = $arr[4];
    if(!password_verify($pw, $pwdb)){
        echo '<script>
        alert("Dati errati, riprova!");
        </script>';
        header("refresh:0; url=  https://saw21.dibris.unige.it/~S4540263/formlogin.php");
        exit;
    }else{
        
        session_start();
        
        $_SESSION["login"] = true;
        $_SESSION["idutente"] = $arr[0];
        $_SESSION["firstname"] = $arr[1];
        $_SESSION["lastname"] =$arr[2];
        $_SESSION["email"] = $arr[3];
        $_SESSION["sesso"] = $arr[5]; //6,7,8,9,10 potrebbero essere null
        $_SESSION["misura_pantaloni"] = $arr[6];
        $_SESSION["misura_scarpe"] = $arr[7];
        $_SESSION["misura_maglie"] = $arr[8] == 1 ? 'S' :($arr[8] == 2 ? 'M' :( $arr[8] == 3 ? 'L': 'XL'));
        $_SESSION["tel"] = $arr[9];
        $_SESSION["addr"] = $arr[10];
        
        
        
        if($_SESSION["sesso"] == 2){
            echo '<script>
            alert("Ciao '.ucwords($_SESSION["firstname"]).'! VERRAI REINDIRIZZATA ALLA HOME DEL SITO");
            </script>';
        }else{
            if($_SESSION["sesso"] == 1){
                echo '<script>
                    alert("Ciao '.ucwords($_SESSION["firstname"]).'! VERRAI REINDIRIZZATO ALLA HOME DEL SITO");
                    </script>';
                }else{
                    echo '<script>
                    alert("Ciao '.ucwords($_SESSION["firstname"]).'! VERRAI REINDIRIZZAT* ALLA HOME DEL SITO");
                    </script>';                    
                }
            }

            
            header("refresh:0; url=  https://saw21.dibris.unige.it/~S4540263/_index.php");            
        }
    }
?>