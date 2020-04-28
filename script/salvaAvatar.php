<?php
    session_start();
    include("DB/connection.php");
    ini_set('display_errors', 1);
    error_reporting(E_ALL &~E_NOTICE);

    $ID_UTENTE = $_SESSION['id'];
    $nAvatar = $_GET['nAvatar'];

    $queryAvatar = "UPDATE users SET imgAvatar = '../avatar/avatar$nAvatar.png' WHERE id = $ID_UTENTE";

    $result = mysqli_query($con, $queryAvatar);

    if($result){
        $avatarImpostato = true;
    }

    else{
        print("ERROR INSERT AVATAR!");
    }

    if($avatarImpostato == true){
        echo "<script>alert(\"Avatar set!\")</script>";
        $avatarImpostato = false;
    }

    echo "<script>location.replace(\"profilo.php\")</script>";


?>
