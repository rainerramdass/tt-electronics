<?php

	//connect to database
	require('database.php');

	//load Header Page
	include('header.php');

    // retrieve user id from session
    $userid = $_SESSION['userid'];

    if($user_type == "Customer"){
        // collect data from order table only for that customer
        $order_sql = "SELECT * FROM Orders WHERE UserID=$userid";
    }
    elseif($user_type == "Administrator"){
        // collect data from order table for all customers
        $order_sql = "SELECT * FROM Orders";
    }
?>

<!-- core web content -->
<div class="container" style="position:relative; top:25px; background-color:#102E33;">>
    <ul class="nav justify-content-center">
        <!-- heading for web page -->
        <h2 style="color:#F7F052">View Orders</h2>
    </ul>

    <!-- order contents -->
    <div class="row">
        <!-- wide section for order table -->
        <div class="col-12">
            <div class="card-header"></div>
                <div class="text-light p-3"></div>
                    <ul class="nav justify-content-center"></ul>
                        <div class="card-body"></div>
                        <?php
                        //conduct query on order table
                        $order_query = mysqli_query($db, $order_sql);
                        ?>
                            <!-- creation of order table -->
                            <table class="table table-bordered table-dark">
                                <thead>
                                <tr class="bg-dark text-white text-center">
                                    <!-- headings for order table -->
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Order Total</th>
                                    <th>Order Status</th>
                                    <th>Order Details</th>
                                </tr>
                                </thead>
                            <?php
                                // rows for order table using a loop
                                if ($order_query) {
                                    foreach ($order_query as $row)
                                    {
                                ?>
                            <tbody class ="text-center">
                                <tr>
                                    <td> <?php echo $row['OrderID']; ?> </td>
                                    <td> <?php echo $row['Order_Date'];?> </td>
                                    <td> <?php echo $row['Order_Total']; ?> </td>
                                    <td> <?php echo $row['Order_Status']; ?> </td>
                                    <?php $orderid = $row['OrderID']; ?>
                                    <td> <a href="orderdetails.php?order=<?php echo $orderid ?>" class="text">Details</a> </td>
                                </tr>
                            </tbody>
                            <?php
                                    }
                                }
                                else{
                                    // if no orders were detected
                                    echo '<div class="alert alert-danger" role="alert">
                                            No orders were found
                                                </div>';
                                    }
                                ?>
                        </table>
                    </div>
                </div>
            </div>

    <?php
        //load footer Page
        include('footer.php');
    ?>