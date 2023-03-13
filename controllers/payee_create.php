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
//require_once "$APPDIR/sessiontimout.php";

use eftec\bladeone\BladeOne;
use eftec\bladeone\BladeOneHtml;

$views = $APPDIR.'/views';
$compiledFolder = $APPDIR.'/compiled';

class myBlade extends  BladeOne {
    use BladeOneHtml;
}

$blade=new myBlade($views,$compiledFolder);

$heading = "Payee Create";

$sql = "SELECT Payee_ID, Name, Phone_Num FROM BSPD_Payee;";
$result = mysqli_query($link, $sql);
$payees = array();

while($row = mysqli_fetch_array($result))
{
    $payee = new stdClass();
    $payee->id = $row["Payee_ID"];
    $payee->name = $row["Name"];
    $payee->phone_num = $row["Phone_Num"];
    $payees[] = $payee;
}

try {
    echo $blade->run("payee"
    , ['heading' => $heading
    ,  'payees' => $payees

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}