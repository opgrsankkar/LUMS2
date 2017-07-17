<?php
session_start();
include("../../scripts/sessionvariables.php");
if($permission==1)
    include("../../scripts/adminsession.php");
else if($permission==2)
    include("../../scripts/usersession.php");
else{
    header("location:../");
    die();
}

/**
 * get_all_news()
 * returns all news items in DB
 *
 * @return json string containing all news items
 */
function get_all_news(){
    global $connection;
    $data=array();

    $sql = "SELECT * FROM news ORDER BY id";
    $result = $connection->query($sql);
    while ($row = $result->fetch_assoc()){
        array_push($data,$row);
    }
    return json_encode($data);
}

/**
 * delete_news_items( ids )
 * deletes the news item with the given ids from DB
 * @param {array} - ids to delete
 * @return string - string with success indication
 */

function delete_news_items($ids){
    global $connection;
    $ids = implode(" or id = ",$ids);
    $sql = "DELETE from news where id = $ids";
    mysqli_query($connection,$sql);
    return json_encode(["success"=>true]);
}

/**
 * update_news_item( id, data )
 * replaces the news content in item with given id
 * with 'data'
 * @param id to update
 * @param data to update with
 * @return json string with success indication
 */
function update_news_item($id, $data){
    global $connection;
    $sql = "Update news set news='$data' where id=$id";
    mysqli_query($connection,$sql);
    return json_encode(["success"=>true]);
}

/**
 * add_news( numberOfItems )
 * add a new news item with prompt content - "Please Enter the new News"
 * @param number of items to add
 * @return json string with success indication
 */
function add_news( $num ){
    if($num<1){
        $error_msg = "CANNOT_ADD_LT_ONE_ITEM";
        return json_encode([
            "success"=>false,
            "error_msg"=>$error_msg
        ]);
    }

    global $connection;
    $newNews = "Please Enter the new News";
    $sql = "Insert into news (news) VALUES ('$newNews')";
    for($i = 0; $i<$num; $i++) {
        mysqli_query($connection, $sql);
    }
    return json_encode(["success"=>true]);
}

if(isset($_POST)){
    /* parse the json data to php array */
    $postdata = json_decode(file_get_contents('php://input'), true);

    /* set the Content-Type of echo response */
    header('Content-Type: application/json');

    /* decide what to do depending on the query passed */
    switch ($postdata['query']){
        case "GET_ALL_NEWS":
            echo get_all_news();
            break;

        case "UPDATE_NEWS":
            echo update_news_item( $postdata['id'], $postdata['newNews'] );
            break;

        case "ADD_NEWS":
            echo add_news( $postdata['numberOfItems'] );
            break;

        case "DELETE_NEWS":
            echo delete_news_items($postdata['ids']);
            break;

        default:
            echo json_encode("error");
    }
}
