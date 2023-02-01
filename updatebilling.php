<?php
    //connect to database
	require('database.php');

	//load Header Page
	include('header.php');

    //retrieve session information
    $userid = $_SESSION['userid'];

    //run query on database to gather product billing information
    $billing_sql = "SELECT * FROM Billings WHERE UserID='$userid'";
    $billing_query = mysqli_query($db, $billing_sql);

    //check if any billing info exists for user
    if (mysqli_num_rows($billing_query) == 1) {
        //fetch billing results
        $billing_results = mysqli_fetch_array($billing_query, MYSQLI_ASSOC);

        //save billing information to variables
        $view_billingid   = $billing_results['BillingID'];
        $view_cctype      = $billing_results['CreditCardType'];
        $view_ccno        = $billing_results['CreditCardNumber'];
        $view_ccexpdate   = $billing_results['CreditCardExpiryDate'];
        $view_ccpin       = $billing_results['CreditCardPIN'];
        $view_billaddress = $billing_results['User_BillingAddress'];
        $view_shipaddress = $billing_results['User_ShippingAddress'];
    }

    //process registration form data if data was posted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //create variable for posted value from each field
        $cctype = $_POST['update-cctype'];
        $ccno = $_POST['update-ccno'];
        $ccexpdate = $_POST['update-ccexpdate'];
        $ccpin = $_POST['update-ccpin'];
        $billaddress = $_POST['update-billaddress'];
        $shipaddress = $_POST['update-shipaddress'];


        //insert update SQL details and database query to execute
        $update_sql = "UPDATE Billings
                        SET CreditCardType='$cctype',
                            CreditCardNumber='$ccno',
                            CreditCardExpiryDate='$ccexpdate',
                            CreditCardPIN='$ccpin',
                            User_BillingAddress='$billaddress',
                            User_ShippingAddress='$shipaddress'
                        WHERE UserID = $userid
                        AND BillingID = $view_billingid";
        //send query to database
        $update_query = mysqli_query($db, $update_sql);

        //checking if query inserted data
        if ($update_query) {
            //if query was successful
            echo '<div class="alert alert-success" role="alert">
                    Billing Information was successfully updated!
                        </div>';
        }
        else {
            //if query was unsuccessful, show warning
            echo '<div class="alert alert-danger" role="alert">
                    Billing Information was not successfully updated!
                        </div>';
        }
    }
?>

<!-- core page content -->
<div class="container mx-auto" style="width: 650px; position:relative; top:50px; background-color:#102E33;">
    <ul class="nav justify-content-center">
        <!-- heading for web page -->
        <h1 style="color:#F7F052">Update Billing Information</h1>
    </ul>
    <div class="row">
        <ul class="nav justify-content-center">
            <div class="col-8">
                <!-- form action for update billing web page -->
                <form action="updatebilling.php" method="post">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                            <!-- form field for credit card type -->
                            <ul class="nav justify-content-center">
                                <label for="exampleInputCCType1" class="form-label">Credit Card Type</label>
                                <input type="text" value= "<?php echo $view_cctype ?>"
                                class="form-control" id="exampleInputCCType1"
                                aria-describedby=" cctypeHelp" name="update-cctype">
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                            <!-- form field for credit card number -->
                            <ul class="nav justify-content-center">
                                <label for="exampleInputCCNo1" class="form-label">Credit Card Number</label>
                                <input type="text" value= "<?php echo $view_ccno ?>"
                                class="form-control" id="exampleInputCCNo1"
                                aria-describedby="ccnoHelp" name="update-ccno">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                            <!-- form field for credit card expiry date -->
                            <ul class="nav justify-content-center">
                                <label for="exampleInputCCExpDate1" class="form-label">Credit Card Expiry Date</label>
                                <input type="text" value= "<?php echo $view_ccexpdate ?>"
                                class="form-control" id="exampleInputCCExpDate1"
                                aria-describedby="ccexpdateHelp" name="update-ccexpdate">
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                            <!-- form field for credit card PIN -->
                            <ul class="nav justify-content-center">
                                <label for="exampleInputCCPIN1" class="form-label">Credit Card PIN</label>
                                <input type="password" placeholder="****"
                                class="form-control" id="exampleInputCCPIN1"
                                aria-describedby="ccpinHelp" name="update-ccpin">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                            <!-- form field for billing address -->
                            <ul class="nav justify-content-center">
                                <label for="exampleInputBillAddress1" class="form-label">Billing Address</label>
                                <input type="text" value= "<?php echo $view_billaddress ?>"
                                class="form-control" id="exampleInputBillAddress1"
                                name="update-billaddress">
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3" style="color:turquoise">
                            <!-- form field for shipping address -->
                            <ul class="nav justify-content-center">
                                <label for="exampleShipAddress1" class="form-label">Shipping Address</label>
                                <input type="text" value= "<?php echo $view_shipaddress ?>"
                                class="form-control" id="exampleShipAddress1"
                                name="update-shipaddress">
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="col">
                        <div class="row mb-3">
                            <!-- button to update billing information -->
                            <ul class="nav justify-content-center">
                                <button type="submit" class="btn btn-success">Update</button>
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
