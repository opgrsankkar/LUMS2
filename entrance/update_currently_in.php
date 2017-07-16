<?php
include "../scripts/db.php";
$sql="SELECT count(*) as today FROM entrance where date(timein) = date(now())";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$res1=$row['today'];
$sql="SELECT count(*) as today FROM entrance where date(timein) = date(now()) and timeout is null";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$res2=$row['today'];


    header('Content-Type: application/json');


    $aResult = array();

    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

    if( !isset($aResult['error']) ) {



        switch($_POST['functionname']) {
            case 'get_currently_in':
                $aResult['result1'] = $res2;
                $aResult['result2'] = $res1;
                break;

            default:
               $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }

    }

    echo json_encode($aResult);

?>