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
    
    <form class = "form-horizontal" method="POST">
        <div class="col-md-10 mx-auto">
            
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">Event ID</label>
                    <select class = "form-control" name = "event_id" id = "attendance_event_id" required>
                        @foreach ($events as $event)
                            <option value = "{{ $event->id }}" data-entity_id="{{ $event->entity_id }}">{{ $event->entity_id }} {{ $event->id }} - {{ $event->desc }}</option>   
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Member ID</label>
                    <input class="form-control" type="text" id="MEMBER_ID" required/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input class="form-control" readonly type="text" id="name" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <button class="btn btn-success"  id="bring_member_details" name="bring_member_details">Verify</button>
                    <button class="btn btn-success"  id="event_attendance_form" name="event_attendance_form">Submit</button>
                </div>
            </div>
            
            @include('member_search')
        </div>
    </form>
</div>

</body>
</html>