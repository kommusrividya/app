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
    @media print {
        .noprint {
           visibility: hidden;
        }
     }
 </style>
</head>
<body>

<div class="container">
    <!--<span class="noprint">
    Event: <select id="select_event_id" aria-placeholder="Select Event ID"><option>CH0060</option></select>
    </span>-->
    <?php $i=1;?>
@foreach ($vouchers as $voucher)
<div>

<table class="table table-bordered" style="border-style: solid;
border-width: 5px;">
    <tr>
        <th style="font-size:18pt;" colspan="4" class="text-center">BSPD(Trust)</th>
        <th style="font-size:10pt;" colspan="2" class="text-center">Date</th>
        <th style="font-size:10pt;" colspan="2" class="text-center">Voucher No.</th>
        <th style="font-size:9pt;" colspan="2" class="text-center">Cheque No.<br> Cash Neft No.</th>
    </tr>
    <tr>
        <td colspan="4" class="text-center">
            Apt # 304, Block # 2,  Alpine Heights Apartments,<br>
            Rajbhavan Road, Somajiguda, Hyderabad 500082<br>
            www.bspd.in    
        </td>
        <td colspan="2" class="text-center"><span id="date">{{ $voucher->date }}</span></td>
        <td colspan="2" class="text-center"><span id="event_id">{{ $voucher->eventid }}</span><br><span id="vno">{{ $voucher->vno }}</span></td>
        <td colspan="2" class="text-center"><span id="expense_type">{{ $voucher->expense_type }}</span></td>
    </tr>
    <tr>
        <td colspan="10">Payee ID: <span id="payee_id">{{ $voucher->payee_id }}</span> Member ID: <span id="name">{{ $voucher->name }}</span> Ph: <span id="phno">{{ $voucher->phno }}</span></td>
    </tr>	
    <tr>
        <td colspan="10">Amount in words: <span id="amt_in_words">{{ $voucher->Amt_In_Words }}</span> only</td>
    </tr>
        
    <tr>
        <td colspan="10">Towards: <span id="towards">{{ $voucher->towards }}</span></td>
    </tr>
    <tr>
        <th colspan="6" class="text-center">Particulars</th>
        <th colspan="2" class="text-center">Bill/Invoice</th>
        <th colspan="2" class="text-center">Amount Rs.</th>
    </tr>
    <tr>
        <td colspan="6">
            <span id="category">{{ $voucher->category }}</span> → <span id="sub_category">{{ $voucher->sub_category }}</span><br>
            Name in Account: <span id="nameinact">{{ $voucher->nameinact }}</span><br>
            IFSC: <span id="ifsc">{{ $voucher->ifsc }}</span> Acc no: <span id="accnt_num">{{ $voucher->accnt_num }}</span>
        </td>
        <td colspan="2" class="text-center"><span id="bill">{{ $voucher->bill }}</span></td>
        <td colspan="2" class="text-center"><span id="amount">{{ $voucher->amount }}</span></td>  
    </tr>
    <tr style="color:#FFFFFF;">
        <td colspan="2" class="text-center"><span class="noprint">X</span></td>
        <td colspan="2" class="text-center"><span class="noprint">X</span></td>
        <td colspan="2" class="text-center"><span class="noprint">X</span></td>
        <td colspan="4" class="text-center"><span class="noprint">X</span></td>
    </tr>
    <tr>
        <th colspan="2" class="text-center">Prepared by</td>
        <th colspan="2" class="text-center">Checked by</td>
        <th colspan="2" class="text-center">Approved by</td>
        <th colspan="4" class="text-center">Receiver's Signature</td>
    </tr>
</table>
</div>


<div style="page-break-after: always;"></div> 
<?php $i=$i+1; ?>
@endforeach
</div>

</body>
</html>