@include('Registration.header')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{{ $heading }}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
          
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
        <h3 class="text-primary">{{ $heading }}</h3>
        <div id = "result"></div>
    </div>
    
    <form class = "form-horizontal" action="ecreation.php" method="POST" id="form">
        <div class="col-md-10 mx-auto">
            
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">Event name</label>
                    <input type = "text" class = "form-control" name = "event_name" id = "event_name">
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Event code</label>
                    <input type = "text" class = "form-control" name = "event_code" id = "event_code">
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Description</label>
                    <input type = "text" class = "form-control" name = "event_description" id = "event_description">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">Event type</label>
                    <!--<input type = "text" class = "form-control" name = "event_type" id = "event_type">-->
                    <select name = "event_type" id = "event_type" class = "form-control">
                        @foreach ($types as $type)
                            <option value = "{{ $type }}">{{ $type }}</option>   
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Date</label>
                    <input type = "date" class = "form-control" name = "event_date" id = "event_date">
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Status</label>
                    <!--<input type = "text" class = "form-control" name = "event_description" id = "event_description">-->
                    <select class = "form-control" name = "event_active" id = "event_active" disabled = "disabled">
                        
                        <option value = "1">Active</option>
                        <option value = "0">Inactive</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">MC(Member ID)</label>
                    <input type = "text" class = "form-control" name = "event_mc" id = "event_mc" list="memberids">
                    <datalist id="memberids"></datalist>
                </div>
            </div>
            <!--<div class = "form-group row">
                <div class = "col-sm-6">
                    <label class = "control-label">Batch name</label>
                    <input type = "text" name = "batchname1" class = "form-control" id = "batchname1">
                </div>
                <div class = "col-sm-3">
                    <label class = "control-label">Batch time</label>
                    <input type = "time" name = "batchtime1" class = "form-control" id = "batchtime1">
                </div>
                <div class = "col-sm-3" id = "mcname">              </div>
            </div>
            <div id = "batches"></div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Add a batch</label>
                    <button class = "btn btn-primary" id = "addbatch"> + </button>
                </div>
            </div>-->
            <div class="form-group row">
                <div class="col-sm-6">
                    <input type="submit" name="submit" id="submit" value="Submit" class = "btn btn-primary">
                    <input type="reset" value="Reset" class = "btn btn-primary">
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>

