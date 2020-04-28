<div class="col1">
    

            <?php
                if (!isset($_SESSION['success']))
                {
                ?>
                <div class="login"> 
                    <h4 class="login">Let's Login!</h4>   
                </div>    
                    <form class="login-form" method="post" action="home.php">
                        
                  <div class="formLogin input-group form-group">
                      <div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="username" name="username">
                  </div>
                  <div class="formLogin input-group form-group">
                      <div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="password" name="password">
                  </div>
                  
                  <div class="form-group">
                      <button type="submit" class="loginButton btn float-right login_btn" name="login_user">Login</button>
                  </div>
                  <br />
                  <br />
                  <div class="loginRegistrati">
                  <p class="notRegister">
                      Not registered yet? <a href="DB/createUser.php">Register!</a>
                  </p>
                  </div>
              </form>
            <?php

            if (isset($_POST['login_user'])) {
               
                $query = "SELECT * FROM users WHERE username = \"{$_POST['username']}\" AND password = \"{$_POST['password']}\";";
                
                if (!$result = mysqli_query($con, $query)) {
                    echo "errore query ";
                    exit();
                }
                    $row = mysqli_fetch_array($result);
            
                    if ($row){   
                            session_start();
                            $_SESSION['id']=$row['id'];
                            $_SESSION['username']= $_POST['username'];
                            $_SESSION['email']=$row['email'];
                            $_SESSION['nome']=$row['nome'];
                            $_SESSION['cognome']=$row['cognome'];
                            $_SESSION['password']= $_POST['password'];
                            $_SESSION['avatar'] = $row['imgAvatar'];
                            $_SESSION['success'] = 1000;
                            header('Location: home.php');    
                    }
                    else 
                        { 
                            $loginErrato = true;
                            session_start();
                        }       
            }
        } else {
            $username = $_SESSION['username'];

            $query = "SELECT * FROM users WHERE username = '$username';";
            
            if (!$result = mysqli_query($con, $query)) {
                echo "errore query login";
                exit();
            }
                $row = mysqli_fetch_array($result);
            
            if($row){
                $imgAvatar = $row['imgAvatar'];
                $nome = $row['nome'];
            }    
        
            if($imgAvatar != NULL){
            ?>
            <h1 class="titleCorn">DASHBOARD</h1>
            <img class="avatar" src="<?php echo $imgAvatar?>" alt="avatar">

            <?php
            }

            echo '<p>'.$_SESSION['username'].'</p>';
            
            ?>
            <?php
                if($_SESSION['avatar'] != NULL){
            ?>
            <img src="<?php echo $_SESSION['avatar'];?>" alt="<?php echo $_SESSION['username'];?>">
            <br />
                <?php } ?>
            <a class="btn btn-primary" href="home.php" role="button">Home</a>
            <br />
            <a class="btn btn-primary" href="profilo.php" role="button">Profile</a>
            <br />
            <a class="btn btn-primary" href="esperimenti.php" role="button">My Experiments</a>
            <br />
            <a class="btn btn-primary" href="logout.php" role="button">Logout</a>
            
            <?php } ?>
        </div>