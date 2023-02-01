<?php
    //connect to database
    require('database.php');

    //load Header Page
	include('header.php');

    //retrive session values
    $userid = $_SESSION['userid'];
    $email = $_SESSION['email'];

    //retrieve posted password data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pass1 = $_POST['update-pass1'];
        $pass2 = $_POST['update-pass2'];

        //checking if passwords do not match
        if ($pass1 == $pass2) {
            //create password variables since password was confirmed
            $password = $pass1;
            //insert SQL details to user table and database query to execute
            $updatepass_sql = "UPDATE Users
                                SET   User_Password=SHA1('$password')
                                WHERE UserID = $userid";
            $updatepass_query = mysqli_query($db, $updatepass_sql);

            //checking if query inserted data
            if ($updatepass_query) {
                // query was successful
                echo '<div class="alert alert-success" role="alert">
                User Password was updated successfully!!
                </div>';
            }
            else{
                // query failed
                echo '<div class="alert alert-danger" role="alert">
                User Password was not updated!
                </div>';
            }
        }
        else{
            // passwords did not match
            echo '<div class="alert alert-danger" role="alert">
            Passwords are not identical!
            </div>';
        }
    }
?>

        <!-- core page content -->
        <div class="container mx-auto" style="width: 650px; position:relative; top:50px; background-color:#102E33;">
            <ul class="nav justify-content-center">
                <!-- heading for web page -->
                <h1 style="color:#F7F052">Change My Password</h1>
            </ul>
            <div class="row">
                <div class="col-6">
                    <!-- form action for change password web page -->
                    <form action="changepassword.php" method="post">
                        <div class="mb-3" style="color:turquoise">
                            <!-- form field for password -->
                            <ul class="nav justify-content-center">
                                <label for="InputPassword1" class="form-label">Password</label>
                                <input type="password" placeholder="Insert New Password"
                                class="form-control" id="InputPassword1"
                                name="update-pass1">
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                            <!-- form field for password confirmation -->
                            <ul class="nav justify-content-center">
                                <label for="ConfirmPassword1" class="form-label">Confirm Password</label>
                                <input type="password" placeholder="Confirm New Password"
                                class="form-control" id="ConfirmPassword1"
                                name="update-pass2">
                            </ul>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <ul class="nav justify-content-center">
                                <!-- button to set new password -->
                                <button type="submit" class="btn btn-success">Update Password</button>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>

<?php
    //load Footer Page
    include('footer.php');
?>