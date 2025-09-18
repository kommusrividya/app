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

$heading = "Job Opportunities";

$sql = "SELECT 
        *
        FROM
        Career_Opportunity C 
        order by opportunity_id desc";
$result = mysqli_query($link_test, $sql);

while($row = mysqli_fetch_array($result))
{
    $post = new stdClass();
    $post->id = $row["opportunity_id"];
    $post->header = $row["opp_header"];
    $post->date = $row["created_at"];
    $post->description = nl2br($row["opp_description"]);
    $post->company = $row["company"];
    $post->phno = $row["contact_phno"];
    $post->email = $row["contact_email"];
    $post->notes = $row["contact_notes"];
    $postby = $row["posted_by"];

    $sql1 = "SELECT Alias FROM BSPD_Member WHERE MEMBER_ID = $postby";
    $result1 = mysqli_query($link, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $post->postby = $row1['Alias'];

    $posts[] = $post;
}

try {
    echo $blade->run("careers"
    , ['heading' => $heading
    , 'posts' => $posts

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}