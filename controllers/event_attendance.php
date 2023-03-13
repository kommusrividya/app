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



$heading = "Event Attendance";

$sql = "SELECT * FROM BSPD_Event where Event_status = 0;";
$query = mysqli_query($link, $sql);

$events = array();
while( $row = mysqli_fetch_array($query))
{
    $event = new stdClass();
    $event->id = $row['EVENT_ID'];
    $event->desc = $row['Event_Description'];
    $events[] = $event;
}

try {
    echo $blade->run("event_attendance"
    , ['heading' => $heading
    ,  'events' =>$events

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}