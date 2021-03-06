<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PayPerWear -Profile</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/showprofile.css">
</head>
<body>
    <?php
        error_reporting(E_ALL & ~E_NOTICE);//non visualizza warning della session_start() duplicata
        session_start();
        if(!isset($_SESSION["login"])){
            echo '
            <script>
                alert("PRIMA DEVI FARE IL LOGIN");
            </script>';
            header("refresh:0; url= https://saw21.dibris.unige.it/~S4540263/_index.php");
            exit;    
        }
        
        include("common/header.php");
        
    ?>

    <div class="maincontent">

        <div class="greetings">
            Ciao <b><?php echo ucwords($_SESSION["firstname"]);?>!</b> Questi sono i dati che ci hai fornito. <br>
            Ricorda che puoi cambiarli in qualsiasi momento aggiornando il tuo profilo!
        </div>

        <?php 
            include("show_profile.php");//info base
            
            if(isset($_SESSION["tel"])){
                include("profileext.php");//info estese
            }else{
                echo "<h2>Sembra che non ci hai comunicato alcune informazioni essenziali. Aggiungile aggiornando il tuo profilo!</h2>";
            }
        ?>
        


    </div>

    <?php
        include("common/footer.php");
    ?>    
</body>
</html>