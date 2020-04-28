<?php
include("DB/connection.php");
require_once ('../jpgraph-4.2.9/src/jpgraph.php');
require_once ('../jpgraph-4.2.9/src/jpgraph_line.php');
session_start();
//include("prova.php");
ini_set('display_errors', 1);
error_reporting(E_ALL &~E_NOTICE);
$x = $_POST['primo'];
$y = $_POST['secondo'];
$sqr = array();
$sumX = 0;
$xy = array();
$mult = 0;

for($a = 0; $a < $_POST['valore']; $a++){
    $mult = $x[$a] * $y[$a];
    array_push($xy, $mult);
    
}

function Grafico($x, $y, $token){
    include("DB/connection.php");

    $queryID = "SELECT id FROM calcoli;";

    $result = mysqli_query($con, $queryID);

    if($result){
        $numRow = mysqli_num_rows($result);
    }

    $numRowIMG = $numRow + 1;

    // Size of the overall graph
    $width=400;
    $height=300;
    
    // Create the graph and set a scale.
    // These two calls are always required
    $graph = new Graph($width,$height);
    $graph->SetScale('linlin');
    $graph->xaxis->scale->SetAutoMin(0);
    $graph->yaxis->scale->SetAutoMin(0);
    
    // Setup margin and titles
    $graph->SetMargin(80,40,50,60);
    $graph->title->Set('Linear Dependence');
    $graph->subtitle->Set(date("m/d/Y"));
    $graph->xaxis->title->Set('X-AXIS');
    $graph->xaxis->SetTitleMargin(20);
    $graph->yaxis->title->Set('Y-AXIS');
    $graph->yaxis->SetTitleMargin(60);
    
    
    
    // Create the linear plot
    $lineplot=new LinePlot($y, $x);
    $lineplot->mark->SetType(MARK_FILLEDCIRCLE);
    $lineplot->mark->SetFillColor("red");
    $lineplot->mark->SetWidth(3);
    
    // Add the plot to the graph
    $graph->Add($lineplot);
    
    // Display the graph
    $imgName = '../img/img'.$_SESSION['id'].$numRowIMG.$token.'.png';
    //$graph->Stroke();
    $graph->Stroke($imgName);

    echo $imgName;
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
            if(isset($_POST['valore'])){
                for($k = 0; $k < $_POST['valore']; $k++){
                    $kk = $k+1;
                    echo '<tr>
                            <td>'.$kk.'</td>
                            <td>'.$_POST['primo'][$k].'</td>
                            <td>'.$_POST['secondo'][$k].'</td>
                          </tr>'; 
                             
                }
                
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
                    
                    $avgX = array_sum($x) / $_POST['valore'];
                    
                    $avgy = array_sum($y) / $_POST['valore'];

                    $sqrAVGX = pow($avgX, 2);

                    for($c = 0; $c < $_POST['valore']; $c++){
                        $sqr[$c] = pow($x[$c], 2);
                        $sumX += $sqr[$c];                    
                    }
                    $avgSqrX = $sumX / $_POST['valore'];
                    
                    $avgXY = array_sum($xy) / $_POST['valore'];
                    
                    echo '<tr>
                            <td>'.array_sum($x).'</td>
                            <td>'.array_sum($y).'</td>
                            <td>'.$avgX.'</td>
                            <td>'.$avgy.'</td>
                            <td>'.$avgXY.'</td>
                            <td>'.$avgSqrX.'</td>
                            <td>'.$sqrAVGX.'</td>
                          </tr>';
        }

                    $slope = (($avgX * $avgy) - $avgXY) / (($sqrAVGX) - $avgSqrX);
                    $intersect = (($avgX * $avgXY) - ($avgSqrX * $avgy)) / ($sqrAVGX - $avgSqrX);
        ?>
        </table>
            <?php 
                if(isset($_SESSION['username'])){
            ?>
            <div class="plot">
                    <p class="formulas">
                        About linear dependency we assume \(f(x) = ax + b\) as the best line fit for the experimental points of coordinates \((x_i, y_i)_{i=1...n}\).
                        <br /> <br />
                        \(a = slope = \cfrac{\bar x \cdot \bar y - {\overline {xy}}}{ (\bar x)^2 - \overline {(x^2)} } = <?php echo $slope?>\)
                        <br /> <br />
                        \(b = Y intersect = \cfrac{\bar x \cdot {\overline {xy} - \overline {x^2} \cdot \bar y}}{ (\bar x)^2 - \overline {(x^2)} } = <?php echo $intersect?>\)
                    </p>
                <img src="<?php $token = rand();
                 Grafico($x, $y, $token);?>" alt="">
                    
            </div>
        </div>
        
        <a href="javascript:genPDF()">generaPDF</a>

                    <form action="salvaEsperimento.php" method="post">
                        <input type="text" name="nomeEsp" placeholder="Insert your experiment's name...">
                        <input type="hidden" name="slope" value="<?php echo $slope; ?>">
                        <input type="hidden" name="intersect" value="<?php echo $intersect; ?>">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input type="hidden" name="valore" value="<?php echo $_POST['valore']; ?>">
                        <?php 
                        for($k = 0; $k < $_POST['valore']; $k++){
                            echo '                                   
                                    <input type="hidden" name="x[]" value="'.$x[$k].'"/>
                                    <input type="hidden" name="y[]" value="'.$y[$k].'"/>
                                '; 
                                    
                        }
                        ?>
                        <button class="bottone btn btn-outline-secondary" type="submit" name="salvaEsp">Save your experiment!</button>
                    </form>

                <?php } else{ ?>
                    <div class="plot">
                    <p class="formulas">
                        About linear dependency we assume \(f(x) = ax + b\) as the best line fit for the experimental points of coordinates \((x_i, y_i)_{i=1...n}\).
                        <br /> <br />
                        \(a = slope = \cfrac{\bar x \cdot \bar y - {\overline {xy}}}{ (\bar x)^2 - \overline {(x^2)} } = <?php echo $slope?>\)
                        <br /> <br />
                        \(b = Y intersect = \cfrac{\bar x \cdot {\overline {xy} - \overline {x^2} \cdot \bar y}}{ (\bar x)^2 - \overline {(x^2)} } = <?php echo $intersect?>\)
                    </p>
                <a href="DB/createUser.php"><img src="../img/immagineFade.png" alt="Click Here To Registrer"></a>
                    
            </div>
                <?php }?>   
                <a href="home.php">Back to Home</a>
</body>
</html>