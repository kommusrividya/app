<?php 
$APPDIR = dirname( dirname(__FILE__) );
require_once "$APPDIR/constant.php"; 
require_once "$APPDIR/ssdbconfig.php"?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{{ $heading }}</title>

    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <!--<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
          rel="stylesheet" type="text/css">-->
    <!-- FOR NAVBAR FONTS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- FOR NAVBAR DROPDOWN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css">

    
    <!-- Javascript files -->
    <script src="assets/js/validation.js"></script>

</head>
<body>
      <nav class="navbar fixed-top navbar-expand-md navbar-dark" style="background-color: #812626;">
        <div class="container-fluid">
          <a class="navbar-brand" href="home">BSPD Self Service</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="home">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Events
                </a>
                 <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  @if($_SESSION['permission'] & EVENT_CRUD)
                  <li><a class="dropdown-item" href="eventcreate">Creation</a></li>
                  <li><a class="dropdown-item" href="eventupdate">Updation</a></li>
                  @endif
                  <li><a class="dropdown-item" href="eventregister">Registration</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Reports and Views
                </a>
                 <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="event_report">Event Registration report</a></li>
                  <li><a class="dropdown-item" href="eventexpreport">Event reports</a></li>
                  <li><a class="dropdown-item" href="memberreport">Member report</a></li>
                  <li><a class="dropdown-item" href="pendingbills">Bills not submitted</a></li>
                  @if($_SESSION['permission'] & PERM_CRUD)
                  <li><a class="dropdown-item" href="financialsummary">Bank Reconciliation</a></li>
                  @endif
                </ul>
              </li>
              <!--<li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Update Screens
                </a>
                 <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="memberupdate">Member Update</a></li>
                  <li><a class="dropdown-item" href="changepassword">Change password</a></li>
                  <li><a class="dropdown-item" href="requestvan">VAN details</a></li>
                </ul>
              </li>-->
              <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Administrative Tasks
                </a>
                 <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  @if($_SESSION['permission'] & MEMBER_C) 
                  <li><a class="dropdown-item" href="membercreate">New Member</a></li>
                  @endif
                  @if($_SESSION['permission'] & ATTEND_C_ANY)
                  <li><a class="dropdown-item" href="eventattendance">Event attendance</a></li>
                  @endif
                  @if($_SESSION['permission'] & JP_REGN_ANY)
                  <li><a class="dropdown-item" href="jpregister">JP registration</a></li>
                  @endif
                  @if($_SESSION['permission'] & PERM_CRUD)
                  <li><a class="dropdown-item" href="email">Send Emails</a></li>
                  <li><a class="dropdown-item" href="bugreportedit">Issue Tracker</a></li>
                  @endif
                  @if($_SESSION['permission'] & EXPENSE_CRU) 
                  <li><a class="dropdown-item" href="expensecreate">Expense Create</a></li>
                  <li><a class="dropdown-item" href="expenseupdate">Expense Edit</a></li>
                  <li><a class="dropdown-item" href="voucherform">Event Vouchers</a></li>
                  <li><a class="dropdown-item" href="vbnames">Voucher Bill Names</a></li>
                  @endif
                  @if($_SESSION['permission'] & CSV_GENERATE)
                  <li><a class="dropdown-item" href="csvgenerate">CSV generator</a></li>
                  @endif
                  @if($_SESSION['permission'] & PERM_CRUD)
                  <li><a class="dropdown-item" href="permissions">Member Permissions</a></li>
                  <li><a class="dropdown-item" href="printid2">Bulk ID Print</a></li>
                  @endif
                  @if($_SESSION['permission'] & PAYEE_CRUD)
                  <li><a class="dropdown-item" href="payeecreate">Create Payee</a></li>
                  <li><a class="dropdown-item" href="payeeaccount">Create Payee Accnt</a></li>
                  @endif
                  @if($_SESSION['permission'] & CASH_DESK_ADMIN)
                  <li><a class="dropdown-item" href="MACD">Report Contribution</a></li>
                  <li><a class="dropdown-item" href="recognition">Recognition</a></li>
                  <li><a class="dropdown-item" href="bankstatementreview">Bank Statement Review</a></li>
                  <li><a class="dropdown-item" href="uploadstatement">Upload SIB Collection Report</a></li>
                  <li><a class="dropdown-item" href="challan">Cash Challan</a></li>  
                  <li><a class="dropdown-item" href="voucherlist">Voucher List</a></li>
                  @endif
                  
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="careers">BSPD Opportunities</a>
              </li>
            </ul>
            <div class="nav navbar-right" >
              <li class="nav-item dropdown">
                <a class="nav-link active navbar-btn dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#FFFFFF;">
                  <span class="glyphicon glyphicon-user"></span> {{ $_SESSION["name"] }}
                </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="idcard">ID Card</a></li>
                <li><a class="dropdown-item" href="memberupdate">Member Update</a></li>
                <li><a class="dropdown-item" href="changepassword">Change password</a></li>
                <li><a class="dropdown-item" href="requestvan">My VAN details</a></li>
                <li><a class="dropdown-item" href="vamsavruksham">My Vamsa Vruksham</a></li> 
                <li><a class="dropdown-item" href="controllers/ssLogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
              </li>
            </div>
          </div>
        </div>
      </nav>
      
</body>
</html>