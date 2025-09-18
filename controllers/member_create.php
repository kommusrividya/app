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

$sql = "select * from BSPD_Pravara_Gotra where PG_ID > 0 order by Gotra";
$query = mysqli_query($link, $sql);

$gotrams = array();
while($row = mysqli_fetch_assoc($query))
{
    $gotram = new stdClass();
    $gotram->value = $row['PG_ID'];
    $gotram->str = $row['Gotra'].'-'.$row['Risheya'].'-'.$row['Pravara'];
    $gotrams[] = $gotram; 
}

$sql = "select * from BSPD_Zone_Location order by Ward";
$query = mysqli_query($link, $sql);

$locations = array();
while($row = mysqli_fetch_assoc($query))
{
   $location = new stdClass();
   $location->ward = $row['Ward'];
   $locations[] = $location;
}

$sql = "select * from BSPD_Member order by MEMBER_ID desc LIMIT 5";
$query = mysqli_query($link, $sql);
$members = array();

while($row = mysqli_fetch_array($query))
{
    $member = new stdClass();
    $member->name = $row['Alias'];
    $member->gotra = $row['Gotram_ID'];
    $member->age = date("Y") - $row['Year_Of_Birth'];
    $member->phno = substr($row['Phone_Num'],6,4);
    $members[] = $member;
}

$heading = "New member";

try {
    echo $blade->run("member_create"
    , ['heading' => $heading
    ,  "locations" => $locations
    ,  "gotrams" => $gotrams
    ,  "members" => $members

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}