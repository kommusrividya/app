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



$sql = "SELECT EVENT_ID, Event_date, Event_Description FROM BSPD_Event where Event_status = 0 and Event_ID like 'CH%' order by Event_date desc;";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

$heading = "Report Contribution " . $row['EVENT_ID'];
$result = mysqli_query($link, $sql);
while($row = mysqli_fetch_array($result))
{
    $event = new stdClass();
    $event->id = $row["EVENT_ID"];
    $event->description = $row["Event_Description"];
    $event->date = $row["Event_date"];
    $events[] = $event;
}
$collector_filter = "AND
`L`.`Collector_ID` = ".$_SESSION['id']."";
if($_SESSION['permission'] & CASH_DESK_ADMIN) $collector_filter = "";
$sql = "SELECT 
            `L`.*, 
            `M`.`Alias` as `Cont_Alias`,
            `M2`.`Alias` as `Coll_Alias`
        FROM
            `Temp_SBOX_GNCD_Log` `L` JOIN `SBOX_Member` `M` JOIN `SBOX_Member` `M2`
        WHERE
            `L`.`Contributer_ID` = `M`.`MEMBER_ID` AND
            `L`.`Collector_ID` = `M2`.`MEMBER_ID` AND
            `L`.`Status` = 'entered' $collector_filter 
        ORDER BY SrNo DESC;";
$query = mysqli_query($link_test, $sql);
$members = array();

while($row = mysqli_fetch_array($query))
{
    $member = new stdClass();
    $member->sno = $row["SrNo"];
    $member->id = $row["Contributer_ID"];
    $member->colname = $row['Coll_Alias'];
    $member->conname = $row['Cont_Alias'];
    $member->event = $row["EVENT_ID"];
    $member->amount = $row["Amount"];
    $member->notes = $row["Notes"];     
    $members[] = $member;
}

try {
    echo $blade->run("cash_collection"
    , ['heading' => $heading
    ,   "events" => $events
    ,  'collector_id' => $_SESSION['id']
    ,  'collector_name' => $_SESSION['name']
    ,   "members" => $members
    


]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}