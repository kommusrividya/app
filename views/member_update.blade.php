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
    <input type = "hidden" id="form" value="member_update">
    
        
        <div class="col-md-10 mx-auto">
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Member ID</label>
                    <input type = "text" class = "form-control" name = "MEMBER_ID" id = "MEMBER_ID" value = "{{ $row['MEMBER_ID'] }}" <?php if(!($_SESSION['permission'] & MEMBER_U_ANY)) echo "disabled"; ?>>
                </div>
                <div class="col-sm-6">
                    <br>
                    <button class="btn btn-success" id="bring_member_details" name="bring_member_details">Fetch details</button>
                </div>
            </div>
            <form class = "form-horizontal" method="POST" id="member_update_form">
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Member ID(below details belong to)</label>
                    <input type = "text" class = "form-control" name = "memberid" id = "memberid" value = "{{ $row['MEMBER_ID'] }}" disabled>
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Phone number</label>
                    <input type = "text" class = "form-control" name = "Phone_Num" id = "Phone_Num" disabled>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label class = "label-control">Name</label>
                    <input type = "text" class = "form-control" name = "first_name" id = "first_name" <?php if(!($_SESSION['permission'] & MEMBER_U_ANY)) echo "disabled"; ?>>
                </div>
                <div class="col-sm-4">
                    <label class = "label-control">Surname</label>
                    <input type = "text" class = "form-control" name = "last_name" id = "last_name" <?php if(!($_SESSION['permission'] & MEMBER_U_ANY)) echo "disabled"; ?>>
                </div>
                <div class="col-sm-4">
                    <label class = "label-control">Year of Birth</label>
                    <input type = "number" class = "form-control" name = "yob" id = "yob">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">Father ID</label>
                    <input type = "text" class = "form-control" name = "father_id" id = "father_id" >
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Mother ID</label>
                    <input type = "text" class = "form-control" name = "mother_id" id = "mother_id" >
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Spouse ID</label>
                    <input type = "text" class = "form-control" name = "spouse_id" id = "spouse_id" >
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">MEMBER SEARCH FIELD</label>
                    <input type = "text" class = "form-control" id = "membersearch" placeholder="Enter ID, name or surname to search" list="memberids">
                    <datalist id="memberids"></datalist>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label class = "label-control">Gotram</label>
                    <select name="gotra" id="gotra" class="form-control">
                        @foreach ($gotras as $gotra)
                            <option value="{{ $gotra->id }}">{{ $gotra->name }}-{{ $gotra->pravara }}</option>   
                        @endforeach
                    </select>    
                </div>
                <div class="col-sm-4">
                    <label class = "label-control">Nakshatra</label>
                    <select name="nakshatra" id="nakshatra" class="form-control">
                        <option value="null">Choose one</option> 
                        @foreach ($nakshatras as $nakshatra)
                            <option value="{{ $nakshatra->id }}">{{ $nakshatra->engname }}/{{ $nakshatra->telname }}</option>   
                        @endforeach
                    </select>    
                </div>
                <div class="col-sm-4">
                    <label class = "label-control">Pada</label>
                    <select name="pada" id="pada" class="form-control">
                    <option value="null">Choose one</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">Smartha Purohit</label>
                    <select name="smartha_purohit" disabled id="smartha_purohit" class="form-control">
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Veda Pandit</label>
                    <select name="veda_pandit" disabled id="veda_pandit" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Mulam</option>
                    <option value="2">Kramapati</option>
                    <option value="3">Ghanapati</option>
                    <option value="4">Sastra Pandit</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Jathakaparivarthana</label>
                    <select name="jp" id="jp" class="form-control">
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Blood Group</label>
                    <select name="blood_group" id="blood_group" class="form-control">
                        <option value="O+">O+</option>
                        <option value="A+">A+</option>
                        <option value="B+">B+</option>
                        <option value="AB+">AB+</option>
                        <option value="O-">O-</option>
                        <option value="A-">A-</option>
                        <option value="B-">B-</option>
                        <option value="AB-">AB-</option>
                        <option value="Unknown">Unknown</option>
                        
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Location</label>
                    <input type = "text" class = "form-control" name = "location" id = "location" >
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Email</label>
                    <input type = "email" class = "form-control" name = "email" id = "email" >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class = "label-control">Address Line 1</label>
                    <input type = "text" class = "form-control" name = "address1" id = "address1">
                </div>
                <div class="col-sm-6">
                    <label class = "label-control">Address Line 2</label>
                    <input type = "text" class = "form-control" name = "address2" id = "address2" >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class = "label-control">City</label>
                    <input type = "text" class = "form-control" name = "city" id = "city" >
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">State</label>
                    <input type = "text" class = "form-control" name = "state" id = "state" >
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">Country</label>
                    <input type = "text" class = "form-control" name = "country" id = "country" >
                </div>
                <div class="col-sm-3">
                    <label class = "label-control">PIN or ZIP</label>
                    <input type = "number" class = "form-control" name = "PIN_or_ZIP" id = "PIN_or_ZIP" >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input type = "submit" value = "Update" name = "update" id = "update" class = "btn btn-success">    
                </div>
            </div>
        </div>
    </form>
</div>
            