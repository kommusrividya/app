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

    <!-- Jquery files
    <script src="assets/js/jquery.min.js"></script> -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body>

    <div class="container">
                <table class = "table table-borderless" style="color:red; background-color:yellow; font-size:30px;">
                    <tr>
                        <td><img src="http://www.bspd.in/app/kamakshiimage.jpg" width="162" height="162" class="css-class" alt="alt text"></td>
                        <td align="center"><b>BSPD<br><span style="font-size:20px;">MEMBER ID: {{ $row['MEMBER_ID'] }}</span><br>@if($_SESSION['permission'] & T100) T100 @endif</b></td>
                        <td align = "right"><img src="http://www.bspd.in/app/swamiimage.jpg" width="162" height="162" class="css-class" alt="alt text"></td></tr>
                    <tr><td colspan="3" align = "center" style="font-size:20px;"><b>{{ $row['Surname'] }} {{ $row['Name'] }}
                        <br>Gotram : {{ $gotram }}
                        <br>Member since : {{ date('Y', strtotime($row['created'])) }}
                    </b></td></tr>
                    <tr><td colspan="3" align = "center"><b><span style="font-size:24px;">బ్రాహ్మణ సభ ( పంచ ద్రావిడ )</span></b></td></tr>
                </table>
    </div>
    
</body>

</html>
