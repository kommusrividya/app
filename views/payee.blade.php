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
        <h3 class="">{{ $heading }}</h3>
        <div id = "result"></div>
    </div>
   <!--
    *Name
    *Govt ID: Drop down aadhar or pan
    *Govt ID: text field
    *Email
    Phone
    Address 1:
    Address 2:
    City:
    State:
    Country:

-->
        <div class="col-md-10 mx-auto">
            <!--<div class="form-group row">-->
            <!--    <div class="col-sm-6">-->
            <!--        <label class = "label-control">Payee : <span id="payee_name"></span></label>-->
            <!--        <input type = "text" class = "form-control" name = "payee" id = "payee" list="payees" placeholder="Search by payee-id, name or phno" required>-->
            <!--            <datalist id="payees">-->
            <!--            <option></option>-->
            <!--            @foreach ($payees as $payee)-->
            <!--                <option value = "{{ $payee->id }}">{{ $payee->id }} {{ $payee->name }} Ph: {{ $payee->phone_num }}</option>-->
            <!--            @endforeach-->
            <!--            </datalist>-->
            <!--    </div>-->
            <!--    <div class="col-sm-6">-->
            <!--        <br>-->
            <!--        <button class="btn btn-success" id="edit_payee_details" name="edit_payee_details">Edit</button>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Member ID(IF PAYEE IS A MEMBER)</label>
                    <input type = "text" class = "form-control" name = "MEMBER_ID" id = "MEMBER_ID">   
                </div>
                <input type = "hidden" name = "memberid" id = "memberid">
                <div class="col-sm-6">
                    <br>
                    <button class="btn btn-success" id="bring_member_details" name="bring_member_details">Fetch details</button>
                </div>
            </div>
            <form class = "form-horizontal" method="POST" id="payee_form">
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Name *</label>
                    <input type = "text" class = "form-control" name = "name" id = "name" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Govt. ID Type</label>
                    <select id = "govtid_type" class="form-control">
                        <option value="Aadhar Card">Aadhar Card</option>
                        <option value="PAN Card">PAN Card</option>
                    </select>    
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Govt. ID</label>
                    <input type = "text" class = "form-control" name = "govtid" id = "govtid">   
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Phone *</label>
                    <input type="text" class = "form-control" name = "Phone_Num" id = "Phone_Num" required>
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Email *</label>
                    <input type="email" class = "form-control" name = "email" id = "email" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Address Line 1</label>
                    <input type="text" class = "form-control" name = "address1" id = "address1">
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Address Line 2</label>
                    <input type="text" class = "form-control" name = "address2" id = "address2">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label class = "label-control">City</label>
                    <input type="text" class = "form-control" name = "city" id = "city">
                </div>
                <div class="col-sm-4">
                    <label class = "label-control">State</label>
                    <input type="text" class = "form-control" name = "state" id = "state">
                </div>
                <div class="col-sm-4">
                    <label class = "label-control">Country</label>
                    <input type="text" class = "form-control" name = "country" id = "country">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">ID proof(Aadhar link)</label>
                    <input type = "text" class = "form-control" name = "link" id = "link" required>
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