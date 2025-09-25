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


use eftec\bladeone\BladeOne;
use eftec\bladeone\BladeOneHtml;

$views = $APPDIR.'/views';
$compiledFolder = $APPDIR.'/compiled';
// CHANGE HERE TO CHANGE TO NEXT FINANCIAL YEAR
define ('FINANCIALYEAR', "'20240401' AND '20250331'") ;
define ('FINANCIALYEARSTART', '20240401') ;

class myBlade extends  BladeOne {
    use BladeOneHtml;
}

$blade=new myBlade($views,$compiledFolder);

$heading = "Financial Summary (FY 2024-25)";

// Reserves (X)
$sql = "SELECT Amount FROM bspdhyd_wp1.BSPD_Temp_SIB_OtherData where Date BETWEEN ".FINANCIALYEAR." and Type='Reserves';";
$result = mysqli_query($link, $sql);

$lastYearReserves = mysqli_fetch_array($result);

// Pending Payments
$sql = "SELECT Sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Expenses where Payment_Date BETWEEN ".FINANCIALYEAR." and Payment_Status='pending';";
$result = mysqli_query($link, $sql);

$pendingPayments = mysqli_fetch_array($result);

$sql = "SELECT Sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Expenses where TRN_DATE BETWEEN ".FINANCIALYEAR." and Payment_Status='provisioned';";
$result = mysqli_query($link, $sql);

$provisioned = mysqli_fetch_array($result);


// opening balance (A)
$sql = "SELECT Amount as Amount FROM bspdhyd_wp1.BSPD_Temp_SIB_OtherData where Date = ".FINANCIALYEARSTART." and AccType='SB' and Type='Balance';";
$result = mysqli_query($link, $sql);

$openingBalance = mysqli_fetch_array($result);

// FDs (a)
$sql = "SELECT sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Temp_SIB_OtherData where AccType = 'FD' and Type  = 'Balance' and Date between ".FINANCIALYEAR." and Maturity_Date > curdate() ;";
$result = mysqli_query($link, $sql);

$corpusFund = mysqli_fetch_array($result);

// Current Year Contributions (B) : excluding kind contributions
$sql = "SELECT Sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Member_Contribution where Contribution_Date BETWEEN ".FINANCIALYEAR." and Contribution_Type != 'KIND';";
$result = mysqli_query($link, $sql);

$contributions = mysqli_fetch_array($result);

// Kind Expenses (confirmed:Paid status)
$sql = "SELECT sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Expenses where Payment_Date BETWEEN ".FINANCIALYEAR." and Expense_Type='KIND' and payment_status='paid';";
$result = mysqli_query($link, $sql);

$kind_expenses = mysqli_fetch_array($result);

$sql = "SELECT EVENT_ID, sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Expenses where Payment_Date BETWEEN ".FINANCIALYEAR." and Expense_Type='KIND' and payment_status='paid' GROUP BY EVENT_ID;";
$result = mysqli_query($link, $sql);

$kind_expense_breakup = [];
while($row = mysqli_fetch_array($result)) {
    $kind_expense_breakup[] = $row;
}

$sql = "SELECT Sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Member_Contribution where Contribution_Date BETWEEN ".FINANCIALYEAR." and Contribution_Type='KIND';";
$result = mysqli_query($link, $sql);

$kind_contribution = mysqli_fetch_array($result);

$sql = "SELECT EVENT_ID, Sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Member_Contribution where Contribution_Date BETWEEN ".FINANCIALYEAR." and Contribution_Type='KIND' GROUP BY EVENT_ID;";
$result = mysqli_query($link, $sql);

$kind_contribution_breakup = [];
while($row = mysqli_fetch_array($result)) {
    $kind_contribution_breakup[] = $row;
}

$sql = "SELECT sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Temp_SIB_OtherData where Date BETWEEN ".FINANCIALYEAR." and Type='BankCharge';";
$result = mysqli_query($link, $sql);

$bank_charges = mysqli_fetch_array($result);

// SIB Interest

$sql = "SELECT sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Temp_SIB_OtherData where Type  = 'Interest' and Date between ".FINANCIALYEAR." ;";
$result = mysqli_query($link, $sql);

$sib_interest = mysqli_fetch_array($result);

// Expenses Paid (c) excluding kind expenses
$sql = "SELECT Sum(Amount) as Amount FROM bspdhyd_wp1.BSPD_Expenses where Payment_Date BETWEEN ".FINANCIALYEAR." and Expense_Type != 'KIND' and Payment_Status in ('paid','in_process');";
$result = mysqli_query($link, $sql);

$expenses_paid = mysqli_fetch_array($result);

$currentDate = date('d/m/Y h:i:s');



try {
    echo $blade->run("fy_financial_summary"
    , ['heading' => $heading
    ,  'openingBalance' => $openingBalance
    ,  'corpusFund' => $corpusFund
    ,  'contributions' => $contributions
    ,  'kind_expenses' => $kind_expenses
    ,  'kind_contribution' => $kind_contribution
    ,  'bank_charges' => $bank_charges
    ,  'expenses_paid' => $expenses_paid
    ,  'lastYearReserves' => $lastYearReserves
    ,  'pendingPayments' => $pendingPayments
    ,  'currentDate' => $currentDate
    ,  'sib_interest' => $sib_interest
    ,  'provisioned' => $provisioned
    ,  'kind_contribution_breakup' => $kind_contribution_breakup
    ,  'kind_expense_breakup' => $kind_expense_breakup

]);
} catch (Exception $e) {
    echo "error found ".$e->getMessage()."<br>".$e->getTraceAsString();
}