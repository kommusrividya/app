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

$heading = "Member Update";

$sql = "SELECT * FROM BSPD_Member where MEMBER_ID = ".$_SESSION['id'].";";
$query = mysqli_query($link, $sql);
$row = mysqli_fetch_array($query);

$sql = "SELECT * FROM BSPD_Member_Privileges where MEMBER_ID = ".$_SESSION['id'].";";
$query = mysqli_query($link, $sql);
$row1 = mysqli_fetch_array($query);

$sql = "SELECT * FROM BSPD_Nakshatra;";
$query = mysqli_query($link, $sql);
$nakshatras = array();
while($row2 = mysqli_fetch_array($query))
{
    $nakshatra = new stdClass();
    $nakshatra->id = $row2['NID'];
    $nakshatra->engname = $row2['All_S_English'];
    $nakshatra->telname = $row2['All_S_Telugu'];
    $nakshatras[] = $nakshatra;
}

$sql = "SELECT * FROM BSPD_Pravara_Gotra order by Gotra, Pravara;";
$query = mysqli_query($link, $sql);
$gotras = array();
while($row3 = mysqli_fetch_array($query))
{
    $gotra = new stdClass();
    $gotra->id = $row3['PG_ID'];
    $gotra->name = $row3['Gotra'];
    $gotra->pravara = $row3['Pravara'];
    $gotras[] = $gotra;
}



try {
    echo $blade->run("member_update"
    , ['heading' => $heading
    ,  'row' => $row
    ,  'row1' => $row1
    ,  "nakshatras" => $nakshatras
    ,  "gotras" => $gotras
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}