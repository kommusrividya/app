<?php
/**
 * Copyright (c) 2016 Jorge Patricio Castro Castillo MIT License.
 */
include "../lib/BladeOne.php";

include "../lib/BladeOneHtml.php";
include "../lib/BladeOneHtmlBootstrap.php";

require_once "C:/xampp/htdocs/toastmasters/constant.php";

use eftec\bladeone\BladeOne;
use eftec\bladeone\BladeOneHtml;

$views = __DIR__ . '/views';
$compiledFolder = __DIR__ . '/compiled';

class myBlade extends  BladeOne {
    use BladeOneHtml;
}

$blade=new myBlade($views,$compiledFolder);

$sql = "SELECT
COLUMN_TYPE as event_type
FROM
INFORMATION_SCHEMA.COLUMNS
WHERE
TABLE_SCHEMA = 'urf_sandbox' AND TABLE_NAME = 'SBOX_TNG_Event' AND COLUMN_NAME = 'event_type';";

$result = mysqli_query($link_test, $sql);
$row = mysqli_fetch_array($result);

$str = trim($row['event_type'],"enum()");
$types = explode(",",$str);
for($i=0;$i<sizeof($types);$i++)
    $types[$i] = trim($types[$i],"''");

$heading = "Event Creation";


try {
    echo $blade->run("Registration.eventcreation"
    , ["types" => $types
    , 'heading' => $heading

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}

