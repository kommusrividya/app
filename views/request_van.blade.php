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
        <h3 class="text-danger">{{ $heading }}</h3>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class = "label-control">Member ID(Enter a member ID to get their VAN details)</label>
            <input type = "text" class = "form-control" name = "vanid" id = "vanid" value="{{ $_SESSION['id'] }}">
        </div>
    </div>

    <div>
        <br><h4 class="text-danger"><b>EXCLUSIVE ACCOUNT NUMBERS FOR YOUR CONTRIBUTION</b></h4>
        <h4 class="text-danger"><b>For Chandihomam at BSPD Hyderabad (THROUGH NEFT ONLY)</b></h4>
        Bank Name : South India Bank
        <br>Branch : Corporate Branch, Hyderabad
        <br>IFSC CODE : SIBL0000722
        <br>Account Type : Current
        <br>Nickname : BSPDCH
        <br>Accnt number : A345A11CHMA<span id="CHVAN">{{ str_pad($_SESSION['id'],8,"0",STR_PAD_LEFT) }}</span>
    </div>

    <div class="form-check form-switch">
        <br>
        <input class="form-check-input" type="checkbox" name="generalvan" id="generalvan">
        <label class="form-check-label" for="generalvan">Switch on for General Contribution VAN details</label>
    </div>  
    <div id="general_van_details" style="display: none; padding:15px;">
        <h5 class="text-danger">For General Contribution at BSPD Hyderabad</h5>
        <br>Bank Name : South India Bank
        <br>Branch : Corporate Branch, Hyderabad
        <br>IFSC CODE : SIBL0000722
        <br>Account Type : Current
        <br>Nickname : BSPDGN
        <br>Accnt number : A345A11GNMA<span id="GNVAN">{{ str_pad($_SESSION['id'],8,"0",STR_PAD_LEFT) }}</span>
    </div>
    <!--<div style="display: inline-block; padding:15px;">
        <h5 class="text-danger">For Bulk Bhikshavandanam at BSPD Hyderabad</h5>
        Nickname : BSPDBV
        <br>Accnt number : A345A11BVCD{{ str_pad($_SESSION['id'],8,"0",STR_PAD_LEFT) }}
    </div>-->
</div>

</body>
</html>