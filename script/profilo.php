<?php
    session_start();
    include("DB/connection.php");
    ini_set('display_errors', 1);
    error_reporting(E_ALL &~E_NOTICE);

    $ID_UTENTE = $_SESSION['id'];
?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Least Square Method</title>
    <link href="../bootstrap-4.3.1-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../style.css" rel="stylesheet" type="text/css"/>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="script/gradient.js"></script>
</head>

<?php
    $nuovaPass = $_POST['password'];
    if(isset($_POST['nuovaPass'])){
        if($nuovaPass == $_POST['verificaP']){
            $queryPass = "UPDATE users SET password = '$nuovaPass' WHERE id = '$ID_UTENTE';";

            $result = mysqli_query($con, $queryPass);

            if(!$result){
                print("ERROR UPDATE PASS!");
            }
        } else {
            $errorPass = true;
        }
    }
?>

<body>
    <?php include("cornice.php"); ?>

    <div class="col2">
        <div class="tutto">
            <?php 
           
                $sql = "SELECT *
                FROM $db_tab_utente 
                WHERE id = \"$ID_UTENTE\"
            ";
        
                if (!$result = mysqli_query($con, $sql)) {
                    printf("Errore nella query di ricerca reputazioni\n");
                exit();
                }
                
            $row = mysqli_fetch_array($result);
        
            $nomeUtente= $row['nome'];
            $cognomeUtente = $row['cognome'];
            $email= $row['email'];
            $username= $row['username'];
            $imgAvatar = $row['imgAvatar'];
            
            
            echo"<div class='card'>
                              
                            <h1 class='titolo'>Hi $nomeUtente $cognomeUtente... these are your personal informations</h1>
        
                            <p class='text'>This is your login mail: $email</p>
                            <p class='text'>This is your username: $username</p>
                            
                        </div>";
        
        
            ?>
        <form action="profilo.php" method="post">
            <button class="btn btn-primary btnPass" id="avatar" type="submit" value="avatar" name="avatar">Modify your Avatar</button>
        </form>
        
        <form action="profilo.php" method="post">
            <button class="btn btn-primary btnPass" id="cambiaPass" type="submit" value="cambiaPass" name="cambiaPass">Modify your Password</button>
        </form>

        <?php
            if(isset($_POST['cambiaPass'])){ ?>
                    <div class="changePass">
                        <form class="form-horizontal login-form" method="post">
                                
                                <h1>CHANGE PASSWORD</h1>
                                <p>Please, fill the form below</p>

                                <div class="form-group relative">
                                <label for="username"><b>Password</b></label>
                                <input class="form-control input-lg" type="password" placeholder="Insert Password" name="password" required>
                                </div>

                                <div class="form-group relative">
                                <label for="psw"><b>Repeat Password</b></label>
                                <input class="form-control input-lg" type="password" placeholder="Repeat your password" name="verificaP" required>
                                </div>

                                <div class="form-group">
                                <button class="btn btn-success btn-lg btn-block" type="submit" class="login" name="nuovaPass">Update Password</button>
                                </div>
                  
                        </form>
                    </div>
        <?php }

        if(isset($_POST['avatar'])){
            for($i = 1; $i <= 6; $i++){
                echo '<a href="salvaAvatar.php?nAvatar='.$i.'"><img class="avatar" src="../avatar/avatar'.$i.'.png" alt="AVATAR"/></a>';
            }
        }
            if($errorPass == true){
                echo "<script>window.alert(\"Values do not match each other! Try again!\")</script>";
                $errorPass = false;
            }
        ?>

        </div>
    </div>

</body>