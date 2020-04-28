<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>installer del DB</title>
</head>

<body>
    <h2>Creazione DB</h2>

    <?php			
        error_reporting(E_ALL &~E_NOTICE);                      
        $primaConnessione = new mysqli("localhost", "lweb3", "lweb3"); 
    
        if (mysqli_connect_errno($primaConnessione)) 
        {             
            printf("errore con la prima connessione al DB: %s \n", mysqli_connect_error($primaConnessione));  
            exit();
        }

        $queryCreazioneDB = "CREATE DATABASE least_square";
        if ($resultQ = mysqli_query($primaConnessione, $queryCreazioneDB)) 
        {
            printf("DB creato con successo \n");
            echo "<br />";
        }
        else 
        {
            printf("errore in creazione del DB (il database potrebbe essere già presente)\n"); 
            exit();
        }
    
        mysqli_close($primaConnessione);

        echo "<h2>Creazione tabella utenti e popolamento con qualche riga</h2>";  
    
        require_once("connection.php");

        $query = "CREATE TABLE if not exists users (
            id int auto_increment PRIMARY KEY,
            username varchar (50) NOT NULL UNIQUE,
            password varchar (50) NOT NULL,
            email varchar(50) NOT NULL UNIQUE,
            nome varchar (50) NOT NULL,
            cognome varchar (50) NOT NULL,
            imgAvatar varchar (50)
        );";

        if ($resultQ = mysqli_query($con, $query))
        {   
            printf("tabella users creata con successo \n");
            echo "<br />";
        }
        else 
        {
            printf("errore con la query di creazione della tabella users \n");
            exit();
        }

        $query = "INSERT INTO users (username, password, email, nome, cognome) VALUES
        ('cliente1', 'cliente1', 'cliente1@gmail.com', 'cliente', 'uno'),
        ('cliente2', 'cliente2', 'cliente2@gmail.com', 'cliente', 'due');";

        if ($resultQ = mysqli_query($con, $query))
        {   
            printf("tabella users popolata con successo \n");
            echo "<br />";
        }
        else 
        {
            printf("errore popolamento tabella users \n");
            exit();
        }
        
        $query = "CREATE TABLE if not exists calcoli (
            id int auto_increment PRIMARY KEY,
            id_utente int NOT NULL,
            nome varchar (50) NOT NULL,
            slope double NOT NULL,
            intersectY double NOT NULL,
            dataCalc date NOT NULL,
            rifImg varchar (50) NOT NULL
        );";

        if ($resultQ = mysqli_query($con, $query))
        {   
            printf("tabella prodotti creata con successo \n");
            echo "<br />";
        }
        else 
        {
            printf("errore creazione tabella prodotti \n");
            exit();
        }

        $query = "CREATE TABLE if not exists valori (
            id int auto_increment PRIMARY KEY,
            id_calcolo int NOT NULL,
            x double NOT NULL,
            y double NOT NULL
        );";

        if ($resultQ = mysqli_query($con, $query))
        {   
            printf("tabella ordini creata con successo \n");
            echo "<br />";
        }
        else 
        {
            printf("errore creazione tabella ordini \n");
            exit();
        }
        
        mysqli_close($con);
    ?>
</body>
</html>