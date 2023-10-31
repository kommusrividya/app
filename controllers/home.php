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

$result = mysqli_query($link, "select * from BSPD_Member WHERE MEMBER_ID='".$_SESSION["id"]."'");
$row = mysqli_fetch_array($result);

$MEMBER_ID = $_SESSION['id'];
$First_Name = $row['Name'];
$Alias = $row["Alias"];
$Last_Name = $row['Surname'];
$Location = $row['Location'];
$Gender = $row['Gender'];
$email = $row['Email_ID'];
$Gotram = $row['Gotram'];
$Nakshatra = $row['Nakshatra'];
$Pada = $row['Pada'];
$Gotram_ID = $row['Gotram_ID'];
$Phone_Num = $row['Phone_Num'];
$Referrer_ID = $row['Referrer_ID'];
$MEMBER_TYPE = $row['MEMBER_TYPE'];
$Address1 = $row['Address1'];
$Address2 = $row['Address2'];
$city_name = $row['City'];
$PIN_or_ZIP = $row['PIN_or_ZIP'];
$State = $row['State'];
$Country = $row['Country'];
$Spouse_ID = $row['Spouse_ID'];
$Father_ID = $row['Father_ID'];
$Mother_ID = $row['Mother_ID'];
$BSPD_Member_ID = $row['BSPD_Member_ID'];
$Gender = $row['Gender'];

$sql = "SELECT Gotra FROM bspdhyd_wp1.BSPD_Pravara_Gotra where PG_ID = ".$row["Gotram_ID"].";";
$gotramquery = mysqli_query($link, $sql);
$gotramrow = mysqli_fetch_array($gotramquery);
$Gotram = $gotramrow["Gotra"];

$sql = "select Alias from BSPD_Member WHERE MEMBER_ID='$Referrer_ID'";
$query = mysqli_query($link, $sql);
if(mysqli_num_rows($query))
{
    $row = mysqli_fetch_array($query);
    $Referrer_name = $row['Alias']; //referrer name
}
else
    $Referrer_name = "NONE";

   if($Nakshatra){
   $sql = "SELECT All_S_English,All_S_Telugu FROM bspdhyd_wp1.BSPD_Nakshatra where NID = '$Nakshatra';";
   $result = mysqli_query($link,$sql);
   $row = mysqli_fetch_array($result);
   $Sankalpam = $row["All_S_English"]."/".$row["All_S_Telugu"].", Padam ".$Pada; //sankalpam 
    $raasi=0;
    $npada = (($Nakshatra-1)*4)+$Pada;
    if ($npada%9>0) $raasi = ceil($npada/9);
    else $raasi = $npada/9;
    
    $sql = "SELECT * FROM bspdhyd_wp1.BSPD_Raasi where Rasi_ID = $raasi;";
    $result = mysqli_query($link,$sql);
    $row = mysqli_fetch_array($result);
   
   $Raasi = "Raasi : ".$row["Raasi_S_English"]."/".$row["Raasi_S_Telugu"]; // raasi
   }
   else
   {
       $Sankalpam = "Please update Nakshatram, Padam and Gotram to get sankalpam details";
       $Raasi = " ";
   }

$ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    $_SESSION['ipaddress'] = $ipaddress;
        $heading = "BSPD Self Service";


$sql = "SELECT * FROM bspdhyd_wp1.BSPD_View_Payee_List where MEMBER_ID = ".$_SESSION['id'].";";
$query = mysqli_query($link, $sql);

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

if(mysqli_num_rows($query) > 0)
{
    $row = mysqli_fetch_array($query);
    $Name_In_Account = $row['Name_In_Account'];
    $value = $row['Payee_Acnt_Num'];
    $Payee_Acnt_Num = DecryptDetails($link, $value);
    $Bank_Name = $row['Bank_Name'];
    $ifsc_code = $row['IFSC_CODE'];
}
else {
    $Name_In_Account = "";
$Payee_Acnt_Num = "";
$Bank_Name = "";
$ifsc_code = "";
}

$sarma = "";
if($Gender == 'M') $sarma = "శర్మ";

$ruthuvu = ".....";
$month = date("m");
/*if($month == 1 || $month == 2) $ruthuvu = "వసంత";
if($month == 3 || $month == 4) $ruthuvu = "గ్రీష్మ";
if($month == 5 || $month == 6) $ruthuvu = "వర్ష";
if($month == 7 || $month == 8) $ruthuvu = "శరద్";
if($month == 9 || $month == 10) $ruthuvu = "హేమంత";
if($month == 11 || $month == 12) $ruthuvu = "శిశిర";*/

$sql = "SELECT  CreatedDate, EVENT_ID, Registered, Attended FROM BSPD_Event_Registration where MEMBER_ID = ".$_SESSION['id']." order by CreatedDate desc LIMIT 5;";
$query = mysqli_query($link, $sql);
$registration_details = array();
while( $row = mysqli_fetch_array($query) )
{
    $reg = new stdClass();
    $date = new DateTime($row['CreatedDate']);
    $reg->date = $date->format('d-m-Y');
    $reg->event = $row['EVENT_ID'];
    $reg->registered = $row['Registered'];
    $reg->attended = $row['Attended'];
    $registration_details[] = $reg; 
}

$ayanam = "";
$day = date("d");

if($month>=2 && $month<=5)
    $ayanam = "ఉత్తరాయనే";
else if($month == 1)
{
    if($day>=15) $ayanam = "ఉత్తరాయనే";
    else $ayanam = "దక్షిణాయనే";
}
else if($month == 6)
{
    if($day>=15) $ayanam = "దక్షిణాయనే";
    else $ayanam = "ఉత్తరాయనే";
}
else $ayanam = "దక్షిణాయనే";

    $sql = "SELECT count(distinct emp_uid) as count FROM bspd_tokens;";
    $query = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($query);
    $logins_count = $row['count'];

    $sql = "SELECT count(MEMBER_ID) as count FROM BSPD_Member where Status = 'Active';";
    $query = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($query);
    $member_count = $row['count'];

    $sql = "SELECT count(distinct emp_uid) as count FROM bspd_tokens where createdon > date_sub(now(),interval 30 day);";
    $query = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($query);
    $logins_count_30days = $row['count'];

    $sql = "SELECT count(distinct emp_uid) as count FROM bspd_tokens where createdon > date_sub(now(),interval 1 day);";
    $query = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($query);
    $logins_count_today = $row['count'];


try {
    echo $blade->run("home"
    , [ 'heading' => $heading
    ,   'MEMBER_ID' => $MEMBER_ID
    ,   'Location' => $Location
    ,   'Referrer_name' => $Referrer_name
    ,   'ipaddress' => $ipaddress
    ,   'email' => $email
    ,   'Sankalpam' => $Sankalpam
    ,   'Raasi' => $Raasi
    ,   'Alias' => $Alias
    ,   'Address1' => $Address1
    ,   'Address2' => $Address2
    ,   'city_name' => $city_name
    ,   'State' => $State
    ,   'Country' => $Country
    ,   'PIN_or_ZIP' => $PIN_or_ZIP
    ,   'Phone_Num' => $Phone_Num
    ,   'Gotram' => $Gotram
    ,   'Phone_Num' => $Phone_Num
    ,   'BSPD_Member_ID' => $BSPD_Member_ID 
    ,   'Name_In_Account' => $Name_In_Account
    ,   'Payee_Acnt_Num' => $Payee_Acnt_Num
    ,   'Bank_Name' => $Bank_Name
    ,   'ifsc_code' => $ifsc_code
    ,   'sarma' => $sarma 
    ,   'ruthuvu' => $ruthuvu
    ,   'ayanam' => $ayanam
    ,   'Name' => $First_Name
    ,   "registration_details" => $registration_details
    ,   'logins_count' => $logins_count
    ,   'member_count' => $member_count
    ,   'logins_count_30days' => $logins_count_30days
    ,   'logins_count_today' => $logins_count_today
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}
