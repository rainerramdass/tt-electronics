<?php
	//connect to database
    require('database.php');

    //capture if user was logged out
    if(isset($_REQUEST['logout'])){
        $parameter = $_REQUEST['logout'];
    }

    //process login form data only if form is posted
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
		#create variable for posted value from each field
        $email = $_POST['l-email'];
        $password = $_POST['l-pass'];

		//check submitted values with ones from database
        $sql = "SELECT * FROM Users WHERE User_Email='$email' AND User_Password=SHA1('$password')";
        $query = mysqli_query($db, $sql);

        //check if any record of email and password exists in database
        if (mysqli_num_rows($query) == 1) {
        //fetch user details from user table
        $results = mysqli_fetch_array($query, MYSQLI_ASSOC);

        //create session and session variables
        session_start();
        $_SESSION['userid'] = $results['UserID'];
        $_SESSION['firstname'] = $results['User_FName'];
        $_SESSION['lastname'] = $results['User_LName'];
        $_SESSION['fullname'] = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
        $_SESSION['email'] = $results['User_Email'];
        $_SESSION['usertype'] = $results['User_Type'];

        //send user to product listing web page
        header('Location: productlisting.php');
        return;
    }
        else{
            //unsuccessful login attempt
            echo '<div class="alert alert-warning" role="alert">
                Email and Password do not match. Please try again
            </div>';
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
                    <!-- Link to index page -->
                    <li class="nav-item">
                        <a class="nav-link active" style="color:white" aria-current="page" href="index.php">Home</a>
                    </li>
                    <!-- Menu displaying register or login -->
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" style="color:white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuDark">
                            <!-- Link to register page -->
                            <li><a class="dropdown-item" style="color:white" href="register.php">Register</a></li>
                            <!-- Link to login page -->
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
            <ul class="nav justify-content-center" style="position:relative; top:5px;">
            <!-- heading -->
                <h1 style="color:#F7F052">Login</h1>
            </ul>

            <!-- login form -->
            <div class="row">
                <ul class="nav justify-content-center">
                    <div class="col-8">
                        <!-- form action for login web page -->
                        <form action="login.php" method="post">
                            <div class="container">
                                <!-- Email address form field -->
                                <div class="mb-3" style="color:turquoise">
                                    <label for="InputEmail1" class="form-label fw-semibold">Email address</label>
                                    <input type="email" class="form-control" id="InputEmail1"
                                    aria-describedby="emailHelp" name="l-email" placeholder="Please insert your Email Address here">
                                    <div class="form-text"></div>
                                </div>
                                <!-- Password form field -->
                                <div class="mb-3" style="color:turquoise">
                                    <label for="InputPassword1" class="form-label fw-semibold">Password</label>
                                    <input type="password" class="form-control" id="InputPassword1"
                                    name="l-pass" placeholder="Please insert your Password here">
                                </div>
                                <div class="card-body text-center">
                                    <div class="row">
                                        <!-- Login Button -->
                                        <ul class="nav justify-content-center">
                                            <button type="submit" class="btn btn-success">Login</button>
                                        </ul>
                                    </div>
                                    <div><br></div>
                                    <div class="row">
                                        <!-- Link to Register Button -->
                                        <ul class="nav justify-content-center">
                                            <a href="register.php" class="btn btn-primary">Don't have an Account? Register Here!</a>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="nav justify-content-center">
                                        <?php
                                            // Detects if user is still active
                                            if(isset($parameter)){
                                        ?>
                                                <!-- displays logout alert -->
                                                <div class="alert alert-success m-3" role="alert">
                                                    You have successfully logged out!
                                                </div>
                                        <?php
                                            }
                                            else {}
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </ul>
            </div>

<?php
    //load Footer Page
	include('footer.php');
?>
