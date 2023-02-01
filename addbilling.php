<?php
    //connect to database
	require('database.php');

	//load Header Page
	include('header.php');

    //load session data for users
    $userid = $_SESSION['userid'];

    //process retrieval of billing information posted by user
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //create variable for posted value from each field
        $cctype = $_POST['add-cctype'];
        $ccno = $_POST['add-ccno'];
        $ccexpdate = $_POST['add-ccexpdate'];
        $ccpin = $_POST['add-ccpin'];
        $billaddress = $_POST['add-billaddress'];
        $shipaddress = $_POST['add-shipaddress'];

        //insert SQL details and database query to billing table
        $sql = "INSERT INTO Billings (UserID, CreditCardType, CreditCardNumber, CreditCardExpiryDate, CreditCardPIN, User_BillingAddress, User_ShippingAddress)
                VALUES ('$userid', '$cctype', '$ccno', '$ccexpdate', '$ccpin', '$billaddress', '$shipaddress')";
        $query = mysqli_query($db, $sql);

        //checking if query inserted data
        if ($query) {
            //Query was successful
            echo '<div class="alert alert-success" role="alert">
                    Billing Information was successfully added!
                        </div>';
        } else {
            //Query was unsuccessful, show warning
            echo '<div class="alert alert-danger" role="alert">
                    Billing Information was unable to be added!
                        </div>';
        }
    }
?>

<!-- core page content -->
<div class="container mx-auto" style="width: 650px; position:relative; top:50px; background-color:#102E33;">
    <ul class="nav justify-content-center">
        <!-- heading for section -->
        <h1 style="color:#F7F052">Add Billing Information</h1>
    </ul>

    <!-- register form -->
    <div class="row">
        <ul class="nav justify-content-center">
            <div class="col-8">
                <!-- form action for add billing web page -->
                <form action="addbilling.php" method="post">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                        <!-- form field for credit card type -->
                            <ul class="nav justify-content-center">
                                <label for="InputCCType1" class="form-label">Credit Card Type</label>
                                <input type="text" placeholder="Credit Card Type" required
                                class="form-control" id="InputCCType1"
                                aria-describedby="CCTypeHelp" name="add-cctype">
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                        <!-- form field for credit card number -->
                            <ul class="nav justify-content-center">
                                <label for="InputCCNo1" class="form-label">Credit Card Number</label>
                                <input type="text" placeholder="0000-0000-0000-0000" required
                                class="form-control" id="InputCCNo1"
                                aria-describedby="CCNoHelp" name="add-ccno">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                        <!-- form field for credit card expiry date -->
                            <ul class="nav justify-content-center">
                                <label for="InputCCExpDate1" class="form-label">Credit Card Expiry Date</label>
                                <input type="text" placeholder="YYYY-MM-DD" required
                                class="form-control" id="InputCCExpDate1"
                                aria-describedby="CCExpDateHelp" name="add-ccexpdate">
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                        <!-- form field for credit card pin -->
                            <ul class="nav justify-content-center">
                                <label for="InputCCPIN1" class="form-label">Credit Card PIN</label>
                                <input type="password" placeholder="Credit Card PIN" required
                                class="form-control" id="InputCCPIN1"
                                aria-describedby="CCPINHelp" name="add-ccpin">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                        <!-- form field for billing address -->
                            <ul class="nav justify-content-center">
                                <label for="InputBillAddress1" class="form-label">Billing Address</label>
                                <input type="text" placeholder="Billing Address" required
                                class="form-control" id="InputBillAddress1"
                                name="add-billaddress">
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                        <!-- form field for shipping address -->
                            <ul class="nav justify-content-center">
                                <label for="ShipAddress1" class="form-label">Shipping Address</label>
                                <input type="text" placeholder="Shipping Address" required
                                class="form-control" id="ShipAddress1"
                                name="add-shipaddress">
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="col">
                        <div class="row mb-3">
                            <!-- button for completing addition of billing details -->
                            <ul class="nav justify-content-center">
                                <button type="submit" class="btn btn-success">Finish</button>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </ul>
    </div>

    <?php
        //load footer Page
        include('footer.php');
    ?>
