<?php
/**
 * Copyright (c) 2016 Jorge Patricio Castro Castillo MIT License.
 */
session_start();

$APPDIR = dirname( dirname(__FILE__) );
include "$APPDIR/vendors/bladeone/lib/BladeOne.php";

include "$APPDIR/vendors/bladeone/lib/BladeOneHtml.php";
include "$APPDIR/vendors/bladeone/lib/BladeOneHtmlBootstrap.php";

require_once "$APPDIR/constant.php";
require_once "$APPDIR/ssdbconfig.php";
require_once "$APPDIR/sessiontimeout.php";

use eftec\bladeone\BladeOne;
use eftec\bladeone\BladeOneHtml;

$views = $APPDIR.'/views';
$compiledFolder = $APPDIR.'/compiled';

class myBlade extends  BladeOne {
    use BladeOneHtml;
}

$blade=new myBlade($views,$compiledFolder);

$heading = "Bills not submitted";

$sql = "SELECT TRN_ID, Name, EVENT_ID,Amount_Details,Amount,Bill_Status,SoftCopyBill FROM bspdhyd_wp1.BSPD_View_Expense_Report where TRN_DATE between '20230401' and '20240331' and Bill_Status not in ( 'received','NA');";
$query = mysqli_query($link, $sql);
while($row2 = mysqli_fetch_array($query))
{
    $bill = new stdClass();
    $bill->TRN_ID = $row2['TRN_ID'];
    $bill->Name = $row2['Name'];
    $bill->EVENT_ID = $row2['EVENT_ID'];
    $bill->Amount_Details = $row2['Amount_Details'];
    $bill->Amount = $row2['Amount'];
    $bill->Bill_Status = $row2['Bill_Status'];
    $bill->SoftCopyBill = $row2['SoftCopyBill'];
    $bills[] = $bill;
}

try {
    echo $blade->run("pending_bills"
    , ['heading' => $heading
    ,  "bills" => $bills
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}