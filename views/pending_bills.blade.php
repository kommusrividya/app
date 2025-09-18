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
        <h3 class="">{{ $heading }}</h3>
        <div id = "result"></div>
    </div>
    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>TRN ID</th>
                <th>Name</th>
                <th>Event ID</th>
                <th>Amount Details</th>
                <th>Amount</th>
                <th>Bill Status</th>
                <th>Soft Copy Bill</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
                <tr>
                    <td>{{ $bill->TRN_ID }}</td>
                    <td>{{ $bill->Name }}</td>
                    <td>{{ $bill->EVENT_ID }}</td>
                    <td>{{ $bill->Amount_Details }}</td>
                    <td>{{ $bill->Amount }}</td>
                    <td>{{ $bill->Bill_Status }}</td>
                    <td>{{ $bill->SoftCopyBill }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
            