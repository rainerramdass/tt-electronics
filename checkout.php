<?php

	//connect to database
	require('database.php');

    //Load Header Page
	include('header.php');

    // retrieval of user id from session value
    $userid = $_SESSION['userid'];

    //run query on database to gather billing data for user
    $billing_sql = "SELECT * FROM Billings WHERE UserID='$userid'";
    $billing_query = mysqli_query($db, $billing_sql);

    //check if any billing records exist
    if (mysqli_num_rows($billing_query) == 1) {
    //successfully login create SESSION variables from Query results
        $retrieveorder_results = mysqli_fetch_array($billing_query, MYSQLI_ASSOC);

        //set variable for billing id
        $billingid = $retrieveorder_results['BillingID'];

        //check for total parameter & total value is more than 0 & cart isn't empty
        if (isset($_REQUEST['total'])) {

            //create total and userid variables
            $total = $_REQUEST['total'];

            //create order record in database
            $ordersql = "INSERT INTO Orders (UserID, BillingID, Order_Date, Order_Total, Order_Status) VALUES('$userid', '$billingid', NOW(), '$total', 'Pending')";
            $orderquery = mysqli_query($db, $ordersql);

            //capture current id value of inserted order record
            $orderid = mysqli_insert_id($db);

            //run query on database to gather product data for order details record
            $orderdetailsql = "SELECT * FROM Products WHERE ProductID IN (";
            //create loop to gather ProductIDs from cart session
            foreach ($_SESSION['cart'] as $prodid => $value) {
                $orderdetailsql .= $prodid . ',';
            }
            $orderdetailsql = substr($orderdetailsql, 0, -1) . ") ORDER BY ProductID ASC";
            $orderdetailquery = mysqli_query($db, $orderdetailsql);

            //fetch values from database
            while ($record = mysqli_fetch_array($orderdetailquery, MYSQLI_ASSOC)) {
                //defining variables for orderdetail items
                $prodid = $record['ProductID'];
                $img = $record['Product_Image'];
                $name = $record['Product_Name'];
                $stock = $record['Product_Quantity'];
                $price = $_SESSION['cart'][$record['ProductID']]['price'];
                $quantity = $_SESSION['cart'][$record['ProductID']]['quantity'];

                //insert order detail record into database
                $orderdetsql = "INSERT INTO OrderDetails (OrderID, ProductID, OProduct_Quantity, OProduct_Cost) VALUES('$orderid', '$prodid', '$quantity', '$price')";
                $orderdetquery = mysqli_query($db, $orderdetsql);

                //if query was successful
                if ($orderquery){
                    // print order successful message
                    echo '<div class="alert alert-success" role="alert">
                        Order was successfully created!
                        </div>';
                    }
            }


    ?>
                <!-- core page content -->
                <div class="container mx-auto" style="height:300px; width:60rem; position:relative; top:15px; background-color:#102E33;">
                <div class="row mt-3 text-center">
                    <!-- heading for web page -->
                    <h2 style="position:relative; top:5px; color:#F7F052">Checkout</h2>
                </div>

                        <!-- cart contents -->
                        <div class="row">
                            <!-- wide section for cart items -->
                            <div class="col">
                                <!-- begin loop for cart products -->
                                <?php

                                //capture order records from database
                                $confirmedordersql = "SELECT * FROM Orders, Users WHERE OrderID = '$orderid' AND Orders.UserID=Users.UserID";
                                $confirmedorderquery = mysqli_query($db, $confirmedordersql);

                                $confirmedorderrecord = mysqli_fetch_array($confirmedorderquery, MYSQLI_ASSOC);
                                    //defining confirmed order variables
                                    $corder_date = $confirmedorderrecord['Order_Date'];
                                    $corder_user = $confirmedorderrecord['UserID'];
                                    $corder_username = $confirmedorderrecord['User_FName'] . " " . $confirmedorderrecord['User_LName'];
                                    $corder_total = $confirmedorderrecord['Order_Total'];

                                    //display general order details
                                    ?>


                                    <!--display order details -->
                                    <div class="row justify-content-center">
                                        <div class="card text-bg-dark" style="position:relative; top:15px; width: 25rem;">
                                            <div class="card-header">
                                                <h5 style="color:white">Your Order was successfully created!</h5>
                                            </div>
                                            <div class="card-body">
                                                <h5 style="color:white">Order ID: <?php echo $orderid ?></h5>
                                                <h5 style="color:white">Order Date: <?php echo $corder_date ?></h5>
                                                <h5 style="color:white">Order Total: $<?php echo number_format($total,2)?></h5>
                                            </div>
                                            <div class="card-footer text-center">
                                                <a href="orderdetails.php?order=<?php echo $orderid ?>" class="btn btn-primary">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

        <?php
            // if query was successful
            if ($orderdetquery) {
                //deduct product
                $product_sql = "SELECT * FROM Products WHERE ProductID IN (";
                //create loop to gather ProductIDs from cart session
                foreach ($_SESSION['cart'] as $prodid => $value) {
                    $product_sql .= $prodid . ',';
                }
                $product_sql = substr($product_sql, 0, -1) . ") ORDER BY ProductID ASC";
                $product_query = mysqli_query($db, $product_sql);

                //fetch details from database
                    while ($record = mysqli_fetch_array($product_query, MYSQLI_ASSOC)) {
                        $new_quantity = $stock - $quantity;
                        $update_sql = "UPDATE Products SET Product_Quantity='$new_quantity' WHERE ProductID = $prodid";
                        $update_query = mysqli_query($db, $update_sql);
                        ;
                    }

                    //empty cart if successful
                    $_SESSION['cart'] = NULL;
                }

        } else {
            // query did not work, display error message
            echo '<div class="alert alert-danger" role="alert">
                No Order was Checked Out, please return to Your Cart!
                        </div>';
        }
    }
    else{
        //redirect to add billing web page
            header('Location: addbilling.php');
            return;
    }
?>

<?php
	//load Footer Page
	include('footer.php');
?>