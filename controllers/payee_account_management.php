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

$heading = "Payee Management";

$sql = "SELECT * FROM BSPD_Payee order by Payee_ID desc;";
$result = mysqli_query($link, $sql);
$payees = array();

while($row = mysqli_fetch_array($result))
{
    $payee = new stdClass();
    $payee->id = $row["Payee_ID"];
    $payee->memid = $row["MEMBER_ID"];
    $payee->name = $row["Name"];
    $payee->email = $row["Email_ID"];
    $payee->phno = $row["Phone_Num"];
    $payees[] = $payee;
}

try {
    echo $blade->run("payee_account_management"
    , ['heading' => $heading
    ,  'payees' => $payees

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}