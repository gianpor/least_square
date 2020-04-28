<?php    
session_start();
include("DB/connection.php");

    $token = $_POST['token'];
    $slope = $_POST['slope'];
    $intersect = $_POST['intersect'];
    $valuesX = $_POST['x'];
    $valuesY = $_POST['y'];

    $queryID = "SELECT id FROM calcoli;";

    $result = mysqli_query($con, $queryID);

    if($result){
        $numRow = mysqli_num_rows($result);
    }

    $numRowIMG = $numRow + 1;

    $id_utente = $_SESSION['id'];
    $nomeEsp = $_POST['nomeEsp'];
    $dataEsp = date('Y-m-d');

    $sql = "INSERT INTO calcoli (id_utente, nome, slope, intersectY, dataCalc, rifImg) 
    VALUES(\"$id_utente\", \"$nomeEsp\", \"$slope\", \"$intersect\", \"$dataEsp\", \"../img/img$id_utente$numRowIMG$token.png\");";

    $result = mysqli_query($con, $sql);

    if(!$result){
        echo '<script>alert("ERROR saving experiment!");</script>';
    }

    $queryIDCalcolo = "SELECT MAX(id) AS last_id FROM calcoli;";

    $id_calcoloRes = mysqli_query($con, $queryIDCalcolo);

    if(!$id_calcoloRes){
        echo '<script>alert("ERROR saving experiment Calc!");</script>';
    }

    $row = mysqli_fetch_array($id_calcoloRes);

    $id_calcolo = $row['last_id'];

    for($l = 0; $l < $_POST['valore']; $l++){
        $queryValori = "INSERT INTO valori (id_calcolo, x, y) 
        VALUES(\"$id_calcolo\", \"$valuesX[$l]\", \"$valuesY[$l]\");";

        $resultValori = mysqli_query($con, $queryValori);

        if(!$resultValori){
            echo '<script>alert("ERROR saving experiment QUERY MULTIPLE!");</script>';
}
    }

    echo "<script>location.replace(\"esperimenti.php\");</script>";
    //header("Location : home.php");

            
?>