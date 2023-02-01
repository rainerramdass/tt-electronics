<?php

	//start session
	session_start();

	//connect to database
	require('database.php');

	//load Header Page
	include('header.php');

    //capture product id to add to cart
    $parameter = $_REQUEST['id'];

    //retrieve product info using id for cart
    $productsql = "SELECT * FROM Products WHERE ProductID='$parameter'";
    $productquery = mysqli_query($db, $productsql);

    //check if the query has a result
    if(mysqli_num_rows($productquery) > 0){
        $record = mysqli_fetch_array($productquery, MYSQLI_ASSOC);

        //creating variables for product to add to cart
        $prodid = $record['ProductID'];
        $prodname = $record['Product_Name'];
        $prodprice = $record['Product_CurrentCost'];
        $prodimg = $record['Product_Image'];

        //check if product is not in cart session
        if(!isset($_SESSION['cart'][$prodid])){
            //create cart and cart fields for first of the product
            $_SESSION['cart'][$prodid] = array('name' => $prodname, 'price' => $prodprice, 'image'=> $prodimg, 'quantity' => 1);

            //printing success notification
            echo "Success, ".$prodname." has now been added to your cart!";

            //redirect to Cart
            header('Location: cart.php');
            return;
        }
        else {
            //update quantity by adding another one for existing product in cart
            $_SESSION['cart'][$prodid]['quantity']++;

            //redirect to Cart
            header('Location: cart.php');
            return;
        }
    }
    else {
        // show error message
        echo "No product added since no product was found";
    }


?>