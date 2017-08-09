<?php
include ("db.php");
/*
 * Script:    DataTables server-side script for PHP and MySQL
 * Copyright: 2010 - Allan Jardine, 2012 - Chris Wright
 * License:   GPL v2 or BSD (3-point)
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables. Use a space where
 * you want to insert a non-database field (for example a counter or static image)
 */
$aColumns = array( 'id', 'name', 'designation', 'timein', 'timeout' );
$fColumns = array( 'id', 'name', 'timeout', 'designation');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "id";

/* DB table to use */
$sTable = "entrance_records";




/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
 * no need to edit below this line
 */

/*
 * Local functions
 */
function fatal_error ( $sErrorMessage = '' )
{
    header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
    die( $sErrorMessage );
}

/*
 * Paging
 */
$sLimit = "";
if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
{
    $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
        intval( $_GET['iDisplayLength'] );
}


/*
 * Ordering
 */
$sOrder = "";
if ( isset( $_GET['iSortCol_0'] ) )
{
    $sOrder = "ORDER BY  ";
    for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
    {
        if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
        {
            $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
        }
    }

    $sOrder = substr_replace( $sOrder, "", -2 );
    if ( $sOrder == "ORDER BY" )
    {
        $sOrder = "";
    }
}


/*
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here, but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */
$sWhere = "WHERE (true";
if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
{
    $sWhere.= " and(";
    for ( $i=0 ; $i<count($fColumns) ; $i++ ) {
        if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true") {

            if ($i == 2 and strpos("CURRENTLY IN", strtoupper($_GET['sSearch'])) !== false) {
                $sWhere .= $fColumns[$i] . " is null OR ";
            } else if($i != 2)
            {
                $sWhere .= $fColumns[$i] . " LIKE '%" . mysqli_real_escape_string($connection, $_GET['sSearch']) . "%' OR ";
            }
        }
    }
    $sWhere = substr_replace( $sWhere, "", -3 );
    $sWhere .= ')';
}


/* Individual column filtering */
for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
    if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
        if ($sWhere == "") {
            $sWhere = "WHERE ";
        } else {
            $sWhere .= " AND ";
        }

        if ($i == 4 and strpos("CURRENTLY IN",strtoupper($_GET['sSearch_' . $i])) !== false) {
        $sWhere .= $aColumns[$i] . " is null ";
        } else {
            $sWhere .= $aColumns[$i] . " LIKE '%" . mysqli_real_escape_string($connection, $_GET['sSearch_' . $i]) . "%' ";
        }
    }
}

/*
 * Added filter for date from and to
 */

//var_dump($_GET);
if(isset($_GET['fromdate']) && $_GET['fromdate']!='' && isset($_GET['todate']) && $_GET['todate']!=''){
$sWhere.=" and (timein between '".$_GET['fromdate']."' and '".$_GET['todate']."')";
}


$sWhere .= ')';

//echo $sWhere;
/*
 * SQL queries
 * Get data to display
 */
$sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
    ";
//echo $sQuery;
$rResult = mysqli_query($connection,$sQuery) or fatal_error( 'MySQL Error: ' . mysqli_errno() );

/* Data set length after filtering */
$sQuery = "
        SELECT FOUND_ROWS()
    ";
$rResultFilterTotal = mysqli_query($connection, $sQuery) or fatal_error( '1MySQL Error: ' . mysqli_errno() );
$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

/* Total data set length */
$sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   $sTable
    ";
$rResultTotal = mysqli_query($connection, $sQuery) or fatal_error( '2MySQL Error: ' . mysqli_errno() );
$aResultTotal = mysqli_fetch_array($rResultTotal);
$iTotal = $aResultTotal[0];


/*
 * Output
 */
$output = array(
    "sEcho" => isset($_GET['sEcho'])?intval($_GET['sEcho']):0,
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array()
);

while ( $aRow = mysqli_fetch_array( $rResult ) )
{
    $row = array();
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( $aColumns[$i] == "timeout" )
        {
            /* Special output formatting for 'version' column */
            $row[] = ($aRow[ $aColumns[$i] ]=="") ? 'Currently In' : $aRow[ $aColumns[$i] ];
        }
        else if ( $aColumns[$i] != ' ' )
        {
            /* General output */
            $row[] = $aRow[ $aColumns[$i] ];
        }
    }
    $output['aaData'][] = $row;
}

echo json_encode( $output );


?>