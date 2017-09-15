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

if (isset($_POST)) {
    global $connection;
    header('Content-Type: application/json');
    $error = false;

    foreach ($_POST['checkbox'] as &$id) {
        $sql = "DELETE from users where id LIKE '$id'";
        if (!mysqli_query($connection, $sql)) {
            $error = true;
        }
    }
    if ($error) {
        echo json_encode([
            "success" => false,
            "message" => "Database Error\nPlease Report to the Development Team"
        ]);
    } else {
        echo json_encode([
            "success" => true
        ]);
    }
}