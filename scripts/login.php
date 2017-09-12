<?php
session_start();
include("db.php");
if (isset($_POST['login']))
{
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM login WHERE username = '$username'";
    $result = mysqli_query($connection,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if($count == 1 && password_verify($password, $row['password']))
    {
        $_SESSION['username']=$row['username'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['lastlogin']=$row['lastlogin'];
        $_SESSION['lastip']=$row['lastip'];
		$_SESSION['permission']=$row['permission'];
		
		date_default_timezone_set("Asia/Kolkata");
        $timestamp = date("d-m-Y") . " " . date("H:i:s")."IST";
                
				
				
		$sql_update = "UPDATE login set lastlogin = '".$timestamp."',lastip = '".$_SERVER['REMOTE_ADDR']."' where username = '$username'";
		$result = mysqli_query($connection,$sql_update);
        if($_SESSION['permission']==1 || $_SESSION['permission']==2)
            header("location:../dashboard/");
        else if($_SESSION['permission']==3)
            header("location:../entrance/");
        else if($_SESSION['permission']==4)
            header("location:../digilib/");
    }
    else
    {
        header("location:../index.php?login=false");
    }
}

