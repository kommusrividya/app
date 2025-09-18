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
    <form class = "form-horizontal" action="" method="POST" id="ticket_no_form">
    <div class="form-group row">
        <div class="col-sm-3">
            <input type = "number" name="ticket" id="ticket" class="form-control">
        </div>
        <div class="col-sm-3">
            <input type="submit" name="submit" id="submit" value="Open Ticket" class = "btn btn-success">
        </div>
    </div>
    </form>
    <form class = "form-horizontal" action="" method="POST" id="bug_edit_form">
        <input type="submit" name="update" value="Update" id="update" class = "btn btn-success"><br>
        <table class="table table-bordered">
            <tr>
                <th>TNo.</th>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Status</th>
                <th>Header</th>
                <th>Resolution</th>
                <th>Resolved By</th>
                <th>Sequence</th>
            </tr>
            <?php $i = 0; ?>
            @foreach ($bugs as $bug)
                <tr>
                    <td>{{ $bug->id }}</td>
                    <input type="hidden" value="{{ $bug->id }}" id="id{{$i}}">
                    <td>{{ $bug->name }}</td>
                    <td><input type="text" value="{{ $bug->category }}" id="category{{$i}}" size="5"></td>
                    <td><textarea id="description{{$i}}">{{ $bug->description }}</textarea></td>
                    <td>
                        <select id="status{{$i}}">
                            <option value="{{ $bug->status }}">{{ $bug->status }}</option>
                            <option value="Open">Open</option>
                            <option value="Hold">Hold</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </td>
                    <td><input type="text" value="{{ $bug->header_uid }}" id="header_uid{{$i}}" size="3"></td>
                    <td><textarea id="resolution{{$i}}">{{ $bug->resolution }}</textarea></td>
                    <td><input type="text" value="{{ $bug->resolved_by }}" id="resolved_by{{$i}}" size="3"></td>
                    <td><input type="text" value="{{ $bug->sequence }}" id="sequence{{$i}}" size="3"></td>
                </tr>
            <?php
                $i++;
            ?>
            @endforeach
            <input type="hidden" value="{{ $i }}" id="count">
        </table>
    </form>
</div>

</body>
</html>