<?php
/**
 * Created by PhpStorm.
 * User: darsh
 * Date: 16-07-2017
 * Time: 02:40 PM
 */


$columns =array(
    array( 'db' => 'id','dt'=>0),
    array( 'db' => 'name','dt'=>1),
    array( 'db' => 'designation','dt'=>2),
    array( 'db' => 'timein','dt'=>3),
    array( 'db' => 'timeout','dt'=>4)
);

// connection details
$sql_details = array(
    'user'=>'root',
    'pass'=>'root',
    'db'=>'library',
    'host'=>'localhost'
);

//$whereAll = 'tbl_houses.houseID = tbl_residents.residentID';

require( 'ssp.class.php' );

echo json_encode(
    SSP::simple($_GET,$sql_details,'entrance_records','id',$columns)
);