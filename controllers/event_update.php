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
$heading = "Event Updation";

$sql = "SELECT EVENT_ID, Event_date, Event_Description FROM BSPD_Event order by Event_date desc;";
$result = mysqli_query($link, $sql);
$events = array();

while($row = mysqli_fetch_array($result))
{
    $event = new stdClass();
    $event->id = $row["EVENT_ID"];
    $event->description = $row["Event_Description"];
    $event->date = $row["Event_date"];
    $events[] = $event;
}

try {
    echo $blade->run("event"
    , ['heading' => $heading
    ,  'events' => $events
    ,  'form_mode' => "update"

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}