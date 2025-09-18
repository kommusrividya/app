<?php 
$APPDIR = dirname( dirname(__FILE__) );
require_once "$APPDIR/constant.php"; 
require_once "$APPDIR/ssdbconfig.php"?>
@include('header')
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
    <style>
        table, th, td {
            white-space: nowrap;
            font-size: 18px;
            font-weight: bold;
            border: 1px solid;
            font-family: "Arial";
        }
    </style>  
    </style>
    
</head>
<body>
    
<div class="container">
    <div class="row">
        <h3>{{ $heading }}</h3>
        <div id = "result"></div>
    </div>
    <div class="form-group row">
            <div class="col-sm-2">
                <h4><b>cash box breakup</b></h4>
                <table>
                    <?php $i = 0; ?>
                    @foreach($names as $name)
                        <tr>
                            <td>&nbsp;{{ substr($name, 0, 1 ) }}&nbsp;</td>
                            <td align="right">&nbsp;{{ substr($name, 1, strlen($name)) }}&nbsp;</td>
                            <td align="right">&nbsp;{{ $denominations[$i] }}&nbsp;</td>
                            <td align="right">&nbsp;{{ $amount[$i] }}</td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                    <tr>
                        <td></td>
                        <td>Total</td>
                        <td></td>
                        <td align="right">{{ $total_amount }}</td>
                    </tr>
                </table>
                
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3">
                <b>{{ $word_format }}</b>
            </div>
        </div>
</div>
    
</body>
</html>