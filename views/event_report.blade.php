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
    </div>
    <div class="row col-sm-12">
        R|A<br>
        0|0	People who have not registered for an event.<br>
        0|1	People who have attended without registering<br>
        1|0	People who have registered but have not attended<br>
        1|1	People who have registered and attended<br>
    </div>
    
    <form class = "form-horizontal" action="" method="POST" id="event_report_form">
        <div class="col-md-10 mx-auto">
            
            <div class="form-group row">
                <div class="col-sm-2">
                    <label class="label-control">Select event *</label>
                    <select name = "report_event_id" id = "report_event_id" class = "form-control" required>
                        <option>Choose one</option>
                        @foreach ($events as $event)
                        <option value = "{{ $event->id }}" data-date="{{ $event->date}}" data-entity_id="{{ $event->entity_id }}">{{ $event->entity_id }} {{ $event->id }} - {{ $event->date}} {{ $event->description }}</option>   
                        @endforeach
                    </select>     
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Team</label>
                    <select name = "team" id = "team" class = "form-control">
                        <option value=' '>All</option>
                        <option value='ADMIN'>T100</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Registered</label>
                    <select name = "registered" id = "registered" class = "form-control">
                        <option value='RY'>Registered(as Attending) - 1</option>
                        <option value='RN'>Registered(as not Attending)</option>
                        <option value='N'>Not registered - 0</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Attended</label>
                    <select name = "attended" id = "attended" class = "form-control">
                        <option value='Y'>Attended - 1</option>
                        <option value='N' selected>Not Attended - 0</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Gender</label>
                    <select name = "gender" id = "gender" class = "form-control">
                        <option value=' '>Choose one</option>
                        <option value='M'>Male</option>
                        <option value='F'>Female</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label class = "label-control">Age min</label>
                    <input class="form-control" type="text" id="age_min" name="age_min"/>
                </div>
                
                <div class="col-sm-2">
                    <label class = "label-control">Age max</label>
                    <input class="form-control" type="text" id="age_max" name="age_max"/>
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
    <div id="result" class="row col-sm-12">
    </div>
</div>

</body>
</html>