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

$heading = "Voucher List";

$sql = "SELECT EVENT_ID, Event_date, Event_Description FROM BSPD_Event where Event_status = 0 and Event_ID like 'CH%' order by Event_date desc;";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

$qpl="SELECT Voucher_Num,Name,Sub_Category,Amount_Details FROM bspdhyd_wp1.BSPD_View_Expense_Report where EVENT_ID='".$row['EVENT_ID']."';";
$result=mysqli_query($link, $qpl);

$vouchers = array();

while($row = mysqli_fetch_array($result))
{
    $voucher = new stdClass();
    $voucher->number = $row["Voucher_Num"];
    $voucher->name = $row["Name"];
    $voucher->sub_category = $row["Sub_Category"];
    $voucher->amount_details = $row["Amount_Details"];
    $vouchers[] = $voucher;
}

try {
    echo $blade->run("voucherlist"
    , ['heading' => $heading
    ,  "vouchers" => $vouchers

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}