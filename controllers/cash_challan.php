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
require_once "$APPDIR/numbertowords.php";

use eftec\bladeone\BladeOne;
use eftec\bladeone\BladeOneHtml;

$views = $APPDIR.'/views';
$compiledFolder = $APPDIR.'/compiled';

class myBlade extends  BladeOne {
    use BladeOneHtml;
}

$blade=new myBlade($views,$compiledFolder);



$sql = "SELECT EVENT_ID, Event_date, Event_Description FROM BSPD_Event where Event_status = 0 and Event_ID like 'CH%' order by Event_date desc;";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$event_id = $row['EVENT_ID'];

$heading = "Challan for $event_id";

// column names retrieval

$sql = "select COLUMN_NAME
from INFORMATION_SCHEMA.COLUMNS
where TABLE_NAME='Temp_SBOX_CashHandOver' and COLUMN_NAME != 'EVENT_ID'";

$result = mysqli_query($link_test, $sql);
$name = [];

while( $row = mysqli_fetch_array($result) ) {
    array_push($name, $row['COLUMN_NAME']);
}

// denominations retrieval

$sql = "SELECT * FROM Temp_SBOX_CashHandOver WHERE EVENT_ID = '$event_id'";
$query = mysqli_query($link_test, $sql);


$denominations = [];
$denominations = array_fill(0,sizeof($name),0);
if(mysqli_num_rows($query) > 0) {
    $deno_row = mysqli_fetch_array($query);
    for( $i = 0 ; $i < sizeof($name) ; $i++ ) {
        // echo $deno_row[$name[$i]];
        $denominations[$i] = $deno_row[$name[$i]];
    }
}

$amount = [];
$key = [];
$total_amount = 0;

// calculate total amount

for($i = 0; $i < sizeof($denominations); $i++) {
    $key = (int)substr($name[$i], 1, strlen($name[$i]));
    $amount[$i] = $key * $denominations[$i];
    $total_amount += $amount[$i];
}

$word_format = number2words($total_amount);

try {
    echo $blade->run("cash_challan"
    , ['heading' => $heading
    ,  'event_id' => $event_id
    ,  'denominations' => $denominations
    ,  'total_amount' => $total_amount
    ,  'amount' => $amount
    ,  'names' => $name
    ,  'word_format' => $word_format
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}