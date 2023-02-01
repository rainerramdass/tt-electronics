<?php
    //connect to database
    require('database.php');

    //process registration form data if data was posted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //create variable for posted value from each field
        $fname = $_POST['reg-fname'];
        $lname = $_POST['reg-lname'];
        $email = $_POST['reg-email'];
        $phone = $_POST['reg-phone'];
        $pass1 = $_POST['reg-pass1'];
        $pass2 = $_POST['reg-pass2'];
        $user_type = "Customer";

        //checking if passwords do not match
        if ($pass1 == $pass2) {
            //create password variable since password was confirmed
            $password = $pass1;

            //insert SQL details and database query to execute
            $sql = "INSERT INTO Users (User_FName, User_LName, User_Email, User_PhoneNumber, User_Password, User_Type, Date_Registered)
                VALUES ('$fname', '$lname', '$email', '$phone', SHA1('$password'), '$user_type', NOW())";
            $query = mysqli_query($db, $sql);

            //checking if query inserted data
            if ($query) {
                //if query was successfully completed
                echo '<div class="alert alert-success" role="alert">
                    User was registered successfully!
                    </div>';

                //check submitted values with ones from database
                $user_sql = "SELECT * FROM Users WHERE User_Email='$email' AND User_Type='Customer'";
                $user_query = mysqli_query($db, $user_sql);

                //check if any record of email and password exists in database
                if (mysqli_num_rows($user_query) == 1) {
                    //if($query){
                    //successfully login create SESSION variables from Query results
                    $user_results = mysqli_fetch_array($user_query, MYSQLI_ASSOC);

                    //create session and session variables
                    session_start();
                    $userid = $user_results['UserID'];
                }
            }
            else {
                //Registration was unsuccessful, show warning
                echo "Unable to register User. Please try again";
                }
            }
        }
?>

<html lang="en">
    <head>
        <!-- core admin generic content linking css, defining meta data-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
        crossorigin="anonymous">
    </head>
    <!-- body of web page -->
    <body style="background-color:#98A6AA">
        <!-- navbar -->
        <nav class="navbar navbar-expand-xl" style="background-color:#102633">
            <div class="container-fluid">
                <div class="me-auto p-2"></div>
                <a class="navbar-brand" href="#" style="color:white">TT Electronics</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDark" aria-controls="navbarDark" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarDark">
                <ul class="navbar-nav me-auto mb-2 mb-xl-0">
                    <!-- link to index page -->
                    <li class="nav-item">
                        <a class="nav-link active" style="color:white" aria-current="page" href="index.php">Home</a>
                    </li>
                    <!-- dropdown menu for login and register links -->
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" style="color:white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuDark">
                            <!-- link to register menu -->
                            <li><a class="dropdown-item" style="color:white" href="register.php">Register</a></li>
                            <!-- link to login menu -->
                            <li><a class="dropdown-item" style="color:white" href="login.php">Login</a></li>
                        </ul>
                    </li>
                </ul>
                </div>
            </div>
            <div class="me-auto p-2"></div>
        </nav>

        <!-- core page content -->
        <div class="container mx-auto" style="width: 650px; position:relative; top:50px; background-color:#102E33;">
            <!-- heading of web page -->
            <ul class="nav justify-content-center" style="position:relative; top:5px;">
                <h1 style="color:#F7F052">Register</h1>
            </ul>

            <!-- register form -->
            <div class="row">
                <ul class="nav justify-content-center">
                    <div class="col-8">
                        <!-- post form action for register web page -->
                        <form action="register.php" method="post">
                            <div class="container">
                                <div class="row">
                                    <div class="col-6">
                                        <!-- form field for user's first name -->
                                        <div class="mb-3" style="color:turquoise">
                                            <ul class="nav justify-content-center">
                                                <label for="exampleInputFName1" class="form-label fw-semibold">First Name</label>
                                                <input type="text" placeholder="First Name" required
                                                class="form-control" id="exampleInputFName1"
                                                aria-describedby="fnameHelp" name="reg-fname">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- form field for user's last name -->
                                        <div class="mb-3" style="color:turquoise">
                                            <ul class="nav justify-content-center">
                                                <label for="exampleInputLName1" class="form-label fw-semibold">Last Name</label>
                                                <input type="text" placeholder="Last Name" required
                                                class="form-control" id="exampleInputLName1"
                                                aria-describedby="lnameHelp" name="reg-lname">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <!-- form field for user's email address -->
                                        <div class="mb-3" style="color:turquoise">
                                            <ul class="nav justify-content-center">
                                                <label for="exampleInputEmail1" class="form-label fw-semibold">Email Address</label>
                                                <input type="email" placeholder="Email Address" required
                                                class="form-control" id="exampleInputEmail1"
                                                aria-describedby="emailHelp" name="reg-email">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- form field for user's phone number -->
                                        <div class="mb-3" style="color:turquoise">
                                            <ul class="nav justify-content-center">
                                                <label for="exampleInputPhone1" class="form-label fw-semibold">Phone Number</label>
                                                <input type="text" placeholder="Phone Number" required
                                                class="form-control" id="exampleInputPhone1"
                                                aria-describedby="phoneHelp" name="reg-phone">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <!-- form field for user's password -->
                                        <div class="mb-3" style="color:turquoise">
                                            <ul class="nav justify-content-center">
                                                <label for="exampleInputPassword1" class="form-label fw-semibold">Password</label>
                                                <input type="password" placeholder="Password" required
                                                class="form-control" id="exampleInputPassword1"
                                                name="reg-pass1">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- form field for confirmation of user's password -->
                                        <div class="mb-3" style="color:turquoise">
                                            <ul class="nav justify-content-center">
                                                <label for="exampleConfirmPassword1" class="form-label fw-semibold">Confirm Password</label>
                                                <input type="password" placeholder="Password" required
                                                class="form-control" id="exampleConfirmPassword1"
                                                name="reg-pass2">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- mandatory terms and conditions checkbox for registration -->
                                <div class="mb-3 form-check" style="color:white">
                                    <input type="checkbox" class="form-check-input fw-semibold" id="exampleCheck1" required>
                                    <label class="form-check-label" for="exampleCheck1">I agree with the Terms and Conditions</label>
                                </div>
                                <div><br></div>
                                <div class="card-body text-center">
                                    <div class="row">
                                        <!-- button to complete registration -->
                                        <ul class="nav justify-content-center">
                                            <button type="submit" class="btn btn-success">Finish</button>
                                        </ul>
                                    </div>
                                    <div><br></div>
                                    <div class="row">
                                        <!-- link to login web page -->
                                        <ul class="nav justify-content-center">
                                            <a href="login.php" class="btn btn-primary">Already have an Account? Login Here!</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </ul>
        </div>
    </body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
crossorigin="anonymous"></script>
