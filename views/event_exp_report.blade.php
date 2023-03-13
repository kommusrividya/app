@include('header')
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{{ $heading }}</title>

    <!-- Jquery files
    <script src="assets/js/jquery.min.js"></script> -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <h3>{{ $heading }}</h3>
        </div>

        <form class="form-horizontal" method="POST" id="event_exp_report_form">
            <div class="col-md-10 mx-auto">
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label class="control-label">Event</label>
                        <input type="text" class="form-control" name="event" id="exp_event" required>
                    </div>
                    <div class="col-sm-7">
                        <label class="label-control">Select Report Type</label>
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
                            <input type="radio" name="report" value="finsum">Financial Summary
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-5">
                        <br><input type="submit" name="submit" id="submit" value="Submit" class="btn btn-success">
                    </div>
                </div>
            </div>
        </form>
        <div id="result" class="row col-sm-12">
    </div>
    </div>
    

</body>

</html>
