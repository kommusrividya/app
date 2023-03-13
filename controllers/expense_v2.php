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

$sql = "SELECT * FROM SBOX_Expenses where EVENT_ID = 'CH0063';";
$result = mysqli_query($link_test, $sql);
$expenses = array();

while($row = mysqli_fetch_array($result))
{
    $expense = new stdClass();
    $expense->EVENT_ID = $row['EVENT_ID'];
    $expense->Voucher_Num = $row['Voucher_Num'];
    $expense->PAYEE_ID = $row['PAYEE_ID'];
    $expense->Amount = $row['Amount'];
    $expense->Category_ID = $row['Category_ID'];
    $expense->Subcategory_ID = $row['Subcategory_ID'];
    $expense->Amount_Details = $row['Amount_Details'];
    $expense->Expense_Type = $row['Expense_Type'];
    $expense->Bank_Registration_Code = $row['Bank_Registration_Code'];
    $expenses[] = $expense;
}

/*while($row = mysqli_fetch_array($result))
{
    $row['EVENT_ID'] = 'CH0074';
    $sql1 = "INSERT INTO Temp_SBOX_Expenses_Import (
    EVENT_ID,
    Voucher_Num,
    PAYEE_ID,
    Amount,
    Category_ID,
    Subcategory_ID,
    Amount_Details,
    Expense_Type,
    Bank_Registration_Code) values('".$row['EVENT_ID']."',"
                                    .$row['Voucher_Num'].","
                                    .$row['PAYEE_ID'].","
                                    .$row['Amount'].",'"
                                    .$row['Category_ID']."','"
                                    .$row['Subcategory_ID']."','"
                                    .$row['Amount_Details']."','"
                                    .$row['Expense_Type']."','"
                                    .$row['Bank_Registration_Code']."');";

    $result1 = mysqli_query($link_test, $sql1);
    if($result1) echo "Inserted successfully.";
    else echo "ERROR: ".mysqli_error($link_test);
}
die();*/

$heading = "Expense";

try {
    echo $blade->run("expense_v2"
    , ["expenses" => $expenses
]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}

