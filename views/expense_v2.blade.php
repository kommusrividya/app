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
    <form class = "form-horizontal" method="POST" id="cash_collection_form">
        <div class="col-md-10 mx-auto">
            <div class="form-group row">
                <div class="col-sm-2">
                    <label class = "label-control">SNo</label>
                    <input type = "text" disabled class = "form-control" name = "sno" id = "sno" value="New" >
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Contributor MID</label>
                    <input type="text" class = "form-control" name = "member" id = "member">
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Event</label>
                    <select class = "form-control" name = "event_id" id = "event_id" required>
                        @foreach ($events as $event)
                            <option value = "{{ $event->id }}">{{ $event->id }} - {{ $event->description }}</option>   
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Amount</label>
                    <input type = "number" class = "form-control" name = "amount" id = "amount" max="5116" placeholder="">
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Note</label>
                    <textarea class = "form-control" name = "note" id = "note" placeholder="" rows="1"></textarea>
                </div>
                <div class="col-sm-1">
                    <label class = "label-control">Action</label>
                    <input type="submit" name="submit" id="submit" value="Save" class = "btn btn-success">
                </div>
            </div>
        </div>
    </form>
    <div class="col-md-10 mx-auto">
        <form class = "form-horizontal" method="POST" id="contribution_edit_form">
            <div class="form-group row">
                <div class="col-sm-6">
                    
                </div>
            </div>
        <table class="table table-bordered table-condensed" >
            <tr>
                <th>SNo </th>
                <th>ID </th>
                <th>Collector Name </th>
                <th>Contributor Name </th>
                <th>Event </th>
                <th>Amount </th>
                <th>Notes</th>
                @if($_SESSION['permission'] & CASH_DESK_ADD || $_SESSION['permission'] & CASH_DESK_ADMIN)
                <th><button id="editmembercontribution" class = "btn btn-success">Edit</button>
                    <button id="deletemembercontribution" class = "btn btn-danger">Delete</button>
                </th>
                @endif
            </tr>
            @foreach($members as $member)
            <tr>
                <td><input type="text" value="{{ $member->sno }}" style="border:0;" size="3" disabled id="sno{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->id }}" style="border:0;" size="3" disabled id="memberid{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->colname }}" style="border:0;" disabled id="membercolname{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->conname }}" style="border:0;" disabled id="memberconname{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->event }}" style="border:0;" size="3" disabled id="event_id{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->amount }}" style="border:0;" size="3" disabled id="amount{{ $member->sno }}"></td>
                <td><input type="text" value="{{ $member->notes }}" style="border:0;" size="3" disabled id="note{{ $member->sno }}"></td>
                @if($_SESSION['permission'] & CASH_DESK_ADD || $_SESSION['permission'] & CASH_DESK_ADMIN)
                <td><input type="radio" name="membersno" value="{{ $member->sno }}"></td>
                @endif
            </tr>
            @endforeach
        </table>

        </form>
        @if($_SESSION['permission'] & CASH_DESK_ADD || $_SESSION['permission'] & CASH_DESK_ADMIN)
        <div class="form-group row">
            <div class="col-sm-2">
                <button align="right" type="button" class="btn btn-success" onclick="location.href = 'reconciliation';">Go to reconciliation page</button>
            </div>
        </div>
        @endif
    </div>

</div>
    
</body>
</html>