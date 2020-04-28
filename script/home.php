<?php
    session_start();
    include("DB/connection.php");
    ini_set('display_errors', 1);
    error_reporting(E_ALL &~E_NOTICE);
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

<body>
        <?php include("cornice.php");?>

        <div class="col2">
            
            <div class="tutto">
            <div class="title">
                <h2>LEAST SQUARE METHOD COMPUTING</h2>
            </div>
            <form action="home.php" method="post">

                <h3 class="titleSelect">How many values do you want to insert?</h3>


                <div class="selectValues input-group mb-3">

                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="submit" name="submit">Select</button>
                    </div>

                <select class="custom-select" name="value" id="value">
                <?php
                    if($_POST['value'] != ""){
                        echo "<option value=";
                        echo $_POST['value'];  
                        echo ' selected>';
                        echo $_POST['value'];
                        echo"</option>";
                        for($i = 2; $i <21; $i++){
                            echo '<option value='.$i.'>'.$i.'</option>';
                        }
                    }
                    else{
                        for($i = 2; $i <21; $i++){
                            echo '<option value='.$i.'>'.$i.'</option>';
                        }
                }
                ?>
                </select>
                
                </div>
                </form>
                <br />
                <table class="table table-striped table-dark">
                <?php
                    if(isset($_POST['value'])){
                        $valore = $_POST['value']; ?>
                    <thead class="thead-dark">
                        <th>CTR. NO.</th>
                        <th>X</th>
                        <th>Y</th>
                    </thead>    
                    
                    <form action="script.php" method="post">
                    <input type="hidden" name="valore" value="<?php echo $valore?>">

                    <?php
                        for($k = 1; $k <= $_POST['value']; $k++){
                            echo '<tr>
                                    <td>'.$k.'</td>
                                    <td><input class="inputTable form-control" type="text" name="primo[]" required/></td>
                                    <td><input class="inputTable form-control" type="text" name="secondo[]" required/></td>
                                </tr>'; 
                                    
                        }
                    }
                ?>
                </table>
                <?php if(isset($_POST['value'])) {
                        if(isset($_SESSION['username'])){
                    ?>
                <button class="bottone btn btn-outline-secondary" type="submit" name="submit">Submit</button>
                <?php } else{
                    ?>
                <button onclick="return confirm('ATTENTION: If you continue without login, you won&rsquo;t be able to see the graph of the function,\n to save the experiment and to download the PDF of its computation!')" class="bottone btn btn-outline-secondary" type="submit" name="submit">Submit</button>
                    <?php
                }          
                    }
                ?>
                </form>
                </div>

                <div class="paragrafo">
                <h3 style="color: red;">HOW IT WORKS!</h3>
                <p>
                This is a tool used to calculate the slope and the intersection with the y-axis of a linear function using the least squares method.
                First of all select the number of values to enter using the drop-down menu at the top right. A number of values between 2 and 20 is allowed.
                Once the desired number of values has been selected, a table will be created, in which the values of x and y of your function must be entered.
                Real values are accepted. Furthermore, the n-powers of 10 are allowed by placing the word <strong>"\(e\pm\)N"</strong> after the decimal value
                For Example \(23.45 \cdot 10^{-6}\) = <strong>23.45e-6 or 23.45E-6</strong>
                The same for positive values.
                </p>
                <h2>Some theory</h2>
                    <p>
                        The method of least squares is a standard approach in regression analysis to approximate the solution of overdetermined systems, 
                        i.e., sets of equations in which there are more equations than unknowns. "Least squares" means that the overall solution minimizes 
                        the sum of the squares of the residuals made in the results of every single equation. The most important application is in data fitting. 
                        The best fit in the least-squares sense minimizes the sum of squared residuals (a residual being: the difference between an observed value, 
                        and the fitted value provided by a model). When the problem has substantial uncertainties in the independent variable (the x variable), then 
                        simple regression and least-squares methods have problems; in such cases, the methodology required for fitting errors-in-variables models may 
                        be considered instead of that for least squares. Least-squares problems fall into two categories: linear or ordinary least squares and nonlinear 
                        least squares, depending on whether or not the residuals are linear in all unknowns. The linear least-squares problem occurs in statistical 
                        regression analysis; it has a closed-form solution. The nonlinear problem is usually solved by iterative refinement; at each iteration the 
                        system is approximated by a linear one, and thus the core calculation is similar in both cases. Polynomial least squares describes the variance 
                        in a prediction of the dependent variable as a function of the independent variable and the deviations from the fitted curve. When the observations
                        come from an exponential family and mild conditions are satisfied, least-squares estimates and maximum-likelihood estimates are identical.
                        The method of least squares can also be derived as a method of moments estimator. The following discussion is mostly presented in terms of 
                        linear functions but the use of least squares is valid and practical for more general families of functions. Also, by iteratively applying 
                        local quadratic approximation to the likelihood (through the Fisher information), the least-squares method may be used to fit a generalized 
                        linear model. The least-squares method is usually credited to Carl Friedrich Gauss (1795), but it was first published by Adrien-Marie Legendre (1805).
                    </p>
                    <h2>Least Square Method for linear regressions</h2>
                    <p>
                        About linear dependency we assume \(f(x) = ax + b\) as the best line fit for the experimental points of coordinates \((x_i, y_i)_{i=1...n}\). 
                    </p>
                </div>
                </div>

                <?php 
                    if($loginErrato == true){
                        echo '<script>alert("Username or password wrong!");</script>';
                        $loginErrato = false;
                    }
                ?>
</body>
</html>