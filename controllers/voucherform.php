<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Voucher form</title>
    
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
    <form action="voucher">
    <div class="form-group row">
        <div class="col-sm-6">
            <label class = "label-control">Event ID</label>
            <input type = "text" class = "form-control" name = "EVENT_ID" id = "EVENT_ID" required>
        </div>
        <div class="col-sm-3">
            <label class = "label-control">Voucher # Start</label>
            <input type = "number" class = "form-control" name = "start" id = "start" required>
        </div>
        <div class="col-sm-3">
            <label class = "label-control">Voucher # Finish</label>
            <input type = "number" class = "form-control" name = "end" id = "end" required>
        </div>
    </div>
    <div class="form-group row">
                <div class="col-sm-6">
                    <input type = "submit" value = "Submit" name = "submit" id = "submit" class = "btn btn-success">    
                </div>
            </div>
    </form>
</div>

</body>
</html>