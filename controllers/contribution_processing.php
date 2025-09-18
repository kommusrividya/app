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

$sql1 = "SELECT min(EVENT_ID) as event, DEShCode FROM BSPD_Event where EVENT_ID like 'CH%' and Event_status = 0;";
$query = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($query);
$ch_event = $row1['event'];
$ch_entity_id = $row1['DEShCode'];

$sql1 = "SELECT EVENT_ID as event, DEShCode FROM BSPD_Event WHERE EVENT_ID LIKE 'GN%' AND Event_status = 0";
// echo $sql1;

// Execute the query and check for errors
$query = mysqli_query($link, $sql1);
if (!$query) {
    die("Query failed: " . mysqli_error($link));
}

$gn_events = array();
while ($row1 = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $details['event'] = $row1['event'];
    $details['entity_id'] = $row1['DEShCode'];
    
    $gn_events[] = $details;
}

$sql = "SELECT * FROM BSPD_View_Convert_Stmt_NonBVCD2022 order by SrNo;";
$result = mysqli_query($link, $sql);

$records = array();

while($row = mysqli_fetch_array($result))
{
    $event1 = "";
    $entity_id1 = "BHBNR001";
    $str = substr($row['EVENT_ID'], 0, 2);
    $source = $row['SOURCE'];
    
    if($str == 'GN') {
        $event1 = 'GN';
        $amount = substr((string)$row['Amount'], -2);

        foreach($gn_events as $gn_event) {
            $gn_event_id = substr($gn_event['event'],-2);
            // echo "Amount: $amount";
            // echo "<br>EVENT: ".$gn_event['event']."<br>";
            if($gn_event_id == $amount) { $event1 = $gn_event['event']; $entity_id1 = $gn_event['entity_id'];}
        }
        
    }
    if($str == 'CP') $event1 = 'CP';
    if($str == 'CH') { $event1 = $ch_event; $entity_id1 = $ch_entity_id;} 
    if($str == 'BV') { $event1 = 'BVCY2025'; $entity_id1 = "UNIVL001";} 
    
    if($source == "UPI") {$event1 = $ch_event; $entity_id1 = $ch_entity_id;}
    
    $record = new stdClass();
    $record->SrNo = $row['SrNo'];
    $record->Member_id = $row['Member_id'];
    $record->event = $event1;
    $record->entity_id = $entity_id1;
    $record->Amount = $row['Amount'];
    $record->Contribution_Type = $row['Contribution_Type'];
    $record->Contribution_Date = $row['Contribution_Date'];
    $record->Reference_Details = $row['Reference_Details'];
    $record->Approved = $row['Approved'];
    $record->CreatedBy = $row['CreatedBy'];
    $records[] = $record;
}

$sql = "SELECT * FROM BSPD_Event where Event_status = '0';";

$result = mysqli_query($link, $sql);
$events = array();

while($row = mysqli_fetch_array($result))
{
    $event = new stdClass();
    $event->id = $row['EVENT_ID'];
    $event->entity_id = $row['DEShCode'];
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