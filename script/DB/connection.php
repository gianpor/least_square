<?php

    $nomeDB = "least_square";
    $db_tab_utente = "users";
    $db_tab_calcoli = "calcoli";
    $db_tab_valori = "valori";

    $con = new mysqli("localhost", "root", "", $nomeDB); 

    if (mysqli_connect_errno($con)) 
    {
        printf("errore di connessione al DB: %s \n", mysqli_connect_error($con));
        exit();
    }

?>