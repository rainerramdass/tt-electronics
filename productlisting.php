<?php

    //connect to database
    require('database.php');

    //start session for web page
    session_start();

    //retrieve session details
    $userid = $_SESSION['userid'];
    $firstname = $_SESSION['firstname'];
    $email = $_SESSION['email'];
    $user_type = $_SESSION['usertype'];

    //determine appropriate sql statement to execute based on sort or search
        //sorting products by sort button
        if(isset($_POST['sortButton'])){
            //create variables for each select list
            $field = $_POST['field'];
            $order = $_POST['order'];

            //create sql statement to incorporate sorting values
            $productsql = "SELECT * FROM Products, Manufacturers
            WHERE Products.ManufacturerID=Manufacturers.ManufacturerID
            ORDER BY ".$field." ".$order;
        }
        elseif(isset($_POST['searchButton'])){
            //create variable for search value
            $searchvalue = $_POST['search'];

            //create sql statement to incorporate search value
            $productsql = "SELECT * FROM Products
            WHERE Product_Name LIKE '%$searchvalue%'";

        }
        else {
            //default page with all products
            $productsql = "SELECT * FROM Products";
        }
?>

<html>
    <head>
            <!-- core admin generic content linking css, defining meta data-->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
            rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
            crossorigin="anonymous">

        </head>
        <body style="background-color:#98A6AA">
            <?php
            if ($user_type == "Customer"){ ?>
            <!-- navbar for Customer Usertype -->
                <nav class="navbar navbar-expand-xl" style="background-color:#102633">
                    <div class="container-fluid">
                        <div class="me-auto p-2"></div>
                        <a class="navbar-brand" style="color:white" href="#">TT Electronics</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDark" aria-controls="navbarDark" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarDark">
                        <ul class="navbar-nav me-auto mb-2 mb-xl-0">
                            <li class="nav-item">
                                <!-- link to product listing web page -->
                            <a class="nav-link active" style="color:white" aria-current="page" href="productlisting.php">Home</a>
                            </li>
                                <!-- dropdown menu for customers -->
                            <li class="nav-item dropdown">
                                <a class="nav-link active dropdown-toggle" style="color:white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Hi There <?= $firstname ?>!
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuDark">
                                    <!-- link to profile information web page -->
                                    <li><a class="dropdown-item" style="color:white" href="profileinfo.php">Profile Information</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <!-- link to logout -->
                                    <li><a class="dropdown-item" style="color:white" href="logout.php">Log Out</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <!-- link to cart webpage -->
                                <a class="nav-link active" style="color:white" aria-current="page" href="cart.php">Cart</a>
                            </li>
                            <li class="nav-item">
                                <!-- link to order webpage -->
                                <a class="nav-link active" style="color:white" aria-current="page" href="order.php">Orders</a>
                            </li>
                        </ul>
                    </div>
                    <div class="me-auto p-2"></div>
                </nav>
            <?php }
            elseif ($user_type == "Administrator") { ?>
                <!-- navbar for admin -->
                <nav class="navbar navbar-expand-xl" style="background-color:#102633">
                    <div class="container-fluid">
                        <div class="me-auto p-2"></div>
                        <a class="navbar-brand" style="color:white" href="#">TT Electronics</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDark" aria-controls="navbarDark" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarDark">
                        <ul class="navbar-nav me-auto mb-2 mb-xl-0">
                            <li class="nav-item">
                                <!-- link to product listing web page -->
                                <a class="nav-link active" style="color:white" aria-current="page" href="productlisting.php">Home</a>
                            </li>
                            <!-- dropdown menu for administrators -->
                            <li class="nav-item dropdown">
                                <a class="nav-link active dropdown-toggle" style="color:white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Hi There <?= $firstname ?>!
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuDark">
                                    <!-- link to profile information -->
                                    <li><a class="dropdown-item" style="color:white" href="profileinfo.php">Profile Information</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <!-- link to logout -->
                                    <li><a class="dropdown-item" style="color:white" href="logout.php">Log Out</a></li>
                                </ul>
                            </li>
                            <!-- dropdown menu for administrators only -->
                            <li class="nav-item dropdown">
                                <a class="nav-link active dropdown-toggle" style="color:white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin Functions
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuDark">
                                    <!-- link to add admins -->
                                    <li><a class="dropdown-item" style="color:white" href="addadmin.php">Add a Admin</a></li>
                                    <!-- link to add products -->
                                    <li><a class="dropdown-item" style="color:white" href="addproduct.php">Add a Product</a></li>
                                    <!-- link to view orders -->
                                    <li><a class="dropdown-item" style="color:white" href="order.php">View All Orders</a></li>
                                </ul>
                            </li>
                        </ul>
                        </div>
                    </div>
                    <div class="me-auto p-2"></div>
                </nav>
            <?php } ?>

            <!-- core page content -->
            <div class="container" style="background-color:#102E33;">
                <!-- heading for web page -->
                <h2 style="position:relative; top:5px; left:15px; color:#F7F052">Product Listing</h2>
                    <div class="row mt-4" style="position:relative; left:15px;">
                    <div class="col-7">
                        <!-- form action for product listing web page -->
                        <form action="productlisting.php" method="post" class="row">
                            <div class="col-4">
                                <!-- sort fields -->
                                <select class="form-select" name="field">
                                    <option value="Product_Quantity">Amount in Stock</option>
                                    <option value="Product_Category">Category</option>
                                    <option value="Manufacturer_Name">Manufacturer</option>
                                    <option value="Date_Manufactured">Manufacture Date</option>
                                    <option value="Product_CurrentCost">Price</option>
                                    <option value="Product_Name">Product Name</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <!-- additional sort fields -->
                                <select class="form-select" name="order">
                                    <option value="ASC">Ascending</option>
                                    <option value="DESC">Descending</option>
                                </select>
                            </div>
                            <!-- button to sort products -->
                            <div class="col-2" style="position:relative; top:3px;">
                                <input type="submit" class="btn btn-info btn-sm" value="Sort" name="sortButton" />
                            </div>
                        </form>
                    </div>
                    <div class="col-5">
                        <?php
                            //display search term and option to Clear Search
                            if(isset($_POST['searchButton']) && $_POST['search'] !== ''){
                                //capture search term
                                $searchvalue = $_POST['search'];

                                //display the search term and clear option
                        ?>
                                <form action="productlisting.php" method="post" class="row">
                                    <div class="col-7">
                                        <input class="form-control" type="search" name="search" placeholder="<?php echo $searchvalue ?>" />
                                    </div>
                                    <div class="col-5" style="position:relative; top:3px;">
                                        <!-- search button -->
                                        <input type="submit" class="btn btn-info btn-sm" value="Search" name="searchButton" />
                                        <!-- clear search button -->
                                        <a href="productlisting.php" class="btn btn-danger btn-sm">Clear</a>
                                    </div>
                                </form>
                        <?php
                            }
                        else {
                            //default search functionality
                        ?>
                        <!-- search functionality -->
                        <form action="productlisting.php" method="post" class="row g-2">
                            <div class="col-8">
                                <input class="form-control" type="search" name="search" placeholder="Search Products" />
                            </div>
                            <div class="col-4" style="position:relative; top:3px;">
                                <!-- search button -->
                                <input type="submit" class="btn btn-info btn-sm" value="Search" name="searchButton" />
                            </div>
                        </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="row">

                <!-- dynamically generating cards for database items -->
                <?php

                    //capturing all product data
                    $product_query = mysqli_query($db, $productsql);

                    //detecting products
                    if(mysqli_num_rows($product_query) > 0){

                        //create loop for results
                        while($results = mysqli_fetch_array($product_query, MYSQLI_ASSOC)){
                            //create variables for each database field item
                            $productid = $results['ProductID'];
                            $manuid = $results['ManufacturerID'];
                            $productname = $results['Product_Name'];
                            $productccost = $results['Product_CurrentCost'];
                            $productocost = $results['Product_OriginalCost'];
                            $productcat = $results['Product_Category'];
                            $productimage = $results['Product_Image'];
                            $producqty = $results['Product_Quantity'];
                            $productdatem = $results['Date_Manufactured'];


                            //determine whether product is in a current sale
                            if($productocost > $productccost){
                                $sale_status = 'success';
                                $salestatus = 'On Sale!';
                            }
                            else{
                                $sale_status = null;
                                $salestatus = null;
                            }

                            //query manufacturer name
                            $manufacturer_sql = "SELECT ManufacturerID, Manufacturer_Name FROM Manufacturers WHERE ManufacturerID = $manuid";
                            $manufacturer_query = mysqli_query($db, $manufacturer_sql);

                            //detecting manufacturer name
                            if(mysqli_num_rows($manufacturer_query) == 1){
                                $mresults = mysqli_fetch_array($manufacturer_query, MYSQLI_ASSOC);
                                //create variable for manufacturer name
                                $manu_name = $mresults['Manufacturer_Name'];
                            }
                            else{echo "Manufacturer not detected!";}

                            //display each record
                            ?>
                            <div class="card text-bg-dark text-center m-4" style="width: 22rem;">
                                <div><br></div>
                                <!-- display product image -->
                                <img src="images/products/<?php echo $productimage ?>" class="card-img-thumbnail" alt="images/alerts/file_notfound.png">
                                <div class="card-body">
                                    <!-- display manufacturer and product names -->
                                    <h5 class="card-title fw-bold"><?php echo $manu_name ?> <?php echo $productname ?></h5>
                                    <!-- display product category -->
                                    <span class="badge rounded-pill text-bg-primary">
                                        <?php echo $productcat; ?>
                                    </span>
                                    <!-- display sale status -->
                                    <span class="badge rounded-pill text-bg-<?php echo $sale_status; ?>">
                                        <?php echo $salestatus; ?>
                                    </span>
                                </div>
                                <ul class="list-group list-group-flush text-bg-dark">
                                    <li class="list-group-item text-bg-dark">
                                        <div class="row align-items-center">
                                            <!-- detect whether the current cost is less than original cost -->
                                            <?php if($productocost > $productccost){ ?>
                                                <!-- if cost is less than original -->
                                                <div class="col">Current Cost: $<?php echo $productccost ?> $<del><?php echo $productocost ?> </del></div>
                                            <?php }
                                            else{ ?>
                                                <!-- if cost is not less than original -->
                                                <div class="col">Current Cost: $<?php echo $productccost ?></div>
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <!-- display manufacturer date -->
                                    <li class="list-group-item text-bg-dark">Date Manufactured: <?php echo $productdatem ?></li>
                                    <!-- display product quantity -->
                                    <li class="list-group-item text-bg-dark">Amount in Stock: <?php echo $producqty ?></li>
                                </ul>
                                <div class="card-body">
                                    <!-- link to see product details -->
                                    <a href="productinfo.php?product=<?php echo $productid ?>" class="btn btn-primary">See Details</a>
                                </div>
                            </div>

                    <?php
                        }
                    }
                    else{

                        // no products were found
                    ?>
                    <div class="alert alert warning col-4 m-3" role="alert">
                        <?php echo "No products were found" ?>
                    </div>
                    <?php
                        }
                    ?>
                    </div>

<?php
	//load Footer Page
	include('footer.php');
?>