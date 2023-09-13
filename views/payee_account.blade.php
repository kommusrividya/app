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
    
    <form class = "form-horizontal" method="POST" id="payee_accnt_form">
        <div class="col-md-10 mx-auto">
            
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Payee : <span id="payee_name"></span></label>
                    <input type = "text" class = "form-control" name = "payee" id = "payee" list="payees" placeholder="Search by payee-id, name or phno" required>
                        <datalist id="payees">
                        <option></option>
                        @foreach ($payees as $payee)
                            <option value = "{{ $payee->id }}">{{ $payee->id }} {{ $payee->name }} Ph: {{ $payee->phone_num }}</option>
                        @endforeach
                        </datalist>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Payee Account Number</label>
                    <input type="text" class = "form-control" name = "accnt_num" id = "accnt_num">
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Name in Account</label>
                    <input type="text" class = "form-control" name = "name_in_accnt" id = "name_in_accnt">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Nick Name</label>
                    <input type="text" readonly class = "form-control" name = "nick_name" id = "nick_name">
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Bank Name</label>
                    <input type="text" class = "form-control" name = "bank_name" id = "bank_name">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Bank Branch</label>
                    <input type="text" class = "form-control" name = "bank_branch" id = "bank_branch">
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">IFSC Code</label>
                    <input type="text" class = "form-control" name = "ifsc" id = "ifsc">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Pass Book Link</label>
                    <input type="text" class = "form-control" name = "link" id = "link">
                </div>
                
                <div class="col-sm-4">
                    <label class = "label-control">Bank Registration Code</label>
                    <input type="text" class = "form-control" name = "barc" id = "barc" disabled>
                </div>
                <div class="col-sm-2">
                    <label class = "label-control">Ac Status</label>
                    <select id="account_status" class = "form-control" name="account_status" disabled>
                        <option>Upload</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
                <input type="hidden" id="mode" value="create">
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input type="submit" name="submit" id="submit" value="Submit" class = "btn btn-success">
                    <input type="reset" value="Reset" class = "btn btn-secondary">
                </div>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-condensed table-responsive" id="payee_account_table">
        <thead>
            <tr>
                <th>Account Number</th>
                <th>Bank Name</th>
                <th>IFSC</th>
                <th>Bank Reg Code</th>
                <th>Account Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
</body>
</html>