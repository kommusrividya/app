@include('header')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{{ $heading }}</title>
    
    <!-- Jquery files-->
    <script src="assets/js/jquery.min.js"></script>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>
    
<div class="container">
    <div class="row">
        <h3>{{ $heading }}</h3>
    </div>
    
    <form class = "form-horizontal" method="POST" id="member_report_form">
        <div class="col-md-10 mx-auto">
            <div class="form-group row">
                <div class="col-sm-5">
                    <label class="control-label">BSPD Member ID</label>
                    <input class="form-control getmemberids" type="text" id="membersearch" disabled name="memberid"  required list="memberids" placeholder="Enter ID or name to search" value="{{ $_SESSION['id'] }}" required/>
                    <datalist id="memberids"></datalist>
                </div>
                <div class="col-sm-7">
                    <label class = "label-control">Select Report Type</label>
                    <br>
                    <label class="radio-inline">
                        <input type="radio" name="report" value="recognition" required>Recognition
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="report" value="contribution">Contribution
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="report" value="expenses">Expenses
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="report" value="attendance">Attendance
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="report" value="reference">References
                    </label>
                </div>
            </div>
            <div class="form-group row"> 
                <div class="col-sm-5">
                    <br><input type="submit" name="submit" id="submit" value="Submit" class = "btn btn-success">
                </div>
            </div>
        </div>
    </form>
    <div id="result" class="row col-sm-12">
    </div>
</div>

</body>
</html>