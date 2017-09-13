<?php
session_start();
include("sessionvariables.php");
if ($permission == 1)
    include("adminsession.php");
else if ($permission == 2)
    include("usersession.php");
else {
    header("location:/dashboard/");
    die();
}

if(isset($_POST)) {
    global $connection;
    header('Content-Type: application/json');

    $id = $_POST['id'];
    $name = $_POST['name'];
    $batch = $_POST['batch'];
    $designation = $_POST['designation'];

    $sql = "UPDATE users SET name = '$name', batch = '$batch', designation = '$designation' WHERE id LIKE '$id'";
    if(mysqli_query($connection,$sql)) {
        echo json_encode([
            "success" => true,
            "affected_rows" => mysqli_affected_rows($connection)
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Database Error\nPlease Report to the Development Team"
        ]);
    }
}