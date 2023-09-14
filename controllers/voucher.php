<?php
/**
 * Copyright (c) 2016 Jorge Patricio Castro Castillo MIT License.
 */
session_start();

$EVENT_ID = $_GET['EVENT_ID'];
$Start = $_GET['start'];
$End = $_GET['end'];

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

function DecryptDetails($link, $value){ 
	//******************Code for Decryption********
		   $decryption_iv = '1234567891011121';        // Non-NULL Initialization Vector for decryption 
		   //$decryption_Key = $type;
		   $decryption_key = "PayeeBankAccountNumber";   // Store the decryption key 
		   $ciphering = "AES-128-CTR"; 
		   $options = 0; 
		   $decryptvalue=openssl_decrypt ($value, $ciphering, $decryption_key, $options, $decryption_iv);  // Use openssl_decrypt() function to decrypt the data 
		   return $decryptvalue;
	//     echo "Decrypted String: " . $decryptAcct;   // Display the decrypted string 
}

$sql = "SELECT * FROM bspdhyd_wp1.BSPD_View_Expense_Report where EVENT_ID = '$EVENT_ID' and Voucher_Num between $Start AND $End ORDER BY Voucher_Num;";
$query = mysqli_query($link, $sql);
$vouchers = array();
while($row = mysqli_fetch_array($query))
{
    $voucher = new stdClass();
    $voucher->date = $row['TRN_DATE'];
    $voucher->eventid = $row['EVENT_ID'];
    $voucher->vno = $row['Voucher_Num'];
    $voucher->expense_type = $row["Expense_Type"];
    $voucher->payee_id = $row["Payee_ID"];
    $voucher->name = $row["Name"];
    $voucher->phno = $row["Phone_Num"];
    $voucher->Amt_In_Words = $row["Amt_In_Words"];
    $voucher->towards = $row["Amount_Details"];
    $voucher->bill = $row["Expense_Bill_Num"];
    $voucher->amount = $row["Amount"];
    $voucher->category = $row["Category"];
    $voucher->sub_category = $row["Sub_Category"];
    $voucher->nameinact = substr($row["Name_In_Account"],0,45);
    $voucher->ifsc = $row["IFSC_CODE"];
    $Payee_Acnt_Num = DecryptDetails($link, $row["Payee_Acnt_Num"]);
    $voucher->accnt_num = $Payee_Acnt_Num;
    $vouchers[] = $voucher;
}


$heading = "Voucher";

try {
    echo $blade->run("voucher"
    , [ 'heading' => $heading,
        "vouchers" =>$vouchers

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}