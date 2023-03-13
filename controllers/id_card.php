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
//$heading = "Event Updation";

$sql = "SELECT * FROM BSPD_Member where MEMBER_ID = ".$_SESSION['id'].";";
$query = mysqli_query($link, $sql);
$row = mysqli_fetch_array($query);

$sql1 = "SELECT Gotra FROM BSPD_Pravara_Gotra where PG_ID = ".$row['Gotram_ID'].";";
$query1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($query1);
$gotram = $row1['Gotra'];

try {
    echo $blade->run("id_card"
    , [ 'row' => $row
    ,   'gotram' => $gotram
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}