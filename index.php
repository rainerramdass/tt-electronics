<html lang="en">
    <head>
        <!-- core admin generic content linking css, defining meta data-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
        crossorigin="anonymous">
    </head>

    <!-- core page content -->
    <body class="bg-dark">
        <div class="container mx-auto" style="position:relative; top:150px;">
            <ul class="nav justify-content-center">
                <div class="container-fluid">
                    <!-- TT Electronics Logo -->
                    <ul class="nav justify-content-center">
                        <img src="images/logo/tt-electronics-logo.png" alt="images/alerts/file_notfound.png">
                    </ul>
                    <!-- Welcome Message -->
                    <h1 class="text-bg-dark text-center p-3 ">WELCOME TO TT ELECTRONICS</h1>
                    <div class="row" style="position:relative; top:25px;">
                        <ul class="nav justify-content-center">
                            <div class="card-body text-center">
                                <div class="col" style="max-height:40px;">
                                    <div class="row">
                                        <!-- Login Button -->
                                        <ul class="nav justify-content-center">
                                            <a href="login.php" class="btn btn-success btn-lg">Login with an Existing Account</a>
                                        </ul>
                                    </div>
                                    <div><br></div>
                                    <div class="row">
                                        <!-- Register Button -->
                                        <ul class="nav justify-content-center">
                                            <a href="register.php" class="btn btn-primary btn-lg">Register a New Account</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </ul>

<?php
    //load Footer Page
	include('footer.php');
?>
