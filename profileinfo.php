<?php
    //connect to database
    require('database.php');

    //load Header Page
	include('header.php');

    //retrieve values from session
    $userid = $_SESSION['userid'];
    $email = $_SESSION['email'];

    //check submitted values with ones from user table
    $sql = "SELECT * FROM Users WHERE UserID='$userid'";
    $query = mysqli_query($db, $sql);

    //check if any record exists in database
    if(mysqli_num_rows($query) == 1){
    //if($query){
        //fetch user details
        $results = mysqli_fetch_array($query, MYSQLI_ASSOC);

        //retrieve user information
        $user_firstname = $results['User_FName'];
        $user_lastname = $results['User_LName'];
        $user_email = $results['User_Email'];
        $user_phonenumber = $results['User_PhoneNumber'];
        $date_register = $results['Date_Registered'];
    }
    else{
        //unsuccessful retrieval attempt
        echo '<div class="alert alert-warning" role="alert">
            User information not retrieved!
        </div>';
    }

    //process updated user information if data was posted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //create variable for posted value from each field
        $fname = $_POST['update-fname'];
        $lname = $_POST['update-lname'];
        $email = $_POST['update-email'];
        $phone = $_POST['update-phone'];

        //if user did not change their first name, use old data
        if($fname==null){
            $fname = $user_firstname;
        }

        //if user did not change their last name, use old data
        if($lname==null){
            $lname = $user_lastname;
        }

        //if user did not change their email, use old data
        if($email==null){
            $email = $user_email;
        }

        //if user did not change their phone number, use old data
        if($phone==null){
            $phone = $user_phonenumber;
        }

        //insert update SQL details and database query to execute
        $update_sql = "UPDATE Users
                        SET User_FName='$fname',
                            User_LName='$lname',
                            User_Email='$email',
                            User_PhoneNumber='$phone'
                        WHERE UserID = $userid";
        //contact database using query
        $update_query = mysqli_query($db, $update_sql);

        //checking if query inserted data
        if ($update_query) {
            //query was successful
            echo '<div class="alert alert-success" role="alert">
            User Information was updated successfully!!
            </div>';
        }
        else{
            //query failed
            echo '<div class="alert alert-danger" role="alert">
            User Information was not updated!
            </div>';
        }
    }

?>

<!-- core page content -->
<div class="container mx-auto" style="width: 650px; position:relative; top:50px; background-color:#102E33;">
    <ul class="nav justify-content-center">
        <!-- heading for web page -->
        <h1 style="color:#F7F052">Profile Information</h1>
    </ul>

    <!-- profile information form -->
    <div class="row">
        <ul class="nav justify-content-center">
            <div class="col-8">
                <!-- form action for profile info web page -->
                <form action="profileinfo.php" method="post">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                                <!-- form field for user id -->
                                <ul class="nav justify-content-center">
                                    <label for="exampleInputID1" class="form-label">User ID</label>
                                    <input class="form-control" type="text" placeholder="<?= $userid ?>"
                                    aria-label="Disabled input example" disabled>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                                <!-- form field for registration date -->
                                <ul class="nav justify-content-center">
                                    <label for="exampleInputRegDate1" class="form-label">Registration Date</label>
                                    <input class="form-control" type="text" placeholder="<?= $date_register ?>"
                                    aria-label="Disabled input example" disabled>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                                <!-- form field for user's first name -->
                                <ul class="nav justify-content-center">
                                    <label for="exampleInputFName1" class="form-label">First Name</label>
                                    <input type="text" value="<?php echo $user_firstname;?>"
                                    class="form-control" id="exampleInputFName1"
                                    aria-describedby="fnameHelp" name="update-fname">
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                                <!-- form field for user's last name -->
                                <ul class="nav justify-content-center">
                                    <label for="exampleInputLName1" class="form-label">Last Name</label>
                                    <input type="text" value="<?php echo $user_lastname ?>"
                                    class="form-control" id="exampleInputLName1"
                                    aria-describedby="lnameHelp" name="update-lname">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                                <!-- form field for user's email address -->
                                <ul class="nav justify-content-center">
                                    <label for="exampleInputEmail1" class="form-label">Email Address</label>
                                    <input type="email" value="<?php echo $user_email ?>"
                                    class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="update-email">
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3" style="color:turquoise">
                                <!-- form field for user's phone number -->
                                <ul class="nav justify-content-center">
                                    <label for="exampleInputPhone1" class="form-label">Phone Number</label>
                                    <input type="text" value="<?php echo $user_phonenumber ?>"
                                    class="form-control" id="exampleInputPhone1"
                                    aria-describedby="phoneHelp" name="update-phone">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <ul class="nav justify-content-center">
                                <!-- button to update user info -->
                                <button type="submit" class="btn btn-success">Update</button>
                            </ul>
                        </div>
                        <div><br></div>
                        <div class="row">
                            <ul class="nav justify-content-center">
                                <!-- link to change user's password -->
                                <a href="changepassword.php" class="btn btn-primary">Change My Password</a>
                            </ul>
                        </div>
                        <div><br></div>

                        <?php
                        //run query on database to gather billing data
                        $billing_sql = "SELECT * FROM Billings WHERE UserID='$userid'";
                        $billing_query = mysqli_query($db, $billing_sql);

                        // if user type is a customer
                        if($user_type == "Customer"){
                            //check if any record of billing exists for this customer
                            if (mysqli_num_rows($billing_query) == 1) {
                            ?>
                                <div class="row">
                                    <ul class="nav justify-content-center">
                                        <!-- user can update their billing information -->
                                        <a href= "updatebilling.php" class="btn btn-primary">Update Billing Information</a>
                                    </ul>
                                </div>

                            <?php
                            }
                            // no record of billing id linked to customer
                            else {
                            ?>
                                <div class="row">
                                    <ul class="nav justify-content-center">
                                        <!-- user can enter their billing information -->
                                        <a href= "addbilling.php" class="btn btn-primary">Add Billing Information</a>
                                    </ul>
                                </div>
                            <?php
                            }
                        }
                        // if user type is administrator
                        else{}
                            ?>
                    </div>
                </form>
            </div>
        </ul>
    </div>

<?php
	//load Footer Page
	include('footer.php');
?>