<?php
session_start();
include("sessionvariables.php");
if ($permission == 1)
    include("adminsession.php");
else if ($permission == 2)
    include("usersession.php");
else {
    header("location:../");
    die();
}

if (isset($_POST)) {
    header('Content-Type: application/json');

    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $old_password = filter_var($_POST['old_password'], FILTER_SANITIZE_STRING);
    $new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM login WHERE username = '$username'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if ($count == 1 && password_verify($old_password, $row['password'])) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sql = "UPDATE login SET password= '$hashed_password' WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(array(
                "success" => false,
                "error_msg" => "DB_ERROR"
            ));
        }
    } else {
        echo json_encode(array(
            "success" => false,
            "error_msg" => "PASSWORD_INCORRECT"
        ));
    }

}