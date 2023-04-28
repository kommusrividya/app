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
<style>
    th {
        font-size: 20px;
    }
</style>

<div class="container">
    <div class="row">
        <h3>{{ $heading }}</h3>
    </div>
    <div>
        <table class="table table-bordered table-condensed">
            <th>#</th>
            <th>Name</th>
            <th>Category</th>
            <th>Amount</th>
            <th>C</th>
            </tr>
            @foreach ($vouchers as $voucher)
                <tr>
                    <td>{{ $voucher->number }}</td>
                    <td>{{ substr($voucher->name,0,18) }}</td>
                    <td>{{ substr($voucher->sub_category,0, 15) }}</td>    
                    <td>{{ substr($voucher->amount_details,0,40) }}</td>  
                    <td>&nbsp;&nbsp;</td>        
                </tr>
            @endforeach
        </table>
</body>
</html>