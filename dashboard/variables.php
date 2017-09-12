<?php

$sql = "SELECT count(*) as today FROM entrance where date(timein) = date(now())";
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
   
$entrance=$row['today'];

$sql = "SELECT count(*) as today FROM entrance where date(timein) = date(now()) and timeout is null";
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$entrance_in=$row['today'];


$sql = "SELECT count(*) as today FROM digilib where date(timein) = date(now())";
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$digilib=$row['today'];

$sql = "SELECT count(*) as today FROM digilib where date(timein) = date(now()) and timeout is null";
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$digilib_in=$row['today'];