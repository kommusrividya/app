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
    <a href="payeecreate" class="btn btn-success">New payee</a><br><br>

    <table class="table table-bordered table-condensed table-responsive" >
            <tr>
                <td>PID</td>
                <td>MID</td>
                <td>Name</td>
                <td>Phone Number</td>
                <td>Email</td>
                <td></td>
            </tr>
            @foreach($payees as $payee)
                <tr>
                    <td>{{ $payee->id }}</td>
                    <td>{{ $payee->memid }}</td>
                    <td>{{ $payee->name }}</td>
                    <td>{{ $payee->phno }}</td>
                    <td>{{ $payee->email }}</td>
                    <td><button class="btn btn-primary editpayee" id="{{$payee_id}}">Edit</button></td>
                </tr>
            @endforeach
    </table>
</div>

</body>
</html>