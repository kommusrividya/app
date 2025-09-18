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
    
</head>
<body>
    
<div class="container">
    <div class="row">
        <h3>{{ $heading }}</h3>
        <div id = "result"></div>
    </div>
    
        <div class="col-md-10 mx-auto">
        @if( $bank_records == "0")
            No unreconciled bank credits.
        @else
            <table class="table table-bordered table-condensed table-responsive" >
                <tr>
                    <th>VAN</th>
                    <th>UTR</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                @foreach($bank_records as $bank_record)
                <tr>
                    <td>{{ $bank_record->id }}</td>
                    <td>{{ $bank_record->utr }}</td>
                    <td>{{ $bank_record->date }}</td>
                    <td>{{ $bank_record->amount }}</td>
                </tr>
                @endforeach
            </table>
        @endif
        <form class = "form-horizontal" method="POST" id="reconciliation_form">
        <table class="table table-bordered table-condensed table-responsive" >
            <tr>
                <th>Collector Name</th>
                <th>UTR </th>
                <th>Tot Amt </th>
                <th>
                    <button class="btn btn-success" id="utrsave">Save</button>
                    <button class="btn btn-danger" id="utrdelete">Unlink</button>
                    @if($_SESSION['permission'] & CASH_DESK_ADMIN)
                    <button class="btn btn-success" id="generatereceipt">Generate Receipt</button>
                    @endif
                </th>
            </tr>
            @foreach($recrecords as $recrecord)
            <tr>
                <td>{{ $recrecord->colname }}</td>
                <td><input type="text" value="{{ $recrecord->utr }}" id="utr{{ $recrecord->utr }}"></td>
                <td>{{ $recrecord->amount }}</td>
                <td><input type="radio" name="utr" value="{{ $recrecord->utr }}"></td>
            </tr>
            @endforeach
        </table>
        </form>
        <form class = "form-horizontal" method="POST" id="link_utr_form">
        <table class="table table-bordered table-condensed table-responsive" >
            <tr>
                <th>SNo </th>
                @if($_SESSION['permission'] & CASH_DESK_ADMIN)
                <th>Collector Name </th>
                @endif
                <th>Contributor Name </th>
                <th>UTR </th>
                <th>Event </th>
                <th>Amount </th>
                <th>Notes</th>
                <th>Status</th>
                <th> </th>
            </tr>
            @foreach($members as $member)
            <?php $color = ""; if($member->status == 'reconciled') $color = "style='color:grey;'"; else $color = "style='color:blue;'";?>
            <tr <?= $color ?>>
                <td><input type="text" value="{{ $member->sno }}" style="border:0;" size="3" disabled id="sno{{ $member->sno }}"></td>
                <input type="hidden" value="{{ $member->id }}" style="border:0;" size="3" disabled id="memberid{{ $member->sno }}">
                @if($_SESSION['permission'] & CASH_DESK_ADMIN)
                <td><input type="text" value="{{ $member->colname }}" style="border:0;" disabled id="membercolname{{ $member->sno }}"></td>
                @endif
                <td><input type="text" value="{{ $member->conname }}" style="border:0;" disabled id="memberconname{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->utr }}" style="border:0;" disabled id="utr{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->event }}" style="border:0;" size="3" disabled id="event_id{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->amount }}" style="border:0;" size="3" disabled id="amount{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->notes }}" style="border:0;" size="3" disabled id="note{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->status }}" style="border:0;" size="9" disabled id="status{{ $member->sno }}"></td>
                
                <?php
                    $flag="";
                    if( $member->status != 'entered') $flag = "disabled";
                ?>
                <td><input type="checkbox" name="membersno" value="{{ $member->sno }}" {{ $flag }}></td>
            </tr>
            @endforeach
        </table>
        <div class="form-group row">
            <div class="col-sm-3">
                <label class = "label-control">UTR</label>
                <input type = "text" class = "form-control" name = "utr" id = "utr" required>    
            </div>
            <div class="col-sm-3">
                <br>
                <input type="submit" class="btn btn-success" id="submit" value="Link UTR">
            </div>
            
        </div>

        </form>
        <div class="form-group row">
            <div class="col-sm-2">
                <button align="right" type="button" class="btn btn-success" onclick="location.href = 'MACD';">Back to contribution page</button>
            </div>
        </div>

    </div>

</div>
    
</body>
</html>