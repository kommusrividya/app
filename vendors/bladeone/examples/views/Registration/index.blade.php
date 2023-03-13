@include('Registration.header')
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
                    <h3 class="text-primary" id="heading">Event Registration</h3>
                    <p class="text-justify">
                        This form is for you to let us know if you  are going to participate in the Toastmasters session on Sunday afternoon from 4 PM.
                        We have two categories of registration - Participant and Audience. People can register themselves as Audience and have their name in Zoom as "Audience- &lt;Name&gt;
                        " format so that we don't ask them to participate.
                    </p>
                    <p>
                        Topic :
                        Batch1, Batch2, Batch3 - Choose a topic of your choice and speak(we are not giving any topic this week)
                    </p>
                </div>
                <form class="form-horizontal" action="registration.php" method="POST" id="form">
                <div class="col-md-10 mx-auto">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="control-label">BSPD Member ID</label>
                            <input class="form-control getmemberids" type="text" id="memberid" name="memberid" list="memberids" />
                            <datalist id="memberids"></datalist>
                        </div>

                        <div class="col-sm-6">
                            <label class="control-label">Phone number</label>
                            <input class="form-control getmemberids" type="number" id="phonenumber" name="phonenumber" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="control-label">First name</label>
                            <input class="form-control" type="text" id="firstname" name="firstname" />
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">Last name</label>
                            <input class="form-control" type="text" id="lastname" name="lastname" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            @label('id','Select batch')
                            @select('id',"class='object form-control'")
                            @item('0','--Select batch--')
                            @items($agegroups,'id','name',$agegroupSelected)
                            @endselect()
                            <!--<label class="control-label">Age group</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="age" id="opt1" value="1">
                                    Upto 10 years
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="age" id="opt2" value="2">
                                    11-17 years
                                </label>
                            </div>


                            <div class="radio">
                                <label>
                                    <input type="radio" name="age" id="opt3" value="3">
                                    Above 18 years
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="age" id="opt4" value="4">
                                    Parent
                                </label>
                            </div>
                        -->
                        </div>

                        <!--</div>

                        <div class="form-group">-->
                        <div class="col-sm-6">
                            <label class="control-label">Participant or Audience</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="type" id="participant" value="participant">
                                    Participant
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="type" id="audience" value="audience">
                                    Audience
                                </label>
                            </div>
                        </div>
                    </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary">Register</button>
                                <button type="reset" class="btn btn-primary">Reset</button>
                            </div>
                    </div>
                </div>
                <div class="modal" id="modal1" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal">&times;</button>
                                <div class="modal-title">Registration successful</div>
                            </div>
                            <div class="modal-body"></div>

                        </div>
                        </div>
                    </div>
            </form>
        <div class="result"></div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
</html>