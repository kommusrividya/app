@include('header')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!--<title>{{ $heading }}</title>-->
    
    
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
                    <h3 id="heading">Event Registration</h3>       
            </div>
            <div id=""></div>
                <form class="form-horizontal" method="POST" id="event_registration_form">
                <div class="col-md-10 mx-auto">
                    <input type="hidden" id="form_mode" value="update">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="control-label">Select event</label>
                            <select name = "event_id" id = "event_id" class = "form-control" required>
                                <option>Select option</option>
                                @foreach ($events as $event)
                                    <option value = "{{ $event->id }}" data-notes="{{ $event->notes }}" data-entity_id="{{ $event->entity_id }}">{{ $event->entity_id }} {{ $event->id }} - {{ $event->date}} {{ $event->description }}</option>   
                                @endforeach
                            </select>     
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12" name = "event_description" id = "event_description">
                        </div>
                    </div>
                    <div class="form-group row">
                        
                        <!--Date: <div class="col-sm-3" name = "event_date" id = "event_date">
                        </div>
                        Location: <div class="col-sm-3" name = "event_location" id = "event_location">
                        </div>
                        Time: <div class="col-sm-3" name = "event_date" id = "event_date">
                        Duration: <div class="col-sm-3" name = "event_duration" id = "event_duration">
                        </div>-->
                    <div class="form-group row">
                        <div class="col-sm-12" name = "event_note" id = "event_note">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="control-label">BSPD Member ID</label>
                            <input class="form-control getmemberids" type="text" id="membersearch" name="memberid" list="memberids" placeholder="Enter ID or name to search" required/>
                            <datalist id="memberids"></datalist>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="control-label">Name</label>
                            <input class="form-control" type="text" disabled id="name" name="firstname" required/>
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <label class="radio-inline">
                                <input type="radio" name="reg" value="Y" required>Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="reg" value="N">No
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success">Register</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                    </div>
                </div>
            </form>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
</html>