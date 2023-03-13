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
        <h3 class="">{{ $heading }} till {{ $currentDate }}</h3>
        <div id = "result"></div>
    </div>

    <div class="col-md-10 mx-auto">
        <div>
            Opening Balance (A) : <input type="text" style="border:0;" id="openingBalance" readonly value="{{ $openingBalance['Amount'] }}" ><br>
            <table class="table table-bordered">
                <tr>
                    <td>
                        <table class="table">
                            <tr><td>Contributions (B)</td><td align="right"><input type="text" style="border:0;text-align: right;" id="contributions" readonly value="{{ number_format((float)$contributions['Amount'], 2, '.', '') }}"></td></tr>
                            <tr><td>Kind Contribution</td><td align="right"><input type="text" style="border:0;text-align: right;" id="kind_contribution" readonly value="{{ number_format((float)$kind_contribution['Amount'], 2, '.', '') }}"></td></tr>
                            <tr><td>SIB Interest (E)</td><td align="right"><input type="text" style="border:0;text-align: right;" id="sib_interest" readonly value="{{ number_format((float)$sib_interest['Amount'], 2, '.', '') }}"></td></tr>
                            <tr><td>Kind (Pending upload) (C)</td><td align="right"><input type="text" style="border:0;text-align: right;" id="kind_discrepency" readonly value="{{ number_format((float)$kind_expenses['Amount']-$kind_contribution['Amount'], 2, '.', '')  }}"></td></tr>
                            <tr><td>Contributions not yet uploaded(D)</td><td align="right"><input type = "text" name = "contribution_not_uploaded" style="text-align: right;" value="0" id = "contribution_not_uploaded" required></td></tr>
                        </table>
                    </td>
                    <td>
                    <table class="table">
                        <tr><td>FDs (a)</td><td align="right"><input type="text" style="border:0;text-align: right;" id="corpusFund" readonly value="{{ number_format((float)$corpusFund['Amount'], 2, '.', '') }}"></td></tr>
                        <tr><td>Kind Expenses</td><td align="right"><input type="text" style="border:0;text-align: right;" id="kind_expenses" readonly value="{{ number_format((float)$kind_expenses['Amount'], 2, '.', '') }}"> </td></tr>        
                        <tr><td>Bank Charges (b)</td><td align="right"><input type="text" style="border:0;text-align: right;" id="bank_charges" readonly value="{{ number_format((float)$bank_charges['Amount'], 2, '.', '') }}"> </td></tr>
                        <tr><td>Expenses Paid (c)</td><td align="right"><input type="text" style="border:0;text-align: right;" id="expenses_paid" readonly value="{{ number_format((float)$expenses_paid['Amount'], 2, '.', '') }}"> </td></tr>
                    </table>
                    </td>
                </tr>
            </table>
        </div>
        <form class = "form-horizontal" method="POST" id="fin_sum_form">
            <div class="form-group row">
                <div class="col-sm-4">
                    <label class = "label-control">Bank Balance</label>
                    <input type = "text" class = "form-control" name = "bank_balance" id = "bank_balance" value="0" required>
                </div>
                <div class="col-sm-4">
                    <label class = "label-control">Expected Bank Balance</label>
                    <input type = "number" class = "form-control" name = "e_bank_balance" id = "e_bank_balance" readonly>
                </div>
                <div class="col-sm-4">
                    <label class = "label-control">Discripency</label>
                    <input type = "number" class = "form-control" name = "display" id = "display" readonly>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                <input type="submit" name="submit" id="submit" value="Check" class = "btn btn-success">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    Reserves as on 1 Apr 2022 : <input type = "number" style="border:0;" value="{{ number_format((float)$lastYearReserves['Amount'], 2, '.', '') }}" name = "reserves" id = "reserves" readonly>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    Pending Payments : <input type = "number" style="border:0;" value="{{ number_format((float)$pendingPayments['Amount'], 2, '.', '') }}" name = "pending_payments" id = "pending_payments" readonly>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    Amount for future expenditure : <input type = "number" style="border:0;" name = "future_exp" id = "future_exp" readonly>
                </div>
            </div>
        </form>
    </div>        
</div>
</body>
</html>