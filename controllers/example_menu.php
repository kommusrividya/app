<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $heading }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css">
</head>
<body>
    <nav class="navbar fixed-top navbar-expand-md navbar-dark" style="background-color: #812626;">
        <div class="container-fluid">
            <a class="navbar-brand" href="home">BSPD Self Service</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Add your nav items here -->
                    <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home">Home</a>
                        </li>
                </ul>
                <div class="nav navbar-right" >
                    <li class="nav-item dropdown">
                        <a class="nav-link active navbar-btn dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#FFFFFF;">
                            <span class="glyphicon glyphicon-user"></span> {{ $_SESSION["name"] }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <!-- Add your dropdown items here -->
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home">Home</a>
                        </li>
                        <!-- Add more sidebar items as needed -->
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h1>Welcome to BSPD Self Service</h1>
                <!-- Add your main content here -->
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-fVwXsJ1NqzODKgP4zzgsNc2nFuLCpmsZK0lI82T3bCz7XU/NmzZb1O9hP5uSHx2R" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
