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
    th, td {
        font-size: 12px;
    }
    </style>   
<div class="container">
    <div class="row">
        <h3>{{ $heading }}</h3>
    </div>
    <div>
        <form class = "form-horizontal" action="" method="POST" id="statement_edit_form">
        <table class="table table-bordered">
            <tr style="background-color:rgb(200, 202, 204)">
            <th style="padding:0;">SNo</th>
            <th style="padding:0;">Name</th>
            <th style="padding:0;">VAN Code</th>
            <th style="padding:0;">Notes</th>
            <th style="padding:0;">Date</th>
            <th style="padding:0;">Amount</th>
            </tr>
            <?php $i = 0; ?>
            @foreach ($records as $record)
                <tr>
                    <td style="padding:0;">{{ $record->SrNo }}</td>
                    <input type="hidden" value="{{ $record->SrNo }}" id="srno{{ $i }}">
                    <td style="padding:0;">{{ $record->name }}</td>
                    <td style="padding:0;"><input type = text style="padding:0;" value="{{ $record->id }}" id="id{{ $i }}" min="12" max="12"></td>
                    <td style="padding:0;"><textarea style="padding:0;" rows="1" id="notes{{ $i }}">{{ $record->notes }}</textarea>
                    <td style="padding:0;"><input type = text style="padding:0;" value="{{ $record->trdate }}" id="trdate{{ $i }}"></td>
                    <td style="padding:0;" align="right"> {{ $record->tramt }}</td>            
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
                <input type="button" id="process" value="Go to Processing Page" class = "btn btn-success" >
            </div>
        </div>
    </form>
    </div>
</div>

</body>
</html>