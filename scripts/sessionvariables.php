<?php


if (isset($_SESSION['name']))
	$name=$_SESSION['name'];
else
	$name="";

if (isset($_SESSION['username']))
	$username=$_SESSION['username'];
else
	$username="";

if (isset($_SESSION['permission']))
	$permission=$_SESSION['permission'];
else
	$permission=0;

if (isset($_SESSION['lastlogin']))
	$lastlogin=$_SESSION['lastlogin'];
else
	$lastlogin="";

if (isset($_SESSION['lastip']))
	$lastip=$_SESSION['lastip'];
else
	$lastip="";
