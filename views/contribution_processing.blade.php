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
        <h4>For processing later, select event ID "PROCESS LATER".</h4><br>
        <h4>If it is not valid contribution, select event ID "CANCEL".</h4>
    </div>
    <div>
        <form class = "form-horizontal" action="" method="POST" id="contribution_processing_form">
        <table class="table table-bordered">
            <tr>
            <th> </th>
            <th>MID</th>
            <th>Event</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Date</th>
            <th>Reference Details</th>
            <th>Approved</th>
            <th>Created By</th>
            </tr>
            <?php $i = 0; ?>
            @foreach ($records as $record)
                <tr>
                    <td style="background-color:grey;">{{$record->SrNo}}</td>
                    <input type = "hidden" id="SrNo{{$i}}" value="{{$record->SrNo}}">
                    <td>{{ $record->Member_id }}</td>
                    <td>
                        <select id="event{{$i}}">
                            <option value = "{{ $record->event }}" data-entity_id="{{ $record->entity_id }}">{{ $record->entity_id }} {{ $record->event }}</option>
                            <option value = "CANCEL" data-entity_id="">CANCEL</option>
                            <option value = "PROCESS LATER" data-entity_id="">PROCESS LATER</option>
                            @foreach ($events as $event)
                                <option value = "{{ $event->id }}" data-entity_id="{{ $event->entity_id }}">{{ $record->entity_id }} {{ $event->id }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>{{ $record->Amount }}</td>
                    <td>{{ $record->Contribution_Type }}</td>
                    <td>{{ $record->Contribution_Date }}</td>
                    <td>{{ $record->Reference_Details }}</td>
                    <td>{{ $record->Approved }}</td>
                    <td>{{ $record->CreatedBy }}</td>             
                </tr>
                <?php
                    $i++;
                ?>
            @endforeach
            <input type = "hidden" value = "{{ $i }}" id="count">
        </table><br>
        <div class="form-group row">
            <div class="col-sm-6">
                <input type="submit" name="submit" id="submit" value="Submit" class = "btn btn-success">
            </div>
        </div>
    </form>
        <div>
            <a class="btn btn-success" href="financialsummary">Bank Reconciliation</a>
        </div>
    </div>
</div>

</body>
</html>

<?php
/*$manual_verify_flag = "";
if(
    (str_contains($record->event, 'BVMA') && $record->Amount!=365) ||
    (str_contains($record->event, 'BVCD') && $record->Amount==365) ||
    (str_contains($record->event, 'BV') && ($record->Amount%365)!=0) ||
    (!(str_contains($record->event, 'BV')) && ($record->Amount%365)==0) ||
    ($record->Amount > 5000)
    ) $manual_verify_flag = "class='table-danger'";*/
?>
 <?php /*echo $manual_verify_flag;*/ ?>