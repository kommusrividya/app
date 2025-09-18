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
EVENT_ID and description
Payee ID and name
category ID from transaction code master
sub category from transaction code master
*/

$sql = "SELECT EVENT_ID, Event_date, Event_Description, DEShCode FROM BSPD_Event order by Event_date desc;";
$result = mysqli_query($link, $sql);
$events = array();

while($row = mysqli_fetch_array($result))
{
    $event = new stdClass();
    $event->id = $row["EVENT_ID"];
    $event->entity_id = $row["DEShCode"];
    $event->description = $row["Event_Description"];
    $event->date = $row["Event_date"];
    
    $sql1 = "SELECT max(Voucher_Num)+1 as voucher FROM BSPD_Expenses where EVENT_ID='$event->id';";
    $result1 = mysqli_query($link, $sql1);
    $row1 = mysqli_fetch_array($result1);
    if($row1["voucher"] != NULL) $event->voucher = $row1["voucher"];
    else $event->voucher = 1;
    $events[] = $event;
}

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

$sql = "SELECT distinct Category_ID, Category_Desc FROM BSPD_Transaction_Code_Master where Categroy_Type = 'Expense';";
$result = mysqli_query($link, $sql);
$categories = array();

while($row = mysqli_fetch_array($result))
{
    $category = new stdClass();
    $category->id = $row["Category_ID"];
    $category->description = $row["Category_Desc"];
    $categories[] = $category;
}

$sql = "SELECT distinct Sub_Category_ID, Sub_Category_Desc FROM BSPD_Transaction_Code_Master where Categroy_Type = 'Expense';";
$result = mysqli_query($link, $sql);
$sub_categories = array();

while($row = mysqli_fetch_array($result))
{
    $sub_category = new stdClass();
    $sub_category->id = $row["Sub_Category_ID"];
    $sub_category->description = $row["Sub_Category_Desc"];
    $sub_categories[] = $sub_category;
}

$heading = "Expense Updation";

try {
    echo $blade->run("expense"
    , ["events" => $events
    , "payees" => $payees
    , "categories" => $categories
    , "sub_categories" => $sub_categories
    , 'heading' => $heading
    , 'form_mode' => "update"

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}