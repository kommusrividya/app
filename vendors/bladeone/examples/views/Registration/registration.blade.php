@include('Registration.header')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Register</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="register.js"></script>
    <!-- Bootstrap -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
          rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"
          rel="stylesheet" type="text/css">
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
    <h3>Event Registration</h3>
    </div>
    
    <form class = "form-horizontal">
        <div class="col-md-10 mx-auto">
            <div class="form-group row">
                @foreach ($details as $detail)
                <div class="col-sm-6">
                    @label($detail->id, $detail->name, "class='control-label'")&nbsp;
                    @input($detail->id,' ','text', "class='form-control'")<br>
                </div>
                @endforeach
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                @label(1, "Batch", "class='control-label'")
                @select('id',"class='object form-control'")
                    @item('0','--Select batch--')
                    @items($agegroups,'id','name',$agegroupSelected)
                @endselect()
                </div>
                <div class="col-sm-6">
                @label(1, "Member type", "class='control-label'")
                @select('id',"class='object form-control'")
                     @item('0','--Select--')
                    @items($membertypes,'id','name',$membertypeSelected)
                @endselect()
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
            @commandbutton('boton','v1','Submit','submit',"class='btn-primary'")
                </div></div>
        </div>
    </form>
</div>
</body>
</html>
