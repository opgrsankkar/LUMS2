<?php

include('db.php');

if(!isset($_SESSION['username'])){
	header("location:../");
	die();
}
else if($_SESSION['permission']!=1){
        header("location:../");
        die();
    }
else{
	$username=$_SESSION['username'];
	$ses_sql = mysqli_query($connection,"select * from login where username = '$username' and permission=1 ");
	$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
	$count = mysqli_num_rows($ses_sql);

	if($count!=1){
	   header("location:../");
	   die();
	}
}