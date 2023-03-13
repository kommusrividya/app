<?php
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

$sql1 = "SELECT min(EVENT_ID) as event FROM BSPD_Event where EVENT_ID like 'CH%' and Event_status = 0;";
$query = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($query);
$ch_event = $row1['event'];

$sql = "SELECT * FROM BSPD_View_Convert_Stmt_NonBVCD2022 order by SrNo;";
$result = mysqli_query($link, $sql);

$records = array();

while($row = mysqli_fetch_array($result))
{
    $event1 = "";
    $str = substr($row['EVENT_ID'], 0, 2);
    
    if($str == 'GN') $event1 = 'GN';
    if($str == 'CP') $event1 = 'CP';
    if($str == 'CH') $event1 = $ch_event;
    if($str == 'BV') $event1 = 'BVCY2023';
    
    $record = new stdClass();
    $record->SrNo = $row['SrNo'];
    $record->Member_id = $row['Member_id'];
    $record->event = $event1;
    $record->Amount = $row['Amount'];
    $record->Contribution_Type = $row['Contribution_Type'];
    $record->Contribution_Date = $row['Contribution_Date'];
    $record->Reference_Details = $row['Reference_Details'];
    $record->Approved = $row['Approved'];
    $record->CreatedBy = $row['CreatedBy'];
    $records[] = $record;
}

$sql = "SELECT * FROM urf_sandbox.SBOX_Event where Event_status = '0';";
$result = mysqli_query($link_test, $sql);
$events = array();

while($row = mysqli_fetch_array($result))
{
    $event = new stdClass();
    $event->id = $row['EVENT_ID'];
    $events[] = $event; 
}

$heading = "Contribution Processing";

try {
    echo $blade->run("contribution_processing"
    , ['heading' => $heading
    ,  'records' => $records
    ,  'events' => $events

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}

    /*$sql1 = "INSERT INTO `urf_sandbox`.`SBOX_Member_Contribution` (`Member_id`, `EVENT_ID`, `Amount`, `Contribution_Type`, `Contribution_Date`, `Reference_Details`, `Approved`, `CreatedBy`) 
    VALUES ('".$row['Member_id']."', '$event', '".$row['Amount']."', '".$row['Contribution_Type']."', '".$row['Contribution_Date']."', '".$row['Reference_Details']."', 'Y', '1933');";
    if(mysqli_query($link_test, $sql1)) echo "success";*/

    /*  -----------------------------------
    $event = "";
    if(str_contains($row['EVENT_ID'], 'GN')) $event = 'GN';
    if(str_contains($row['EVENT_ID'], 'CP')) $event = 'CP';
    if(str_contains($row['EVENT_ID'], 'CH')) $event = $ch_event;
    if(str_contains($row['EVENT_ID'], 'BV')) $event = 'BVCY2022';
    -----------------------------------------*/ 