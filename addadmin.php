<?php
    //connect to database
    require('database.php');

    //load Header Page
	include('header.php');

    // load session data for users
    $firstname = $_SESSION['firstname'];
    $email = $_SESSION['email'];

    //process admin information posted by user
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //create variable for posted value from each field
        $fname = $_POST['reg-fname'];
        $lname = $_POST['reg-lname'];
        $email = $_POST['reg-email'];
        $phone = $_POST['reg-phone'];
        $pass1 = $_POST['reg-pass1'];
        $pass2 = $_POST['reg-pass2'];
        $user_type = "Administrator";

        //checking if passwords do not match
        if($pass1 == $pass2){
            //create password variable since password was confirmed
            $password = $pass1;

            //insert SQL details and database query to user table
            $sql = "INSERT INTO Users (User_FName, User_LName, User_Email, User_PhoneNumber, User_Password, User_Type, Date_Registered)
            VALUES ('$fname', '$lname', '$email', '$phone', SHA1('$password'), '$user_type', NOW())";
            $query = mysqli_query($db, $sql);

            //checking if query inserted data
            if($query){
                //alert if query was successfully completed
                echo '<div class="alert alert-success" role="alert">
                Admin was added successfully!!
                </div>';
            }else {
                //alert if query did not work
                echo '<div class="alert alert-danger" role="alert">
                    Admin was not added!
                        </div>';
            }
        }
        else {
            //password did not match, show warning
            echo '<div class="alert alert-danger" role="alert">
                    Password was not confirmed
                        </div>';
        }
    }
?>

<!-- core page content -->
<div class="container mx-auto" style="width: 650px; position:relative; top:50px; background-color:#102E33;">
    <ul class="nav justify-content-center" style="position:relative; top:5px;">
        <h1 style="color:#F7F052">Admin Registration Form</h1>
    </ul>

    <!-- register form -->
    <div class="row">
        <ul class="nav justify-content-center">
            <div class="col-8">
                <!-- post form action for add admin page -->
                <form action="addadmin.php" method="post">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                            <!-- form field for admin's first name -->
                                <ul class="nav justify-content-center">
                                    <label for="InputFName1" class="form-label fw-semibold">First Name</label>
                                    <input type="text" placeholder="First Name" required
                                    class="form-control" id="InputFName1"
                                    aria-describedby="fnameHelp" name="reg-fname">
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                            <!-- form field for admin's last name -->
                                <ul class="nav justify-content-center">
                                    <label for="InputLName1" class="form-label fw-semibold">Last Name</label>
                                    <input type="text" placeholder="Last Name" required
                                    class="form-control" id="InputLName1"
                                    aria-describedby="lnameHelp" name="reg-lname">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                            <!-- form field for admin's email address -->
                                <ul class="nav justify-content-center">
                                    <label for="InputEmail1" class="form-label fw-semibold">Email Address</label>
                                    <input type="email" placeholder="Email Address" required
                                    class="form-control" id="InputEmail1"
                                    aria-describedby="emailHelp" name="reg-email">
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                            <!-- form field for admin's phone number -->
                                <ul class="nav justify-content-center">
                                    <label for="InputPhone1" class="form-label fw-semibold">Phone Number</label>
                                    <input type="text" placeholder="Phone Number" required
                                    class="form-control" id="InputPhone1"
                                    aria-describedby="phoneHelp" name="reg-phone">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                            <!-- form field for admin's password -->
                                <ul class="nav justify-content-center">
                                    <label for="InputPassword1" class="form-label fw-semibold">Password</label>
                                    <input type="password" placeholder="Password" required
                                    class="form-control" id="InputPassword1"
                                    name="reg-pass1">
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                            <!-- form field for confirmation of admin's password -->
                                <ul class="nav justify-content-center">
                                    <label for="ConfirmPassword1" class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" placeholder="Password" required
                                    class="form-control" id="ConfirmPassword1"
                                    name="reg-pass2">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- checkbox for terms and conditions -->
                    <div class="mb-3 form-check" style="color:white">
                        <input type="checkbox" class="form-check-input" id="Check1" required>
                        <label class="form-check-label" for="Check1">I agree with the Terms and Conditions</label>
                    </div>
                    <div class="col">
                        <div class="row mb-3">
                            <!-- button for completing registration of admin -->
                            <ul class="nav justify-content-center">
                                <button type="submit" class="btn btn-success">Finish</button>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </ul>
    </div>
</div>

<?php
	//load Footer Page
	include('footer.php');
?>
