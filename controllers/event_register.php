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

$heading = "Event Registration";

$sql = "SELECT EVENT_ID, Event_date, Event_Description, Event_Notes FROM BSPD_Event where Event_status = 0;";
$result = mysqli_query($link, $sql);
$events = array();

while($row = mysqli_fetch_array($result))
{
    $event = new stdClass();
    $event->id = $row["EVENT_ID"];
    $event->description = $row["Event_Description"];
    $event->date = $row["Event_date"];
    $event->notes = $row["Event_Notes"];
    $events[] = $event;
}

try {
    echo $blade->run("event_register"
    , ['heading' => $heading
    ,  "events" => $events

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}