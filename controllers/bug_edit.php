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

$sql = "SELECT 
`B`.*, `M`.`Alias` as Alias
FROM
`SBOX_Bug_Report` `B` JOIN `SBOX_Member` `M`
WHERE
`B`.`MEMBER_ID` = `M`.`MEMBER_ID` and
`B`.`Status` != 'Closed' and
`B`.`Status` != 'Hold' 
ORDER BY Sequence;";
$query = mysqli_query($link_test, $sql);
$bugs = array();

while( $row = mysqli_fetch_array($query) ) 
{
    $bug = new stdClass();
    $bug->id = $row['Ticket_No'];
    $bug->name = $row['Alias'];
    $bug->member_id = $row['MEMBER_ID'];
    $bug->category = $row['Category'];
    $bug->description = $row['Description'];
    $bug->status = $row['Status'];
    $bug->header_uid = $row['Header_UID'];
    $bug->resolution = $row['Resolution'];
    $bug->resolved_by = $row['Resolved_By'];
    $bug->sequence = $row['Sequence'];
    $bugs[] = $bug;
}

$blade=new myBlade($views,$compiledFolder);

$heading = "Issue Tracker";

try {
    echo $blade->run("bug_edit"
    , ['heading' => $heading
    ,  'bugs' => $bugs

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}