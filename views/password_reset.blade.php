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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css">

    
    <!-- Javascript files -->
    <script src="assets/js/validation.js"></script>
</head>
<body>
    
<div class="container">
    <div class="row">
        <h3>{{ $heading }}</h3>
        
    </div>
    
    <form class = "form-horizontal" method="POST" id="password_reset_form">
        <div class="col-md-10 mx-auto">
            
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label">BSPD Member ID</label>
                    <input class="form-control getmemberids" type="text" id="membersearch" name="memberid" list="memberids" placeholder="Enter ID or name to search" required/>
                    <datalist id="memberids"></datalist>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input type="text" id="name" readonly style="border:0;">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input type="submit" name="submit" id="submit" value="Reset Password" class = "btn btn-success"> <div id = "result"></div>
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>