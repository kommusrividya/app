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
    
    <form class = "form-horizontal" action="" method="POST" id="expense_form">
        <div class="col-md-10 mx-auto">
            
            <div class="form-group row">
                <input type="hidden" id="form_mode" name="form_mode" value="{{ $form_mode }}">
                <div class="col-sm-6">
                    <label class = "label-control">Event</label>
                    <select class = "form-control" name = "event" id = "event" required>
                    <option disabled selected>Choose one</option>
                        @foreach ($events as $event)
                            <option value = "{{ $event->id }}" data-date="{{ $event->date }}" data-voucher="{{ $event->voucher_num }}">{{ $event->id }} - {{ $event->description }}</option>   
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Transaction date</label>
                    <input type = "date" class = "form-control" name = "transaction_date" id = "transaction_date" required>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Voucher number</label>
                    <input type = "number" class = "form-control" name = "voucher_num" id = "voucher_num" @if($form_mode == "create") disabled @endif  required>
                </div>
            </div>
            @if($form_mode == "update")
            <div class="form-group row">
                <div class="col-sm-3">
                    <button class="btn" style="background-color: #812626; color:#FFFFFF;" id="expense_edit" name="expense_edit">Edit</button>
                </div>
            </div>
            @endif
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
                <div class="col-sm-3">
                    <label class = "label-control">Amount</label>
                    <input type = "number" class = "form-control" name = "amount" id = "amount" required>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Expense type</label>
                    <select class = "form-control" name = "expense_type" id = "expense_type" required>
                        <option value = "NEFT">NEFT</option>
                        <option value = "KIND">KIND</option>
                        <option value="CASH">CASH</option>
                        <option value="CHEQUE">CHEQUE</option>
                    </select>
                </div>
            </div>
            <div class = "form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">Category</label>
                    <select name = "category" id = "category" class = "form-control" required>
                        
                        
                        @foreach ($categories as $category)
                            <option value = "{{ $category->id }}">{{ $category->id }} {{ $category->description }}</option>   
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Sub Category</label>
                    <select name = "sub_category" id = "sub_category" class = "form-control" required>
                        @foreach ($sub_categories as $sub_category)
                            <option value = "{{ $sub_category->id }}">{{ $sub_category->id }} {{ $sub_category->description }}</option>   
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Expense details</label>
                    <textarea class = "form-control" name = "expense_details" id = "expense_details" maxlength="100"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">Bill Status</label>
                    <select name = "bill_status" id = "bill_status" class = "form-control">
                        <option value="pending">Choose one</option>
                        <option value="received">Received</option>
                        <option value="pending" selected>Pending</option>
                        <option value="NA">Not Applicable</option>
                        <option value="pending_forever">Pending Forever</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Soft Copy Bill</label>
                    <select name = "soft_copy_bill" id = "soft_copy_bill" class = "form-control">
                        <option value="pending">Choose one</option>
                        <option value="uploaded">Uploaded</option>
                        <option value="pending" selected>Pending</option>
                        <option value="NA">Not Applicable</option>
                    </select> 
                </div>
                @if($form_mode == "update")
                <div class="col-sm-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input soft_copy_voucher" type="checkbox" id="soft_copy_voucher" value="Y">
                        <label class="form-check-label" for="soft_copy_voucher">Soft-Copy Voucher</label>
                    </div>
                </div>
                <div class="col-sm-1 text-success" id="soft_copy_voucher_checked">
                
                </div>
                <div class="col-sm-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input voucher_signed" type="checkbox" id="voucher_signed" value="Y">
                        <label class="form-check-label" for="voucher_signed">Voucher Signed</label>
                    </div>
                </div>
                <div class="col-sm-1 text-success" id="voucher_signed_checked">
                    
                </div>
                @endif
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Expense bill number</label>
                    <input type = "text" class = "form-control" name = "bill_number" id = "bill_number" >
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Bank Account</label> <!-- Bank registration code -->
                    <select class = "form-control" name = "brc" id = "brc">
                    </select>
                </div>
            </div>
            @if($form_mode == "update")
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Payment Intimation URL</label>
                    <input type = "text" class = "form-control" name = "payment_intimation_url" id = "payment_intimation_url">
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Payment Date</label>
                    <input type = "date" class = "form-control" name = "payment_date" id = "payment_date">
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Payment Status</label>
                    <!--<input type = "text" class = "form-control" name = "event_description" id = "event_description">-->
                    <select class = "form-control" name = "payment_status" id = "payment_status">
                        <option value = "pending">Pending</option>
                        <option value = "pay">Pay</option>
                        @if($_SESSION['permission'] & PERM_CRUD)
                        <option value="in_process">In Process</option>
                        <option value = "paid">Paid</option>
                        <option value = "provisioned">Provisioned</option>
                        <option value = "void">Void</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Payment Confirmation ID/Cheque Number</label>
                    <input type = "text" class = "form-control" name = "payemnt_confirmation_id" id = "payment_confirmation_id">
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">UTR Number</label>
                    <input type = "text" class = "form-control" name = "utr_number" id = "utr_number">
                </div>
            </div>
            @endif
            <div class="form-group row">
                <div class="col-sm-12">
                    <label class = "label-control">Notes</label>
                    <textarea class = "form-control" name = "notes" id = "notes" maxlength="1000"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6" id="date_warning"></div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
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