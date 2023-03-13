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

$sql = "SELECT * FROM BSPD_Event order by Event_date desc;";
$result = mysqli_query($link, $sql);
$events = array();

while($row = mysqli_fetch_array($result))
{
    $event = new stdClass();
    $event->id = $row["EVENT_ID"];
    $event->description = $row["Event_Description"];
    $event->date = $row["Event_date"];
    /*$event->location = $row["Event_Location"];
    $event->status = $row["Event_status"];*/
    $event->notes = $row["Event_Notes"];
    $events[] = $event;
}

$heading = "Event Report";

try {
    echo $blade->run("event_report"
    , ['heading' => $heading
    ,  'events' => $events

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}