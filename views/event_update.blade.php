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
    
    <form class = "form-horizontal" action="ecreation.php" method="POST" id="event_creation_form">
        <div class="col-md-10 mx-auto">
            
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">Event ID</label>
                    <input type = "text" class = "form-control" name = "event_id" id = "creation_event_id" required>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Date</label>
                    <input type = "date" class = "form-control" name = "event_date" id = "event_date" required>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Status</label>
                    <!--<input type = "text" class = "form-control" name = "event_description" id = "event_description">-->
                    <select class = "form-control" name = "event_status" id = "event_status" disabled = "disabled">
                        
                        <option value = "0">Active</option>
                        <option value = "1">Inactive</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Event Location</label>
                    <input type = "text" class = "form-control" name = "event_location" id = "event_location">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Description</label>
                    <textarea class = "form-control" name = "event_description" id = "event_description"></textarea>
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Notes</label>
                    <textarea class = "form-control" name = "event_notes" id = "event_notes"></textarea>
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