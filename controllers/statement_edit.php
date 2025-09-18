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

$heading = "SIB Statement Edit";

$sql = "SELECT * FROM BSPD_SIB_Collection_Report where Archive = 0;";
$result = mysqli_query($link, $sql);

$records = array();
while($row = mysqli_fetch_array($result))
{
    $record = new stdClass();
    $record->SrNo = $row['SrNo'];
    $record->arc = $row['Archive'];
    $record->org = $row['ORGNAME'];
    $record->id = $row['ID'];
    $record->slno = $row['SLNO'];
    $record->name = $row['NAME'];
    $record->trdate = $row['TRANDATE'];
    $record->tramt = $row['TRANAMT'];
    $record->src = $row['SOURCE'];
    $record->notes = $row['Notes'];
    $records[] = $record;
}
try {
    echo $blade->run("statement_edit"
    , ['heading' => $heading
    ,  'records' => $records

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}