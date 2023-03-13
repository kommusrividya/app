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
       
    <form class = "form-horizontal" action="" method="POST" id="change_password_form">
        <div class="col-md-10 mx-auto">
            
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Member_ID</label>
                    <input type = "text" class = "form-control" name = "MEMBER_ID" id = "MEMBER_ID" value = "{{ $MEMBER_ID }}" disabled="disabled">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Old Password *</label>
                    <input type = "password" class = "form-control" name = "old_password" id = "old_password" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">New Password *</label>
                    <input type = "password" class = "form-control" name = "new_password" id = "new_password" required>
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Reverify New Password *</label>
                    <input type = "password" class = "form-control" name = "new_password2" id = "new_password2" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input type="submit" name="submit" id="submit" value="Update" class = "btn btn-success">
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>