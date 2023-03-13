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


use eftec\bladeone\BladeOne;
use eftec\bladeone\BladeOneHtml;

$views = $APPDIR.'/views';
$compiledFolder = $APPDIR.'/compiled';

class myBlade extends  BladeOne {
    use BladeOneHtml;
}

$blade=new myBlade($views,$compiledFolder);
$heading = "Bulk ID print";

$sql = "SELECT 
            `m`.`MEMBER_ID` as member_id,
            `m`.`Surname` as surname,
            `m`.`Name` as name,
            `m`.`Phone_Num` as phno,
            `m`.`Year_Of_Birth` as yob,
            `g`.`Gotra` as gotra,
            `g`.`Pravara` as pravara
            FROM
            `BSPD_Member` `m` JOIN
            `BSPD_Event_Registration` `r` JOIN
            `BSPD_Pravara_Gotra` `g`
            WHERE
            `m`.`MEMBER_ID` = `r`.`MEMBER_ID` AND
            `m`.`Gotram_ID` = `g`.`PG_ID` AND
            `r`.`EVENT_ID` = 'GN0012' AND
            `r`.`Registered` = 'Y'
            ORDER BY
            `m`.`Surname`, `m`.`Name`;";

$query = mysqli_query($link, $sql);
$members = array();
while( $row = mysqli_fetch_array($query) )
{
    $member = new stdClass();
    $member->id = $row['member_id'];
    $member->surname = $row['surname'];
    $member->name = $row['name'];
    $member->phno = $row['phno'];
    $member->yob = $row['yob'];
    $member->gotra = $row['gotra'];
    $member->pravara = $row['pravara'];
    $members[] = $member;
}

try {
    echo $blade->run("print_id2"
    , [ 'members' => $members
    ,   'heading' => $heading
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}