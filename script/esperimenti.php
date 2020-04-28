<?php
    session_start();
    include("DB/connection.php");
    ini_set('display_errors', 1);
    error_reporting(E_ALL &~E_NOTICE);
    $id_utente = $_SESSION['id'];
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
<?php 
    include("cornice.php");
    ?>

        <div class="tutto">
            <h1 class="title">MY EXPERIMENTS</h1>

    <?php
    
        $queryCalcolo = "SELECT * FROM calcoli WHERE id_utente = $id_utente;"; 

        $result = mysqli_query($con, $queryCalcolo);

        if(!$result){
            print("Error Find Experiments");
        }

        while($row = mysqli_fetch_array($result)){
        
        $idEsp = $row['id'];
        $nomeEsp = $row['nome'];
        $slopeEsp = $row['slope'];
        $intersectYEsp = $row['intersectY'];
        $dataCalcEsp = $row['dataCalc'];

        $numRowEsp = mysqli_num_rows($result);

    ?>
                <a href="esperimentoPreciso.php?id=<?php echo $idEsp ?>"><div class="card">
                    <p>Experiment Name: <?php echo $nomeEsp ?></p>
                    <p>Experiment Slope: <?php echo $slopeEsp ?></p>
                    <p>Experiment Y Intersect: <?php echo $intersectYEsp ?></p>
                    <p>Experiment Date: <?php echo $dataCalcEsp ?></p>
                </div>
                </a>
                <?php } ?>           
        </div>
</body>
</html>