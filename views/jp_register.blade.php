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
    
    <form class = "form-horizontal" method="POST" id="jp_register_form">
        <div class="col-md-10 mx-auto">
            
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label">BSPD Member ID</label>
                    <input class="form-control getmemberids" type="text" id="membersearch" name="memberid" list="memberids" placeholder="Enter ID or name to search" required/>
                    <datalist id="memberids"></datalist>
                </div>
                <div class="col-sm-6">
                    <br>
                    <label class="radio-inline">
                        <input type="radio" name="jpregister" id="jpregister" value="Y" required>Register
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="jpregister" id="jpregister" value="N">Deregister
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6" id = "mcname">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input type="submit" name="submit" id="submit" value="Submit" class = "btn btn-success">
                    <input type="reset" value="Reset" class = "btn btn-secondary">
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>