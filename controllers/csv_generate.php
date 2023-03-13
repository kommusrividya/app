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

$sql = "SELECT * FROM SIB_Payee_Upload_CSV;";
$result = mysqli_query($link, $sql);
$records = array();
$i=1;
while($row = mysqli_fetch_array($result))
{
    if($i==1) {$i=0;continue;}
    else {
    $record = new stdClass();
    $record->T1 = $row["T1"];
    $record->T2 = $row["T2"];
    $record->T3 = $row["T3"];
    $record->Name_In_Account = $row["Name_In_Account"];
    $record->Nick_Name = $row["Nick_Name"];
    $record->T6 = $row["T6"];
    $Payee_Acnt_Num = DecryptDetails($link, $row["Payee_Acnt_Num"]);
    $record->Payee_Acnt_Num = $Payee_Acnt_Num;
    $record->T8 = $row["T8"];
    $record->T9 = $row["T9"];
    $record->T10 = $row["T10"];
    $record->T11 = $row["T11"];
    $record->T12 = $row["T12"];
    $record->T13 = $row["T13"];
    $record->T14 = $row["T14"];
    $record->T15 = $row["T15"];
    $record->IFSC_CODE = $row["IFSC_CODE"];
    $records[] = $record;}
}

$sql = "SELECT count(distinct(EVENT_ID)) as event_count, count(EVENT_ID) as rec_count, sum(Amount) as total_amount FROM BSPD_SIB_Bulk_Payments_Upload_CSV";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$event_count = $row['event_count'];
$rec_count = $row['rec_count'];
$total_amount = $row['total_amount'];

$sql = "SELECT * FROM BSPD_SIB_Bulk_Payments_Upload_CSV order by EVENT_ID;";
$result = mysqli_query($link, $sql);
$records1 = array();
while($row = mysqli_fetch_array($result))
{
    $record1 = new stdClass();
    $record1->Dum1 = $row['Dum1'];
    $record1->reg_code = $row['Bank_Registraion_Code'];
    $record1->Dum2 = $row['Dum2'];
    $record1->Amount = $row['Amount'];
    $record1->Name = $row['Name_exp_6'];
    $records1[] = $record1;    
}

$sql = "SELECT Amount, IFSC_CODE, Payee_Acnt_Num, Name_In_Account FROM bspdhyd_wp1.BSPD_View_Expense_Report where Payment_Status='pay';";
$result = mysqli_query($link, $sql);
$records2 = array();
while($row = mysqli_fetch_array($result))
{
    $record2 = new stdClass();
    $record2->Amount = $row['Amount'];
    $record2->IFSC_CODE = $row['IFSC_CODE'];
    $record2->Payee_Acnt_Num = DecryptDetails($link, $row["Payee_Acnt_Num"]);
    $record2->Name_In_Account = $row['Name_In_Account'];
    $records2[] = $record2;
}

$currentDate = date('d/m/Y');
$currentDate1 = date('Ymd');
// echo $currentDate;

$heading = "CSV";

try {
    echo $blade->run("csv_generate"
    , ['heading' => $heading
    ,  'records' => $records
    ,  'event_count' => $event_count
    ,  'rec_count' => $rec_count
    ,  'total_amount' => $total_amount
    ,  'records1' => $records1
    ,  'records2' => $records2
    ,  'currentDate' => $currentDate
    ,  'currentDate1' => $currentDate1
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}