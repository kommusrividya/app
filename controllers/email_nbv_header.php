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

/*
$sql = "SELECT UTRNumber from BSPD_NBV_File_Header where HeaderUID = 15";
$query = mysqli_query($link, $sql);
$row = mysqli_fetch_array($query);
$utrnumber = $row["UTRNumber"];

$sql = "SELECT min(Transaction_Code) as min, max(Transaction_Code) as max from BSPD_Member_Contribution where Reference_Details like '%270622182%'";
$query = mysqli_query($link, $sql);
$row = mysqli_fetch_array($query);
$min = $row["min"];
$max = $row["max"];


$sql = "SELECT * from BSPD_View_Contribution_Report where Transaction_Code between '$min' and '$max'";
$query = mysqli_query($link, $sql);
while( $row = mysqli_fetch_array($query))
{

}*/

$heading = "Send Email";

try {
    echo $blade->run("email_nbv_header"
    , ['heading' => $heading

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}