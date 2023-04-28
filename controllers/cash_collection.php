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

$curr_event_id = $row['EVENT_ID'];
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
            *
        FROM
            Temp_SBOX_GNCD_Log
        WHERE
            Status = 'entered' $collector_filter 
        ORDER BY SrNo DESC;";
$query = mysqli_query($link_test, $sql);
$members = array();
$cont_count = mysqli_num_rows($query);

$sum = 0;

while($row = mysqli_fetch_array($query))
{
    $query1 = mysqli_query($link, "SELECT Alias as Cont_Alias FROM BSPD_Member WHERE MEMBER_ID = ".$row["Contributer_ID"].";");
    $row1 = mysqli_fetch_array($query1);

    $query2 = mysqli_query($link, "SELECT Alias as Coll_Alias FROM BSPD_Member WHERE MEMBER_ID = ".$row["Collector_ID"].";");
    $row2 = mysqli_fetch_array($query2);

    $member = new stdClass();
    $member->sno = $row["SrNo"];
    $member->id = $row["Contributer_ID"];
    $member->colname = $row2['Coll_Alias'];
    $member->conname = $row1['Cont_Alias'];
    $member->event = $row["EVENT_ID"];
    $member->amount = $row["Amount"];
    $member->notes = $row["Notes"];     
    $members[] = $member;
    $sum += $member->amount;
}

$sql = "select COLUMN_NAME
from INFORMATION_SCHEMA.COLUMNS
where TABLE_NAME='Temp_SBOX_CashHandOver' and COLUMN_NAME != 'EVENT_ID'";

$result = mysqli_query($link_test, $sql);
$name = [];

while( $row = mysqli_fetch_array($result) ) {
    array_push($name, $row['COLUMN_NAME']);
}

$sql = "SELECT * FROM Temp_SBOX_CashHandOver WHERE EVENT_ID = '$curr_event_id'";
$query = mysqli_query($link_test, $sql);


$denominations = [];
$denominations = array_fill(0,sizeof($name),0);
if(mysqli_num_rows($query) > 0) {
    $deno_row = mysqli_fetch_array($query);
    for( $i = 0 ; $i < sizeof($name) ; $i++ ) {
        // echo $deno_row[$name[$i]];
        $denominations[$i] = $deno_row[$name[$i]];
    }
}



try {
    echo $blade->run("cash_collection"
    , ['heading' => $heading
    ,   "events" => $events
    ,  'collector_id' => $_SESSION['id']
    ,  'collector_name' => $_SESSION['name']
    ,   "members" => $members
    ,   'sum' => $sum
    ,   'names' => $name
    ,   'cont_count' => $cont_count
    ,   'curr_event_id' => $curr_event_id
    ,   'denominations'=> $denominations
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}