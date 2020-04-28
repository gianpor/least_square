<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="createUser.css">
            <title>Creazione utente</title>
        </head>
        
    
<body class="login">
    <div class="radial-gradient"></div>
        <div class="container">
            <div class="login-container-wrapper clearfix">
                <div class="tab-content">
                    <div class="tab-pane active" id="login">
                        <form class="form-horizontal login-form" method="post">
                                    <h1>Sign Up</h1>
                                    <p>Please fill all fields for registration</p>
                                    
                                   
                                    <div class="form-group relative">
                                        <label for="nome"><b>Name</b></label>
                                        <input class="form-control input-lg" type="text" placeholder="Insert name" name="nome" required><i class="fa fa-user"></i>
                                    </div>
                                    <div class="form-group relative">
                                        <label for="cognome"><b>Surname</b></label>
                                        <input class="form-control input-lg" type="text" placeholder="Insert surname" name="cognome" required><i class="fa fa-user"></i>
                                    </div>
                                    <div class="form-group relative">
                                        <label for="email"><b>Email</b></label>
                                        <input class="form-control input-lg" type="text" placeholder="Insert email" name="email" required><i class="fa fa-user"></i>
                                    </div>
                                    <div class="form-group relative">
                                        <label for="username"><b>Username</b></label>
                                        <input class="form-control input-lg" type="text" placeholder="Insert username" name="username" required><i class="fa fa-user"></i>
                                    </div>
                                    <div class="form-group relative">
                                        <label for="psw1"><b>Password</b></label>
                                        <input class="form-control input-lg" type="password" placeholder="Insert password" name="psw1" required><i class="fa fa-user"></i>
                                    </div>
                                    <div class="form-group relative">
                                        <label for="psw2"><b>Password again</b></label>
                                        <input class="form-control input-lg" type="password" placeholder="Insert password again" name="psw2" required><i class="fa fa-user"></i>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button class="btn btn-success btn-lg btn-block" type="submit" name="invio">Sign Up</button>
                                        <button class="btn btn-success btn-lg btn-block" type="reset" >Cancel</button>
                                        <button class="btn btn-success btn-lg btn-block" onclick="goBack()">Go back</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="gradient.js"></script>
    <script>
        function goBack() {
        window.history.back();
        }
    </script>
    </body>
</html>

<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);

include("connection.php");

if(isset($_POST['invio']) ){ 
    if(isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['psw1']) && isset($_POST['psw2']) && ($_POST['psw1'] == $_POST['psw2'])){

        $username = $_POST['username'];
        $email = $_POST['email'];

        $query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            
                if (!$result = mysqli_query($con, $query)) 
                    {
                        printf("errore nella query di ricerca utenti esistenti \n");
                        exit();
                    }
            
                $row = mysqli_fetch_array($result);
    
                if ($row) {   
                
                    if ($row['username'] == $username) 
                        echo "<p id= \"error\" style=\"font-size:160%;\">Username gi&agrave; in uso</p>";
        
                    if ($row['email'] == $email) 
                        echo "<p id= \"error\" style=\"font-size:160%;\">E-mail gi&agrave; in uso</p>";
                } else {      

                $nome=  $_POST['nome'];
                $cognome=  $_POST['cognome'];
                $password=  $_POST['psw1'];

            
                $sql = "INSERT INTO $db_tab_utente 
                    (nome,cognome,email,username,password)
                    VALUES
                    (\"$username\", \"$password\", \"$email\" ,\"$nome\", \"$cognome\")";
                
                if (!$result = mysqli_query($con, $sql)) {
                    printf("Errore nella query\n");
                exit();
                }

                //header('Location: ../PAGINE SITO/LAHOME.php');


    }         
    }
}

?>