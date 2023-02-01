<?php

    //connect to database
    require('database.php');

    //capture parameter in variable
    $parameter = $_REQUEST['order'];

    //load Header Page
	include('header.php');

    //capturing all order data
    $order_sql = "SELECT * FROM Orders, Billings, Users WHERE OrderID=$parameter
                                                            AND Orders.UserID=Users.UserID
                                                            AND Billings.UserID=Users.UserID";
    $order_query = mysqli_query($db, $order_sql);

    //detecting if any order exists
    if (mysqli_num_rows($order_query) > 0) {

        //fetch data from order table
        $order_results = mysqli_fetch_array($order_query, MYSQLI_ASSOC);
        //create variables for each database field item
        $ouser_id   = $order_results['UserID'];
        $order_date = $order_results['Order_Date'];
        $order_total = $order_results['Order_Total'];
        $order_status = $order_results['Order_Status'];
        $first_name = $order_results['User_FName'];
        $last_name = $order_results['User_LName'];
        $full_name = $first_name." ".$last_name;
        $ship_address = $order_results['User_ShippingAddress'];

    }
?>

<!-- core page content -->
<div class="container mx-auto" style="position:relative; top:25px; background-color:#102E33;">
    <ul class="nav justify-content-center">
        <!-- heading for web page -->
        <h2 style="color:#F7F052">Order Details</h2>
    </ul>

    <!-- view order information -->
    <div class="row">

    <!-- dynamically generating cards for database items -->
    <div class="container bg-dark">
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-dark">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="d-flex justify-content-center"style="color:white">General Details</h3>
                                <div class="col-md-12" style="color:white; font-size:14px">
                                    <!-- view order id -->
                                    <label for=""><b>Order ID</b></label>
                                    <p><?php echo $parameter ?></p>
                                </div>
                                <div class="col-md-12" style="color:white; font-size:14px">
                                    <!-- view user id -->
                                    <label for=""><b>User ID</b></label>
                                    <p><?php echo $ouser_id ?></p>
                                </div>
                                <div class="col-md-12" style="color:white; font-size:14px">
                                    <!-- view full name of user -->
                                    <label for=""><b>Full Name</b></label>
                                    <p><?php echo $full_name ?></p>
                                </div>
                                <div class="col-md-12" style="color:white; font-size:14px">
                                    <!-- view shipping address of user -->
                                    <label for=""><b>Shipping Address</b></label>
                                    <p><?php echo $ship_address ?></p>
                                </div>
                                <div class="col-md-12" style="color:white; font-size:14px">
                                    <!-- view order date -->
                                    <label for=""><b>Order Date</b></label>
                                    <p><?php echo $order_date ?></p>
                                </div>
                                <div class="col-md-12" style="color:white; font-size:14px">
                                    <!-- view order total -->
                                    <label for=""><b>Order Total</b></label>
                                    <p>$<?php echo $order_total ?></p>
                                </div>
                                <div class="col-md-12" style="color:white; font-size:14px">
                                    <!-- view order status -->
                                    <label for=""><b>Order Status</b></label>
                                    <p><?php echo $order_status ?></p>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <!-- view all products linked to order -->
                                <h3 class="d-flex justify-content-center" style="color:white">Product Details</h3>
                                <hr>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <!-- table headings -->
                                                <th class="align-middle" style="color:white">Image</th>
                                                <th class="align-middle" style="color:white">Product</th>
                                                <th class="align-middle" style="color:white">Cost</th>
                                                <th class="align-middle" style="color:white">Quantity</th>
                                                <th class="align-middle" style="color:white">Subtotal</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            //capturing all order details data for rows
                                            $orderdet_sql = "SELECT * FROM OrderDetails, Products, Manufacturers WHERE OrderID =$parameter
                                                                                                    AND Products.ProductID=OrderDetails.ProductID
                                                                                                    AND Products.ManufacturerID=Manufacturers.ManufacturerID";
                                            $orderdet_query = mysqli_query($db, $orderdet_sql);

                                            //detecting products
                                            if (mysqli_num_rows($orderdet_query) > 0) {

                                                // table rows
                                                foreach ($orderdet_query as $item) {
                                                $subtotal = $item['OProduct_Cost']*$item['OProduct_Quantity'];
                                                    ?>
                                                        <tr>
                                                            <td class="align-middle">
                                                                <!-- view product image -->
                                                                <img src="images/products/<?php echo $item['Product_Image']; ?>" width="120px" height="80px" alt="">
                                                            </td>
                                                            <td class="align-middle" style="color:white">
                                                                <!-- view product name -->
                                                                <?php echo $item['Manufacturer_Name']." ".$item['Product_Name']; ?>
                                                            </td>
                                                            <td class="align-middle" style="color:white">
                                                                <!-- view product cost in order -->
                                                                $<?php echo $item['OProduct_Cost']; ?>
                                                            </td>
                                                            <td class="align-middle" style="color:white">
                                                                <!-- view product quantity in order -->
                                                                <?php echo $item['OProduct_Quantity']; ?>
                                                            </td>
                                                            <td class="align-middle" style="color:white">
                                                                <!-- view subtotal -->
                                                                $<?php echo number_format($subtotal,2);?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php }
    else{
        // if no orders were detected
        echo '<div class="alert alert-danger" role="alert">
                No orders were found
                    </div>';
        }

    //load Footer Page
	include('footer.php');
?>


