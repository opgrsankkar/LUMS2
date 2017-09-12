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

function get_all_staff()
{
    global $connection;

    $data = array();

    $sql = "SELECT * FROM login ORDER BY permission";
    $result = $connection->query($sql);
    while ($row = $result->fetch_assoc()) {
        array_push($data, $row);
    }
    return json_encode($data);

}

function add_staff($username, $name, $password, $permission)
{
    global $connection;

    $hashed_password = password_hash( $password, PASSWORD_BCRYPT);
    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, 'INSERT INTO login (username, name, password, permission) VALUES (?, ?, ?, ?)')) {
        mysqli_stmt_bind_param($stmt, "ssss", $username, $name, $hashed_password, $permission);
    }

    if (!mysqli_stmt_execute($stmt)) {
        return json_encode([
            "success" => false,
            "error_msg" => mysqli_error($connection)
        ]);
    } else {
        return json_encode(["success" => true]);
    }

}

function edit_staff($username, $name, $permission)
{
    global $connection;

    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, 'UPDATE login SET name=?, permission=? WHERE username=?')) {
        mysqli_stmt_bind_param($stmt, "sis", $name, $permission, $username);
    }

    if (!mysqli_stmt_execute($stmt)) {
        return json_encode([
            "success" => false,
            "error_msg" => mysqli_error($connection)
        ]);
    } else {
        return json_encode(["success" => true]);
    }

}

function reset_password($username, $password)
{
    global $connection;

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, 'UPDATE login SET password=? WHERE username=?')) {
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $username);
    }

    if (!mysqli_stmt_execute($stmt)) {
        return json_encode([
            "success" => false,
            "error_msg" => mysqli_error($connection)
        ]);
    } else {
        return json_encode(["success" => true]);
    }
}

function delete_staff($username)
{
    global $connection;

    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, 'DELETE FROM login WHERE username = ?')) {
        mysqli_stmt_bind_param($stmt, "s", $username);
    }

    if (!mysqli_stmt_execute($stmt)) {
        return json_encode([
            "success" => false,
            "error_msg" => mysqli_error($connection)
        ]);
    } else {
        return json_encode(["success" => true]);
    }
}

if (isset($_POST)) {
    /* parse the json data to php array */
    $postdata = json_decode(file_get_contents('php://input'), true);

    /* set the Content-Type of echo response */
    header('Content-Type: application/json');

    /* decide what to do depending on the query passed */
    switch ($postdata['query']) {
        case "GET_ALL_STAFF":
            echo get_all_staff();
            break;

        case "ADD_STAFF":
            echo add_staff(
                $postdata['username'],
                $postdata['name'],
                $postdata['password'],
                $postdata['permission']
            );
            break;

        case "EDIT_STAFF":
            echo edit_staff(
                $postdata['username'],
                $postdata['name'],
                $postdata['permission']
            );
            break;

        case "RESET_PASS":
            echo reset_password(
                $postdata['username'],
                $postdata['password']
            );
            break;

        case "DELETE_STAFF":
            echo delete_staff($postdata['username']);
            break;

        default:
            $error_msg = "INVALID_QUERY";
            echo json_encode([
                "success" => false,
                "error_msg" => $error_msg
            ]);
    }
}
