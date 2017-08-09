<?php
/**
 * Created by PhpStorm.
 * User: sri
 * Date: 9/8/17
 * Time: 6:26 PM
 */
session_start();
include("../scripts/entrancesession.php");
if (isset($_POST)) {
    header('Content-Type: application/json');

    $sql = "UPDATE entrance SET timeout=now() WHERE timeout IS NULL";
    mysqli_query($connection, $sql);

    $result = mysqli_affected_rows($connection);

    $result = array(updated => $result);
    echo json_encode($result);
    //echo(json_encode(mysqli_info($connection)));


}