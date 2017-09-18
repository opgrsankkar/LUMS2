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

//include ("db.php");
require_once dirname(__FILE__) . '../../plugins/PhpExcel/PHPExcel.php';

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
if ( isset( $_POST['iDisplayStart'] ) && $_POST['iDisplayLength'] != '-1' )
{
    $sLimit = "LIMIT ".intval( $_POST['iDisplayStart'] ).", ".
        intval( $_POST['iDisplayLength'] );
}


/*
 * Ordering
 */
$sOrder = "";
if ( isset( $_POST['iSortCol_0'] ) )
{
    $sOrder = "ORDER BY  ";
    for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ )
    {
        if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" )
        {
            $sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
                    ".($_POST['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
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
if ( isset($_POST['sSearch']) && $_POST['sSearch'] != "" )
{
    $sWhere.= " and(";
    for ( $i=0 ; $i<count($fColumns) ; $i++ ) {
        if (isset($_POST['bSearchable_' . $i]) && $_POST['bSearchable_' . $i] == "true") {

            if ($i == 2 and strpos("CURRENTLY IN", strtoupper($_POST['sSearch'])) !== false) {
                $sWhere .= $fColumns[$i] . " is null OR ";
            } else if($i != 2)
            {
                $sWhere .= $fColumns[$i] . " LIKE '%" . mysqli_real_escape_string($connection, $_POST['sSearch']) . "%' OR ";
            }
        }
    }
    $sWhere = substr_replace( $sWhere, "", -3 );
    $sWhere .= ')';
}


/* Individual column filtering */
for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
    if (isset($_POST['bSearchable_' . $i]) && $_POST['bSearchable_' . $i] == "true" && $_POST['sSearch_' . $i] != '') {
        if ($sWhere == "") {
            $sWhere = "WHERE ";
        } else {
            $sWhere .= " AND ";
        }

        if ($i == 4 and strpos("CURRENTLY IN",strtoupper($_POST['sSearch_' . $i])) !== false) {
        $sWhere .= $aColumns[$i] . " is null ";
        } else {
            $sWhere .= $aColumns[$i] . " LIKE '%" . mysqli_real_escape_string($connection, $_POST['sSearch_' . $i]) . "%' ";
        }
    }
}

/*
 * Added filter for date from and to
 */

//var_dump($_POST);
if(isset($_POST['fromdate']) && $_POST['fromdate']!='' && isset($_POST['todate']) && $_POST['todate']!=''){
$sWhere.=" and (timein between '".$_POST['fromdate']."' and '".$_POST['todate']."')";
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
    "sEcho" => isset($_POST['sEcho'])?intval($_POST['sEcho']):0,
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


if(!( isset($_POST['action']) && $_POST['action'] != "")) {
    echo json_encode($output);
}else if($_POST['action']=='Excel') {

    if (PHP_SAPI == 'cli')
        die('This should only be run from a Web Browser');
    /** Include PHPExcel */

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

// Set document properties
    $objPHPExcel->getProperties()->setCreator("LUMS 2.0")
        ->setLastModifiedBy("LUMS 2.0")
        ->setTitle("Entrance Report")
        ->setSubject("Entrance Report");
    $objPHPExcel->setActiveSheetIndex(0);
    $result=$output['aaData'];
    $i=2;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', "ID")
        ->setCellValue('B1', "Name")
        ->setCellValue('C1', "Designation")
        ->setCellValue('D1', "Time In")
        ->setCellValue('E1', "Time Out");
    foreach( $result as $value ) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $value[0])
            ->setCellValue('B'.$i, $value[1])
            ->setCellValue('C'.$i, $value[2])
            ->setCellValue('D'.$i, $value[3])
            ->setCellValue('E'.$i, $value[4]);
        $i++;
    }

    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Users.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');

    exit;

}
else if($_POST['action']=='Pdf') {

    require_once('../plugins/tcpdf_min/tcpdf_import.php');

    class MYPDF extends TCPDF {

        // Page footer
        public function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            date_default_timezone_set("Asia/Kolkata");
            $timestamp = date("d-m-Y") . " " . date("H:i:s")." IST";

            // Page number
            $this->Cell(0, 10, 'Report Generated on '.$timestamp, 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }
    }

// create new PDF document
    $pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('LUMS');
    $pdf->SetTitle('Entrance Report');
    // set default header data
    $pdf->SetHeaderData('', '', 'LUMS', 'Entrance Report');

// set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
    if (@file_exists('eng.php')) {
        require_once('eng.php');
        $pdf->setLanguageArray($l);
    }

// ---------------------------------------------------------

// set font
    $pdf->SetFont('helvetica', '', 11);
    $result=$output['aaData'];
// add a page
    $pdf->AddPage();

    $page_data="";

    $table_header = <<<EOD
        <table border="1" style="width: 100%;
            border-collapse: collapse;">
                <thead>
                    <tr>
                    <td width="20%" style="background-color: #bbb; white-space: nowrap; ">ID</td>
                    <td width="35%" style="background-color: #bbb; white-space: nowrap; ">Name</td>
                    <td width="13%" style="background-color: #bbb; white-space: nowrap; ">Designation</td>
                    <td width="16%" style="background-color: #bbb; white-space: nowrap; ">Time In</td>
                    <td width="16%" style="background-color: #bbb; white-space: nowrap; ">Time Out</td>
                    </tr>
                </thead>
                <tbody>
EOD;

    $table_end=<<<EOD
        </tbody>
    </table>
EOD;
    $odd_even_flag=true;
    $count=0;

    $page_data.=$table_header;
    foreach( $result as $value ) {
        if($odd_even_flag) {
            $table_data= <<<EOD
            <tr>
                <td width="20%" style="border:1px solid #777; white-space: nowrap;">
                    $value[0]
                </td>
                <td width="35%" style="border:1px solid #777; white-space: nowrap;">
                    $value[1]
                </td>
                <td width="13%" style="border:1px solid #777; white-space: nowrap;">
                    $value[2]
                </td>
                <td width="16%" style="border:1px solid #777; white-space: nowrap;">
                    $value[3]
                </td>
                <td width="16%" style="border:1px solid #777; white-space: nowrap;">
                    $value[4]
                </td>
            </tr>
EOD;
        }else {
            $table_data= <<<EOD
            <tr>
                <td width="20%" style="background-color: #fafafa;border:1px solid #777; white-space: nowrap;">
                    $value[0]
                </td>
                <td width="35%" style="background-color: #fafafa;border:1px solid #777; white-space: nowrap;">
                    $value[1]
                </td>
                <td width="13%" style="background-color: #fafafa;border:1px solid #777; white-space: nowrap;">
                    $value[2]
                </td>
                <td width="16%" style="background-color: #fafafa;border:1px solid #777; white-space: nowrap;">
                    $value[3]
                </td>
                <td width="16%" style="background-color: #fafafa;border:1px solid #777; white-space: nowrap;">
                    $value[4]
                </td>
            </tr>
        
EOD;
        }
        $page_data.=$table_data;
        $count++;
        $odd_even_flag=!$odd_even_flag;
        if($count>=30){
            $odd_even_flag=true;
            $count=0;
            $page_data.=$table_end;
            $pdf->writeHTML($page_data, true, false, false, false, '');
            $pdf->AddPage();
            $page_data=$table_header;

        }
    }
    if($count!=0){
        $page_data.=$table_end;
        $pdf->writeHTML($page_data, true, false, false, false, '');
    }



// close and output PDF document
    $pdf->Output('entranceReport.pdf', 'I');


}

?>