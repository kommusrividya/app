<?php

define('ROOT_PATH', rtrim(dirname(__FILE__), "\\/"));
require_once(ROOT_PATH . '/router.php');

// ##################################################
// ##################################################
// ##################################################

// BEGIN HTTP Redirection - by Madhu Palepu
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}
//END HTTP Redirection



// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/app', 'controllers/login.php');
get('/app/login', 'controllers/login.php');

post('/app/controllers/jquery_process.php','controllers/jquery_process.php');
get('/app/assets/js/validation.js','assets/js/validation.js');
get('/app/controllers/ssLogout.php','controllers/ssLogout.php');
get('/app/controllers/bspd-panchang.php','controllers/bspd-panchang.php');
get('/app/dbtest.php','dbtest.php');

get('/app/changepassword','controllers/change_password.php');
get('/app/eventattendance','controllers/event_attendance.php');
get('/app/eventcreate','controllers/event_create.php');
get('/app/eventregister','controllers/event_register.php');
get('/app/eventupdate','controllers/event_update.php');
get('/app/expensecreate','controllers/expense_create.php');
get('/app/expenseupdate','controllers/expense_update.php');
get('/app/home', 'controllers/home.php');
get('/app/jpregister','controllers/jp_register.php');
get('/app/membercreate','controllers/member_create.php');
get('/app/memberupdate','controllers/member_update.php');
get('/app/requestvan','controllers/request_van.php');
get('/app/event_report','controllers/event_report.php');
get('/app/voucher','controllers/voucher.php');
get('/app/voucherform','controllers/voucherform.php');
get('/app/csvgenerate','controllers/csv_generate.php');
get('/app/bankstatementreview','controllers/statement_edit.php');
get('/app/contributionprocessing','controllers/contribution_processing.php');
get('/app/email','controllers/email_nbv_header.php');
get('/app/bugreportedit','controllers/bug_edit.php');
get('/app/receiptgenerate','controllers/receipt_generate.php');
get('/app/familyid','controllers/family_id_create.php');
get('/app/permissions','controllers/permissions.php');
get('/app/memberreport','controllers/member_report.php');
get('/app/eventexpreport','controllers/event_exp_report.php');
get('/app/passwordreset','controllers/password_reset.php');
get('/app/payeecreate','controllers/payee_create.php');
get('/app/payeeaccount','controllers/payee_account.php');
get('/app/MACD','controllers/cash_collection.php');
get('/app/reconciliation','controllers/reconciliation.php');
get('/app/expensev2','controllers/expense_v2.php');
get('/app/idcard','controllers/id_card.php');
get('/app/vbnames','controllers/voucherbill_names.php');
get('/app/printid2','controllers/print_id2.php');
get('/app/financialsummary', 'controllers/fy_financial_summary.php');
any('/app/uploadstatement', 'controllers/ssSIBCollectiondata.php');
get('/app/challan', 'controllers/cash_challan.php');
get('/app/voucherlist', 'controllers/voucherlist.php');
get('/app/vamsavruksham', 'controllers/vamsa_vruksham.php');
get('/app/recognition', 'controllers/recognition_probables.php');
get('/app/careers', 'controllers/careers.php');
get('/app/pendingbills', 'controllers/pending_bills.php');




//get('/test/about', 'views/about.php');
//get('/test/index', 'views/index.php');


// Dynamic GET. Example with 2 variables
// The $name will be available in user.php
// The $last_name will be available in user.php
//get('/user/$name/$last_name', 'user.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
//get('/product/$type/color/:color', 'product.php');

// Dynamic GET. Example with 1 variable and 1 query string
// In the URL -> http://localhost/item/car?price=10
// The $name will be available in items.php which is inside the views folder
//get('/item/$name', 'views/items.php');


// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
