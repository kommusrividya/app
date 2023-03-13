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

$heading = "BSPD";

try {
    echo $blade->run("Registration.header"
    , ['heading' => $heading
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}
