<?php
session_start();
unset($_SESSION['name']);
unset($_SESSION['username']);
unset($_SESSION['lastlogin']);
unset($_SESSION['lastip']);
unset($_SESSION['permission']);
$path=$_SERVER['DOCUMENT_ROOT'];
header("Location: /");