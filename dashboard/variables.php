<?php

$sql = "SELECT count(*) AS today FROM entrance WHERE date(timein) = date(now())";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$entrance = $row['today'];

$sql = "SELECT count(*) AS today FROM entrance WHERE date(timein) = date(now()) AND timeout IS NULL";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$entrance_in = $row['today'];


$sql = "SELECT count(*) AS today FROM digilib WHERE date(timein) = date(now())";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$digilib = $row['today'];

$sql = "SELECT count(*) AS today FROM digilib WHERE date(timein) = date(now()) AND timeout IS NULL";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$digilib_in = $row['today'];