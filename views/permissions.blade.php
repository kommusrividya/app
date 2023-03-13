@include('header')
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
    
    <!-- Javascript files-->
    <!-- <script src="../assets/js/validation.js"></script> -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css">      
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    
<div class="container">
    <div class="row">
        <h3 class="">{{ $heading }}</h3>
        <div id = "result"></div>
    </div>
    <form class = "form-horizontal" method="POST" id="get_permissions">
        <div class="col-md-10 mx-auto">
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">Member ID</label>
                    <input type="text" class="form-control" id = "membersearch" required placeholder="Enter ID or name to search" list="memberids">
                    <datalist id="memberids"></datalist>
                </div>
                <div class="col-sm-3">
                    <br><!--<input type="submit" class = "btn btn-success" value="Get Permissions">-->
                    <button class="btn btn-success" id="bring_permissions" name="bring_permissions">Get Permissions</button>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                <input type="text" id="name" style="border:none;" readonly>
                </div>
            </div>

        </form>
            <form class = "form-horizontal" method="POST" id="permissions_form">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <input type="reset" class = "btn btn-danger" value="Remove all Permissions">
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission0" value="{{ PAYEE_CRUD }}"> 
                    <label class="form-check-label" for="permission0">PAYEE_CRUD</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission1" value="{{ EXPENSE_CRU }}">
                    <label class="form-check-label" for="permission1">EXPENSE_CRU</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission2" value="{{ EXPENSE_D }}">
                    <label class="form-check-label" for="permission2">EXPENSE_D</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission3" value="{{ PERM_CRUD }}">
                    <label class="form-check-label" for="permission3">PERM_CRUD</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission4" value="{{ PERM_CRUD_ADMIN }}">
                    <label class="form-check-label" for="permission4">PERM_CRUD_ADMIN</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission5" value="{{ MEMBER_C }}">
                    <label class="form-check-label" for="permission5">MEMBER_C</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission6" value="{{ MEMBER_U_ANY }}">
                    <label class="form-check-label" for="permission6">MEMBER_U_ANY</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission7" value="{{ MEMBER_U_ADMIN }}">
                    <label class="form-check-label" for="permission7">MEMBER_U_ADMIN</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission8" value="{{ MEMBER_D }}">
                    <label class="form-check-label" for="permission8">MEMBER_D</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission9" value="{{ ATTEND_CRUD }}">
                    <label class="form-check-label" for="permission9">ATTEND_CRUD</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission10" value="{{ ATTEND_C_ANY }}">
                    <label class="form-check-label" for="permission10">ATTEND_C_ANY</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission11" value="{{ RECOGN_CRUD }}">
                    <label class="form-check-label" for="permission11">RECOGN_CRUD</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission12" value="{{ RECOGN_C }}">
                    <label class="form-check-label" for="permission12">RECOGN_C</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission13" value="{{ NBV_CRUD_SELF }}">
                    <label class="form-check-label" for="permission13">NBV_CRUD_SELF</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission14" value="{{ NBV_CRUD_ANY }}">
                    <label class="form-check-label" for="permission14">NBV_CRUD_ANY</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission15" value="{{ CONTRIBUTION_REPORTS_ADMIN }}">
                    <label class="form-check-label" for="permission15">CONTRIBUTION_REPORTS_ADMIN</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission16" value="{{ JP_REGN }}">
                    <label class="form-check-label" for="permission16">JP_REGN</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission17" value="{{ JP_REGN_ANY }}">
                    <label class="form-check-label" for="permission17">JP_REGN_ANY</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission18" value="{{ JP_REPORTS }}">
                    <label class="form-check-label" for="permission18">JP_REPORTS</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission19" value="{{ EVENT_CRUD }}">
                    <label class="form-check-label" for="permission19">EVENT_CRUD</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission20" value="{{ T100 }}">
                    <label class="form-check-label" for="permission20">T100</label>
                </div>    
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission21" value="{{ CASH_DESK_ADD }}">
                    <label class="form-check-label" for="permission21">CASH_DESK_ADD</label>
                </div>   
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission22" value="{{ CASH_DESK_ADMIN }}">
                    <label class="form-check-label" for="permission22">CASH_DESK_ADMIN</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission23" value="{{ CSV_GENERATE }}">
                    <label class="form-check-label" for="permission23">CSV_GENERATE</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permission" id="permission24" value="{{ EVENT_REPORT_ADMIN }}">
                    <label class="form-check-label" for="permission24">EVENT_REPORT_ADMIN</label>
                </div>
                <input type="submit" id="submit" class = "btn btn-success" value="Update Permissions"> <br>
            </form>
        </div>
</div>