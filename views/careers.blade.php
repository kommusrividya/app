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
            <div class="form-group row">
                    <div class="col-sm-4">
                        <label class = "label-control">Category</label>
                        <select>
                            <option>Select</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->desc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label class = "label-control">Sub Category</label>
                        <select>
                            <option>Select</option>
                            @foreach($sub_categories as $sub_category)
                                <option value="{{ $sub_category->id }}">{{ $sub_category->desc }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    <button id="add_post" class="btn btn-success">New Post</button>
    <button id="backtofeed" class="btn btn-success" style="display:none;">←Back to Feed</button><br><br>
    <br><br>
    <div id="form_section" style="display:none;">
        <form class = "form-horizontal" method="POST" id="career_form">
            <div class="col-md-10 mx-auto">
                
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label class = "label-control">Company *</label>
                        <input type = "text" class = "form-control" name = "company" id = "company" required>
                    </div>
                    <div class="col-sm-4">
                        <label class = "label-control">Contact Phone number *</label>
                        <input type = "number" class = "form-control" name = "phno" id = "phno" required>
                    </div>
                    <div class="col-sm-4">
                        <label class = "label-control">Contact Email *</label>
                        <input type = "text" class = "form-control" name = "email" id = "email" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label class = "label-control">Header *</label>
                        <input type = "text" class = "form-control" name = "header" id = "header" maxlength="50" required>
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-sm-12">
                        <label class = "label-control">Description *</label>
                        <textarea class = "form-control" name = "description" rows="10" id = "description" maxlength="3000" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label class = "label-control">Notes</label>
                        <textarea class = "form-control" rows="3" name = "notes" id = "notes"></textarea>
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
    <div id="career_feed" class="col-md-10 mx-auto">

        @foreach($posts as $post)
        <div class="card" style="border:1px solid black;">
            <div class="card-body">
                <h4 class="card-title" style="max-height: 20px;">
                    <b>{{ $post->id }}.  {{ $post->header }}</b>
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $post->id }}" aria-expanded="false" aria-controls="collapse{{ $post->id }}">
                        Expand
                    </button>
                </h4>
                <div class="collapse" id="collapse{{ $post->id }}">
                    <br>
                    <h5 class="card-subtitle mb-2 ">{{ $post->company }}</h5>
                    <p class="card-text"><?php echo $post->description; ?></p>
                    <p class="card-text">{{ $post->notes }}</p>
                    <span class="card-link"><b>Contact details:</b> {{ $post->phno }}, {{ $post->email }}</span>
                    <span class="card-link"><b>Posted on :</b> {{ $post->date }} by {{ $post->postby }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

</body>
</html>