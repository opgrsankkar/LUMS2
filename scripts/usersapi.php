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


function add_users($users)
{
    global $connection;

    $id = "";
    $name = "";

    // prepare sql and bind parameters
    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, 'INSERT INTO users (id,name) VALUES (?,?)')) {
        mysqli_stmt_bind_param($stmt, "ss", $id, $name);
    }

    foreach ($users as &$user) {
        if (isset($user['id']) && isset($user['name'])) {
            $id = $user['id'];
            $name = $user['name'];
            mysqli_stmt_execute($stmt);
        } else {
            $error_msg = "ID_AND_NAME_REQUIRED";
            return json_encode([
                "success" => false,
                "error_msg" => $error_msg
            ]);
        }
    }

    return json_encode(["success" => true]);
}

if (isset($_POST)) {
    /* parse the json data to php array */
    $postdata = json_decode(file_get_contents('php://input'), true);

    /* set the Content-Type of echo response */
    header('Content-Type: application/json');

    /* decide what to do depending on the query passed */
    switch ($postdata['query']) {
        case "GET_ALL_USERS":
            echo get_all_users();
            break;

        case "UPDATE_USERS":
            echo update_user();
            break;

        case "ADD_USERS":
            echo add_users($postdata['users']);
            break;

        case "DELETE_USER":
            echo delete_users();
            break;

        default:
            $error_msg = "CANNOT_ADD_LT_ONE_ITEM";
            echo json_encode([
                "success" => false,
                "error_msg" => $error_msg
            ]);
    }
}
