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

$sql = "select id from urf_sandbox.SBOX_TNG_Event where event_active = 1";
$result = mysqli_query($link_test, $sql);

$row = mysqli_fetch_array($result);
$event_id = $row["id"];

$sql = "select id, batch_name from urf_sandbox.SBOX_TNG_Event_Batch where event_id = ".$event_id.";";
$result = mysqli_query($link_test, $sql);

$blade=new myBlade($views,$compiledFolder);

$agegroups[] = array(); 
while($row = mysqli_fetch_array($result))
{
        $agegroup=new stdClass();
        $agegroup->id=$row['id'];
        $agegroup->name=$row['batch_name'];
        $agegroups[]= $agegroup;
}

$sql = "SELECT `COLUMN_NAME` 
FROM `INFORMATION_SCHEMA`.`COLUMNS` 
WHERE `TABLE_SCHEMA`='urf_sandbox' 
    AND `TABLE_NAME`='SBOX_TNG_Event_Participant';";

$result = mysqli_query($link_test, $sql);

$details = array();
while($row = mysqli_fetch_array($result))
{
        $detail=new stdClass();
        $detail->id=$row['COLUMN_NAME'];
        $detail->name=$row['COLUMN_NAME'];
        $details[] = $detail;
}

$sql = "SELECT id, event_date, event_name FROM urf_sandbox.SBOX_TNG_Event;";

$result = mysqli_query($link_test, $sql);
$row = mysqli_fetch_array($result);
$event_details = new stdClass();
$event_details->id = $row['id'];
$event_details->name = $row['event_name'];
$event_details->date = $row['event_date'];


$detail = new stdClass();
$detail->id = 'memberid';
$detail->name = 'BSPD Member ID';
$details[]=$detail;
$detail = new stdClass();
$detail->id = 'phno';
$detail->name = 'Phone number';
$details[]=$detail;
$detail = new stdClass();
$detail->id = 'firstname';
$detail->name = 'First name';
$details[]=$detail;
$detail = new stdClass();
$detail->id = 'lastname';
$detail->name = 'Last name';
$details[]=$detail;

$membertypes[] = array();
$membertype=new stdClass();
        $membertype->id=1;
        $membertype->cod='participant';
        $membertype->name="Participant";
$membertypes[]=$membertype;
$membertype=new stdClass();
        $membertype->id=2;
        $membertype->cod='audience';
        $membertype->name="Audience";
$membertypes[]=$membertype;
$membertype=new stdClass();
        $membertype->id=3;
        $membertype->cod='parent';
        $membertype->name="Parent";
$membertypes[]=$membertype;

$agegroupSelected=1;
$membertypeSelected=1;
//<editor-fold desc="Example data">
//print_r($agegroups);
try {
    echo $blade->run("Registration.index"
    , ["agegroups" => $agegroups
    , 'agegroupSelected' => $agegroupSelected
    , "membertypes" => $membertypes
    , 'membertypeSelected' => $membertypeSelected
    , 'details' => $details
    , 'event_details' => $event_details
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}
