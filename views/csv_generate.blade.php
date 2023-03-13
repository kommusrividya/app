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
        <h3>CSV for Payee Registration at South Indian Bank</h3>
    </div>
    <div>
        FILEHDR|BSPDBSPD|245<br>
        @foreach ($records as $record)
            {{ $record->T1 }},{{ $record->T2 }},{{$record->T3}},{{$record->Name_In_Account}},{{$record->Nick_Name}},{{$record->T6}},{{$record->Payee_Acnt_Num}},{{$record->T8}},{{$record->T9}},{{$record->T10}},{{$record->T11}},{{$record->T12}},{{$record->T13}},{{$record->T14}},{{$record->T15}},{{$record->IFSC_CODE}}<br>
        @endforeach
    </div>
    <div class="row">
        <h3>Bulk Payment Upload CSV</h3>
    </div>
    <div>
        <h4>Event count: {{ $event_count }} Record count: {{ $rec_count }} Total Amount: {{ $total_amount }}</h4>
        FILEHDR|BSPDBSPD|120<br>
        @foreach ($records1 as $record)
            {{ $record->Dum1 }},{{ $record->reg_code }},{{$record->Dum2}},{{$record->Amount}},{{$record->Name}}<br>
        @endforeach
    </div>
    <div>
        <h3>Bulk Payment Upload Bank Branch CSV</h3>
    </div>
    <div id="txt">
        DEBIT A/C NO#DATE#AMOUNT#IFSC# BENEFICIARY A/C NUM#BENEFICIARY A/C NAME#PLACE#EMAIL##<br>
        <!-- 0722073000000061#29/09/2020#1100#SBIN0002724#30065662423#Govinda Kulkarni#Hyderabad#Hyderabad#1##bspd.hyd@gmail.com## -->
        <?php
        $i = 1;
        ?>
        @foreach ($records2 as $record)
            0722073000000061#{{ $currentDate }}#{{ $record->Amount }}#{{$record->IFSC_CODE}}#{{ $record->Payee_Acnt_Num }}#{{ $record->Name_In_Account }}#Hyderabad#Hyderabad#{{$i}}##bspd.hyd@gmail.com##<br>
        <?php $i++; ?>
        @endforeach
    </div>
    <a href="" id="link" download="{{$currentDate1}} Branch Bulk NEFT.csv">Download </a>
    <div class="form-group row">
        <div class="col-sm-6">
        <button class="btn" style="background-color: #812626; color:#FFFFFF;" id="in_process">Mark as in process</button>
        @if($_SESSION['permission'] & PERM_CRUD)
        <button class="btn" style="background-color: #812626; color:#FFFFFF;" id="reverse_in_process">Reverse last batch to pay status</button>
        @endif
        </div>
    </div>
    <div class="row">
        <h3>CSV for Receipt generation</h3>
    </div>
    <div>  
    <form id = "csv_receipt_generation_form">
        From date: <input type = "date" id = "from_date">
        To date: <input type = "date" id = "to_date">
        <input type = "submit" id = "submit">
    </form>
    </div>
    <div id = "result"></div>
    
</div>
<script>
     window.onload = function() 
	  {
	  var txt = document.getElementById('txt');
      document.getElementById('link').onclick = function(code) 
		{
      this.href = 'data:text/plain;charset=utf-11,' + encodeURIComponent(txt.innerText);
        };
      };
 
    main();
</script>

</body>
</html>