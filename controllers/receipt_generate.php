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
// require_once "$APPDIR/sessiontimeout.php";

use eftec\bladeone\BladeOne;
use eftec\bladeone\BladeOneHtml;

$views = $APPDIR.'/views';
$compiledFolder = $APPDIR.'/compiled';

class myBlade extends  BladeOne {
    use BladeOneHtml;
}

$blade=new myBlade($views,$compiledFolder);

$encrypted_id = $_GET['id'];

function DecryptDetails($link, $value)
{
	//******************Code for Decryption********
	$decryption_iv = '1234567891011121';        // Non-NULL Initialization Vector for decryption 
	//$decryption_Key = $type;
	$decryption_key = "BSPDHYDContributionReceipt";   // Store the decryption key 
	$ciphering = "AES-128-CTR";
	$options = 0;
	$decryptvalue = openssl_decrypt($value, $ciphering, $decryption_key, $options, $decryption_iv);  // Use openssl_decrypt() function to decrypt the data 
	return $decryptvalue;
	//     echo "Decrypted String: " . $decryptAcct;   // Display the decrypted string 
}

$id = DecryptDetails($link, $encrypted_id);

$sql = "SELECT 
    Transaction_Code,
    Full_Name,
    BSPD_Member_id,
    Amount,
    Amount_In_Words,
    Contribution_Type,
    Event_Description,
    EVENT_ID,
    Event_Location,
    Reference_Details,
    DATE_FORMAT(Contribution_Date, '%d-%b-%Y') AS Contribution_Date,
	DATE_FORMAT(Receipt_Date, '%d-%b-%Y') AS Receipt_Date
 FROM BSPD_View_Contribution_Report where Transaction_Code = $id;";
$query = mysqli_query($link, $sql);
$row = mysqli_fetch_array($query);

$receipt = new stdClass();
$receipt->no = $row['Transaction_Code'];
$receipt->cont_date = $row['Contribution_Date'];
$receipt->recpt_date = $row['Receipt_Date'];
$receipt->name = $row['Full_Name'];
$receipt->member_id = $row['BSPD_Member_id'];
$receipt->amount = $row['Amount'];
$receipt->amount_in_words = $row['Amount_In_Words'];
$receipt->cont_type = $row['Contribution_Type'];
$receipt->event_desc = $row['Event_Description'];
$receipt->event_id = $row['EVENT_ID'];
$receipt->event_loc = $row['Event_Location'];
$receipt->ref = $row['Reference_Details'];

$charno = 75;
$original_string = "Received from Smt./Shri. ".$receipt->name." ( Member Id ".$receipt->member_id." ) a sum of Rs. ". $receipt->amount ." ( ". $receipt->amount_in_words ." ) through ". $receipt->cont_type ." contribution towards ". $receipt->event_desc ." ( ". $receipt->event_id ." ) at ". $receipt->event_loc ." vide Reference : ( ". $receipt->ref ." ) Dated: ". $receipt->cont_date;
$length = strlen($original_string);
$lines = ($length/$charno) + 1; //adding 1 to adjust for fractional line
$start = 0;
$str = array();
$i = 0;
for($i = 0; $i < $lines; $i++)
{
    $str[$i] = substr($original_string,$start,$charno);
    // for 65 character line, if the last charcater is non blank, insert hyphen
    if(strlen($str[$i]) == $charno && ($str[$i][$charno-1] != " ")) $str[$i][$charno-1] = '-'; 
    $start += $charno-1;
}
$heading = "Receipt Generate";

try {
    echo $blade->run("receipt_generate"
    , ['heading' => $heading
    ,  'receipt' => $receipt
    ,  'str' => $str
    ,  'lines'=> $lines

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}