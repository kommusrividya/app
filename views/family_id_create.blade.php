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
    
    <form class = "form-horizontal" method="POST" id="family_id_form">
        <div class="col-md-10 mx-auto">
            <!--Surname Email Phone Gotram Location Referrer -->
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Surname</label>
                    <input type = "text" class = "form-control" name = "surname" id = "surname" required>
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Email *</label>
                    <input type="email" class = "form-control" name = "email_id" id = "email_id" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Phone *</label>
                    <input type="number" class = "form-control" name = "phone_num" id = "phone_num" required>
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Gotram</label>
                    <select class = "form-control" name = "gotram" id = "gotram">
                        <option selected="selected" value="">Choose one</option>
                        @foreach ($gotrams as $gotram)
                        <option value="{{ $gotram->value }}">{{ $gotram->str }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">Location</label>
                    <select class = "form-control" name = "location" id = "location">
                        <option selected="selected" value="OutsideHYD">Choose one</option>
                        @foreach ($locations as $location)
                        <option value="{{ $location->ward }}">{{ $location->ward }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Referrer ID *</label>
                    <input type="text" class = "form-control" name = "referrer_id" id = "membersearch" required placeholder="Enter ID or name to search" list="memberids">
                    <datalist id="memberids"></datalist>
                </div>
            </div>


            <div class="form-group row">
                <div class="col-sm-4">
                    <label class = "label-control">Name</label>
                    <input type = "text" class = "form-control" name = "name1" id = "name1" required>
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Year of birth</label>
                    <input type="number" class = "form-control" name = "yob" id = "yob" required min="1900">
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Gender</label>
                    <br>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="M">Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="F">Female
                    </label>
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Blood group</label>
                    <select class = "form-control" name = "blood_group" id = "blood_group">
                        <option></option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="O-">Unknown</option>
                    </select>
                </div>
                <div class="col-sm-1">
                <br>
                <button class = "btn btn-danger" id = "addbatch"> - </button>
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