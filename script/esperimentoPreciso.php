<?php
    session_start();
    include("DB/connection.php");
    ini_set('display_errors', 1);
    error_reporting(E_ALL &~E_NOTICE);
    $id_utente = $_SESSION['id'];



    $idEsp = $_GET['id'];

    $queryCalcolo = "SELECT * FROM calcoli WHERE id = $idEsp;"; 

    $result = mysqli_query($con, $queryCalcolo);

    if(!$result){
        print("Error Find Experiments");
    }

    $row = mysqli_fetch_array($result);

    $slope = $row['slope'];
    $intersect = $row['intersectY'];
    $nomeEsp = $row['nome'];
    $dataEsp = $row['dataCalc'];
    $imgEsp = $row['rifImg'];

    $queryValori = "SELECT * FROM valori WHERE id_calcolo = $idEsp;"; 

    $resultValori = mysqli_query($con, $queryValori);

    if(!$resultValori){
        print("Error Find Experiments");
    }

?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Least Square Method</title>
    <link href="../bootstrap-4.3.1-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script type="text/javascript" src="html2canvas.js"></script>
    <script type="text/javascript">
            function genPDF(){
                html2canvas(document.body).then(function(canvas) {

                        var img = canvas.toDataURL("image/png");
                        var doc = new jsPDF('l', 'px', [1920, 1080]);
                        var width = doc.internal.pageSize.getWidth();
                        var height = doc.internal.pageSize.getHeight();
                        doc.addImage(img, 'JPEG', 0, 0, width, height);
                        doc.save('prova.pdf');
                    
                });
        }
    </script>
    <style>
        .tutto{
            width: 80%;
            margin: 0 auto;
            
        }

        .bottone{
            width: 100%;
        }

        .selectValues{
            width: 25%;
            margin: 0 auto;
            float: right;
        }
        .titleSelect{
            text-align: right;
        }

        .formulas{
            margin-top: 4%;
            width: 60%;
            float: right;
        }
        div.title{
            margin-top: 1%;
            margin-bottom: 1%;
            text-align: center;
        }

    </style>

</head>

<body id="body">
    <div class="title">
        <h2>LEAST SQUARE METHOD COMPUTING</h2>
    </div>
    <div class="tutto">
    <table class="table table-striped">
            <thead class="thead-dark">
                <th>CTR. NO.</th>
                <th>X</th>
                <th>Y</th>
            </thead>
            <?php
                $valXY = 0;
                $sqrX = 0;
                $sumValX = 0;
                $sumValY = 0;
                $nValori = mysqli_num_rows($resultValori);
                $nCTR = 1;

                while($rowVal = mysqli_fetch_array($resultValori)){
            
                    $valX = $rowVal['x'];
                    $valY = $rowVal['y'];
                    $valXY += $valX * $valY;
                    $avgXnum += $valX;
                    $avgYnum += $valY;
                    $sqrX += pow($valX, 2);
                    $sumValX += $valX;
                    $sumValY += $valY;

                    echo '<tr><td>'.$nCTR.'</td>
                          <td>'.$valX.'</td>
                          <td>'.$valY.'</td></tr>';
                    $nCTR++;
                }
            
                $avgX = $avgXnum / $nValori;
                            
                $avgY = $avgYnum / $nValori;
            
                $sqrAVGX = pow($avgX, 2);
            
                $avgSqrX = $sqrX / $nValori;
                
                $avgXY = $valXY / $nValori;
            ?>    
                </table>
                <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <th>SUM(X)</th>
                    <th>SUM(Y)</th>
                    <th>AVG(X)</th>
                    <th>AVG(Y)</th>
                    <th>AVG(X*Y)</th>
                    <th>AVGsqr(X)</th>
                    <th>sqrAVG(X)</th>
                </thead> 
               
                <?php
                echo '    <tr>
                            <td>'.$sumValX.'</td>
                            <td>'.$sumValY.'</td>
                            <td>'.$avgX.'</td>
                            <td>'.$avgY.'</td>
                            <td>'.$avgXY.'</td>
                            <td>'.$avgSqrX.'</td>
                            <td>'.$sqrAVGX.'</td>
                          </tr>';
                ?>

                
        </table>
            <div class="plot">
                    <p class="formulas">
                        About linear dependency we assume \(f(x) = ax + b\) as the best line fit for the experimental points of coordinates \((x_i, y_i)_{i=1...n}\).
                        <br /> <br />
                        \(a = slope = \cfrac{\bar x \cdot \bar y - {\overline {xy}}}{ (\bar x)^2 - \overline {(x^2)} } = <?php echo $slope?>\)
                        <br /> <br />
                        \(b = Y intersect = \cfrac{\bar x \cdot {\overline {xy} - \overline {x^2} \cdot \bar y}}{ (\bar x)^2 - \overline {(x^2)} } = <?php echo $intersect?>\)
                    </p>
                    <img src="<?php echo $imgEsp;?>" alt="">
                
                    
            </div>
        </div>
        
        <?php if(isset($_SESSION['username'])){ ?>
        <a href="javascript:genPDF()">generaPDF</a>
                <?php } ?>                    
            </div>  
                <a href="home.php">Back to Home</a>
</body>
</html>