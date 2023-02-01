<?php

	//connect to database
	require('database.php');

	//load Header Page
	include('header.php');

    // retrieve user id from session values
    $userid = $_SESSION['userid'];

    //run query on database to gather product data for cart
    $billing_sql = "SELECT * FROM Billings WHERE UserID='$userid'";
    $billing_query = mysqli_query($db, $billing_sql);

    //check if any record of email and password exists in database
    if (mysqli_num_rows($billing_query) == 1) {
        // user already has billing information linked to their account
        $billingdetails = "present";
    }
    else {
        // user does not have any billing information
        $billingdetails = "absent";
    }

?>
<!-- core page content -->
<div class="container" style="background-color:#102E33;">
    <div class="row mt-3" style="position:relative; top:3px; left:5px;">
    <!-- heading for web page -->
        <h2 style="color:#F7F052">Your Cart</h2>
    </div>

    <?php
    //checking if cart session exists
    if(!empty($_SESSION['cart'])){

        //run query on database to gather product data for cart
        $cartdetailsql = "SELECT * FROM Products, Manufacturers WHERE Products.ManufacturerID=Manufacturers.ManufacturerID
                                                                    AND ProductID IN (";
            //create loop to gather ProductIDs from cart session
            foreach ($_SESSION['cart'] as $prodid => $value){
                $cartdetailsql .= $prodid . ',' ;
            }
        $cartdetailsql = substr($cartdetailsql, 0, -1). ") ORDER BY ProductID ASC";
        $cartdetailquery = mysqli_query($db, $cartdetailsql);


    ?>
    <!-- cart contents -->
    <div class="row">
        <!-- wide section for cart items -->
        <div class="col-9">
            <!-- begin loop for cart products -->
            <?php
                //initialize total variable
                $total = 0;

                //fetch values from cart
                while($cartrecord = mysqli_fetch_array($cartdetailquery, MYSQLI_ASSOC)){
                    //calculate subtotals and total
                    $subtotal = $_SESSION['cart'][$cartrecord['ProductID']]['quantity'] * $_SESSION['cart'][$cartrecord['ProductID']]['price'];
                    $total += $subtotal;

                    //defining variables for cart items
                    $img = $_SESSION['cart'][$cartrecord['ProductID']]['image'];
                    $name = $_SESSION['cart'][$cartrecord['ProductID']]['name'];
                    $price = $_SESSION['cart'][$cartrecord['ProductID']]['price'];
                    $quantity = $_SESSION['cart'][$cartrecord['ProductID']]['quantity'];
                    $stock = $cartrecord['Product_Quantity'];
                    $manu_name = $cartrecord['Manufacturer_Name'];
            ?>
            <!-- row for each product detail -->
            <div class="row text-bg-dark">
                <div class="col-2">
                <div><br></div>
                <!-- display product image -->
                <img src="images/products/<?php echo $img; ?>" class="img-fluid shadow rounded p-1 m-1">
                </div>
                <!-- display manufacturer name, product name, price and quantity -->
                <div class="col-5">
                    <div><br></div>
                    <h4><?php echo $manu_name ." ". $name; ?></h4>
                    <h6>Price: $<?php echo $price; ?></h6>
                    Amount: <input type="number" name="qty<?php echo[$cartrecord['ProductID']] ?>" value="<?php echo $quantity; ?>" min="0" max="<?php echo $stock; ?>">
                </div>
                <!-- display product subtotal -->
                <div class="col-3 text-center">
                    <div><br></div>
                    <h4> Subtotal</h4>
                    <h4 text-center> $<?php echo number_format($subtotal,2); ?></h4>
                </div>
                <div class="col-2">
                </div>
            </div>
            <?php
                }
            ?>
        </div>

        <!-- sidebar for order total and checkout -->
        <div class="col-3 text-bg-dark text-center">
            <div><br></div>
            <!-- display total -->
            <h4>Total</h4>
            <h4 text-center> $<?php echo number_format($total,2); ?></h4>

            <?php
            // proceed to checkout
            if ($billingdetails = "present"){
                ?>
                    <a href="checkout.php?total=<?php echo $total; ?>" class="btn btn-warning">Checkout</a>
                <?php
            }
            // provide billing information before checking out
            elseif ($billingdetails ="absent"){
                ?>
                    <a href="addbilling.php" class="btn btn-warning">Checkout</a>
                <?php
            }
            ?>
        </div>

    </div>
    <?php
    }
    //display cart is empty message
    else {
        echo "Your Cart is Empty";
    }

    ?>
</div>

<?php
    //load Footer Page
	include('footer.php');
?>