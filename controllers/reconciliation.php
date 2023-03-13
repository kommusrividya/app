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

$heading = "Submit for Reconciliation";


$collector_filter = "AND Collector_ID = '".$_SESSION['id']."'";
if($_SESSION['permission'] & CASH_DESK_ADMIN) $collector_filter = "";

$sql = "SELECT 
        UTR, SUM(Amount) AS Amount, Alias
        FROM
        Temp_SBOX_GNCD_Log L JOIN SBOX_Member M 
        WHERE
            Collector_ID = MEMBER_ID
            AND UTR != '0' 
            ".$collector_filter." 
            AND L.Status != 'reconciled'
        GROUP BY UTR;";
$query = mysqli_query($link_test, $sql);
$recrecords = array(); //reconciliation records - recrecords

while($row = mysqli_fetch_array($query))
{
    $recrecord = new stdClass();
    $recrecord->utr = $row["UTR"];
    $recrecord->amount = $row["Amount"];
    $recrecord->colname = $row["Alias"];
    $recrecords[] = $recrecord;
}

$collector_filter = "AND Collector_ID = ".$_SESSION['id']."";
if($_SESSION['permission'] & CASH_DESK_ADMIN) $collector_filter = "";
$sql = "SELECT 
            L.*, M.Alias as Collector, M2.Alias as Contributor
        FROM
            Temp_SBOX_GNCD_Log L JOIN SBOX_Member M JOIN SBOX_Member M2
        WHERE
            M.MEMBER_ID = L.Collector_ID AND
            M2.MEMBER_ID = L.Contributer_ID 
            $collector_filter 
        ORDER BY Status , Collector_ID , UTR;";
$query = mysqli_query($link_test, $sql);
$members = array();
$members_reconciled = array();

while($row = mysqli_fetch_array($query))
{
    $member = new stdClass();
    $member->sno = $row["SrNo"];
    $member->utr = $row["UTR"];
    $member->id = $row["Contributer_ID"];
    $member->colname = $row['Collector'];
    $member->conname = $row['Contributor'];
    $member->event = $row["EVENT_ID"];
    $member->amount = $row["Amount"];
    $member->notes = $row["Notes"];
    $member->status = $row["Status"];
    //if($member->status != 'reconciled')  
    $members[] = $member;
    //else  $members_reconciled[] = $member;
}

$collector_filter = "and right(ID,5) = ".$_SESSION['id'].";";
if($_SESSION['permission'] & CASH_DESK_ADMIN) $collector_filter = "";
$sql = "SELECT SLNO, TRANDATE, TRANAMT, ID FROM SBOX_SIB_Collection_Report where Archive = 0 ".$collector_filter;
$query = mysqli_query($link_test, $sql);
$bank_records = array();

if(mysqli_num_rows($query) > 0)
{
    while($row = mysqli_fetch_array($query))
    {
        $bank_record = new stdClass();
        $bank_record->id = $row['ID'];
        $bank_record->utr = $row['SLNO'];
        $bank_record->date = $row['TRANDATE'];
        $bank_record->amount = $row['TRANAMT'];
        $bank_records[] = $bank_record;
    }
}
else $bank_records = "0";


try {
    echo $blade->run("reconciliation"
    , ['heading' => $heading
    ,  'collector_id' => $_SESSION['id']
    ,  'collector_name' => $_SESSION['name']
    ,  "members" => $members
    ,  "members_reconciled" => $members_reconciled
    ,  "recrecords" => $recrecords
    ,  "bank_records" => $bank_records
    


]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}