<?php
/**
 * Copyright (c) 2016 Jorge Patricio Castro Castillo MIT License.
 */
include "../lib/BladeOne.php";

include "../lib/BladeOneHtml.php";
include "../lib/BladeOneHtmlBootstrap.php";

require_once "C:/xampp/htdocs/toastmasters/constant.php";

use eftec\bladeone\BladeOne;
use eftec\bladeone\BladeOneHtml;

$views = __DIR__ . '/views';
$compiledFolder = __DIR__ . '/compiled';

class myBlade extends  BladeOne {
    use BladeOneHtml;
}

$blade=new myBlade($views,$compiledFolder);

$sql = "SELECT * FROM urf_sandbox.SBOX_TNG_Event;";
$result = mysqli_query($link_test, $sql);
$events = array();
while($row = mysqli_fetch_array($result))
{
    $event = new stdClass();
    $event->id = $row["id"];
    $event->name = $row["event_name"];
    $event->code = $row["event_code"];
    $events[] = $event;
}
$heading = "Event Updation";

try {
    echo $blade->run("Registration.eventupdation"
    , ["events" => $events
    , 'heading' => $heading
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}
