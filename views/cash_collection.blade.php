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
        th {
            font-size: 18px;
            white-space: nowrap;
        }
    </style>
    
</head>
<body>
    
<div class="container">
    <div class="row">
        <h3>{{ $heading }}</h3>
        <!-- <div id = "result"></div> -->
    </div>
    @if($_SESSION['permission'] & CASH_DESK_ADD || $_SESSION['permission'] & CASH_DESK_ADMIN)
    <input type="hidden" id="curr_event_id" value="{{ $curr_event_id }}">
    <input type="hidden" id="entity_id" value="{{ $entity_id }}">
    <form class = "form-horizontal" method="POST" id="cash_collection_form">
        <div class="col-md-10 mx-auto">
            <div class="form-group row">
                <div class="col-sm-2">
                    <label class = "label-control">SNo</label>
                    <input type = "text" disabled class = "form-control" name = "sno" id = "sno" value="New">
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Contributor MID</label>
                    <input type="text" class = "form-control" name = "member" id = "member">
                </div>
                <div class="col-sm-3" style="display:none;">
                    <label class = "label-control">Event</label>
                    <select class = "form-control" name = "event_id" id = "event_id" required>
                        @foreach ($events as $event)
                            <option value = "{{ $event->id }}" data-entity_id="{{ $event->entity_id }}">{{ $event->entity_id }} {{ $event->id }} - {{ $event->description }}</option>   
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Amount</label>
                    <input type = "number" class = "form-control" name = "amount" id = "amount" max="6000" placeholder="">
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Note</label>
                    <textarea class = "form-control" name = "note" id = "note" placeholder="" rows="1"></textarea>
                </div>
                <div class="col-sm-1">
                    <label class = "label-control">Action</label>
                    <input type="submit" name="submit" id="cashsubmit" value="Save" class = "btn btn-success">
                </div>
            </div>
        </div>
    </form>
    @endif

    
    
    <div class="col-md-10 mx-auto">
    <div class="form-group row">
            <div class="col-sm-6" style="font-size:20px;">
                <b>Total : <input type="text" size="3" value="{{ $sum }}" id="amount_total" style="border:0;" disabled></b>
            </div>
    </div>
        <div class="form-group row">
            <div class="col-sm-2">
                <label class = "label-control">Starting row</label>
                <input type = "number" class = "form-control" name = "amount" id = "start" placeholder="">
            </div>
            <div class="col-sm-2">
                <label class = "label-control">Ending row</label>
                <input type = "number" class = "form-control" name = "amount" id = "end" placeholder="">
            </div>
            <div class="col-sm-2">
                <label class = "label-control">Action</label>
                <button class="btn btn-success" id="calc_total">Calculate Total</button>
            </div>
            <div class="col-sm-1">
                <label class = "label-control">Amount</label>
                <span id="sum"></span>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                    <label class = "label-control">Shift From</label>
                    <input type = "number" class = "form-control" name = "amount" id = "shift_from" placeholder="">
            </div>
            <div class="col-sm-2">
                    <label class = "label-control">Shift To</label>
                    <input type = "number" class = "form-control" name = "amount" id = "shift_to" placeholder="">
            </div>
            <div class="col-sm-2">
                <label class = "label-control">Action</label>
                <button class="btn btn-success" id="shift_contribution">Shift</button>
            </div>
        </div>
        
        <form class = "form-horizontal" method="POST" id="contribution_edit_form">
            <div class="form-group row">
                <div class="col-sm-6">
                    
                </div>
            </div>
            <table class="table table-bordered table-condensed table-responsive" >
                <tr>
                    <th>Amount </th>
                    <th>
                        @if($_SESSION['permission'] & CASH_DESK_ADD || $_SESSION['permission'] & CASH_DESK_ADMIN)
                        <button id="editmembercontribution" class = "btn btn-success">Edit</button>
                        @endif
                        @if($_SESSION['permission'] & PERM_CRUD)
                        <button id="deletemembercontribution" class = "btn btn-danger">Delete</button>
                        @endif
                    </th>
                    <th>Contributor</th>
                    <th>Event SNo </th>
                    <!-- <th>ID </th> -->
                    <!-- <th>Collector Name </th> -->
                    
                    <!-- <th>Event </th> -->
                    
                    <th>Notes</th>
                </tr>
                @foreach($members as $member)
                <tr>
                    <td><input type="text" value="{{ $member->amount }}" style="border:0;" size="3" disabled id="amount{{ $member->sno }}"></td>
                    @if($_SESSION['permission'] & CASH_DESK_ADD || $_SESSION['permission'] & CASH_DESK_ADMIN)
                    <td><input type="radio" name="membersno" value="{{ $member->sno }}"></td>
                    @endif
                    <td><input type="text" value="{{ $member->conname }}" style="border:0;" disabled size=15 id="memberconname{{ $member->sno }}"></td>
                    <input type="hidden" value="{{ $member->sno }}" style="border:0;" size="3" disabled id="sno{{ $member->sno }}">
                    <td><input type="text" value="{{ $member->SrNo_EVent }}" size="3" style="border:0;" disabled id="membersrnoevent{{ $member->SrNo_EVent }}"></td>
                    <input type="hidden" value="{{ $member->id }}" style="border:0;" size="3" disabled id="memberid{{ $member->sno }}">
                    <!-- <td><input type="text" value="{{ $member->colname }}" style="border:0;" disabled id="membercolname{{ $member->sno }}"></td> -->
                    <input type="hidden" value="{{ $member->event }}" style="border:0;" size="3" disabled id="event_id{{ $member->sno }}">
                    <input type="hidden" value="{{ $member->amount }}" style="border:0;" size="3" disabled id="seqno{{ $cont_count }}">
                    <td><input type="text" value="{{ $member->notes }}" style="border:0;" size="3" disabled id="note{{ $member->sno }}"></td>
                <?php $cont_count--; ?>    
                </tr>
                @endforeach
            </table>

        </form>

        

        <div class="form-group row">
            <div class="col-sm-3">
                <h4><b>cash box breakup</b></h4>
                <table class="table table-condensed table-bordered">
                    <?php $i = 0; ?>
                    @foreach($names as $name)
                        <tr>
                            <td>{{ $name }}</td>
                            <input type="hidden" value="{{ substr($name, 1, strlen($name)) }}" id="deno{{ $i }}">
                            <td><input type = "text" id="count{{ $i }}" size="3" value = "{{ $denominations[$i] }}"></td>
                            <td><input type = "text" id="amount{{ $i }}" size="3" disabled></td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                    <input type="hidden" id="denocount" value="{{$i}}">
                </table>
            </div>
        </div>
        <div class="form-group row">
        <div class="col-sm-2">
            <button align="right" type="button" class="btn btn-success" id="calc_denom">Calculate</button>
        </div>
        <div class="col-sm-6">
            <span id="denototal" style="font-size:20px;"></span>
        </div>
        </div>

        @include('member_search')

        @if($_SESSION['permission'] & PERM_CRUD)
        <div class="form-group row">
            <div class="col-sm-6">
                <button align="right" type="button" class="btn btn-success" id="preview">Preview Cash records for upload</button>
            </div>
            <div class="col-sm-6">
                <button align="right" type="button" class="btn btn-success" id="cash_record_generate">Update cash contribution to database</button>
            </div>
        </div>
        @endif
        

    </div>

</div>
    
</body>
</html>