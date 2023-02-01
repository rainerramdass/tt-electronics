<?php

    //connect to database
    require('database.php');

    //capture parameter in variable
    $parameter = $_REQUEST['product'];

    //retrieve product id from parameter
    $_SESSION['product'] = $parameter;

    //load Header Page
	include('header.php');

    //capturing all product data
    $product_sql = "SELECT * FROM Products WHERE ProductID =$parameter";
    $product_query = mysqli_query($db, $product_sql);

    //detecting products
    if (mysqli_num_rows($product_query) > 0) {

        //fetch product results
        $prod_results = mysqli_fetch_array($product_query, MYSQLI_ASSOC);
        //create variables for each database field item
        $productid = $prod_results['ProductID'];
    }
?>

<!-- core page content -->
<div class="container mx-auto" style="position:relative; top:25px; background-color:#102E33;">
    <h1 style="position:relative; top:5px; color:#F7F052">Product Information</h1>

    <!-- view product information -->
    <div class="row">


    <?php
        //capturing all product data
        $product_sql = "SELECT * FROM Products WHERE ProductID =$parameter";

        //contact database with sql statement
        $product_query = mysqli_query($db, $product_sql);

        //detecting products
        if(mysqli_num_rows($product_query) > 0){

            //create loop for results
            $prod_results = mysqli_fetch_array($product_query, MYSQLI_ASSOC);

                //create variables for each database field item
                $productid = $prod_results['ProductID'];
                $manuid = $prod_results['ManufacturerID'];
                $specid = $prod_results['SpecificationID'];
                $productname = $prod_results['Product_Name'];
                $productccost = $prod_results['Product_CurrentCost'];
                $productocost = $prod_results['Product_OriginalCost'];
                $productcat = $prod_results['Product_Category'];
                $productimage = $prod_results['Product_Image'];
                $productqty = $prod_results['Product_Quantity'];
                $productdatem = $prod_results['Date_Manufactured'];
                $_SESSION['productid'] = $prod_results['ProductID'];

                //determine whether product is in a current sale
                if($productocost > $productccost){
                    $sale = 'success';
                    $salestatus = 'On Sale!';
                }
                else{
                    $sale = null;
                    $salestatus = null;
                }

                //query manufacturer name
                $manufacturer_sql = "SELECT * FROM Manufacturers WHERE ManufacturerID = '$manuid'";
                $manufacturer_query = mysqli_query($db, $manufacturer_sql);

                //detecting manufacturer name
                if(mysqli_num_rows($manufacturer_query) == 1){
                    $mresults = mysqli_fetch_array($manufacturer_query, MYSQLI_ASSOC);
                    //create variable for manufacturer name
                    $manu_name = $mresults['Manufacturer_Name'];
                    $manu_email = $mresults['Manufacturer_Email'];
                    $manu_phone = $mresults['Manufacturer_PhoneNumber'];
                    $manu_location = $mresults['Manufacturer_Location'];
                }
                else{echo "Manufacturer not detected!";}

                //detecting product specifications
                $specification_sql = "SELECT * FROM Specifications WHERE SpecificationID = '$specid'";
                $specification_query = mysqli_query($db, $specification_sql);

                //detecting manufacturer name
                if(mysqli_num_rows($specification_query) == 1){
                    $sresults = mysqli_fetch_array($specification_query, MYSQLI_ASSOC);
                    //create variables for specification details
                    $spec_id = $sresults['SpecificationID'];
                    $spec_scrsize = $sresults['Screen_Size'];
                    $spec_scrtype = $sresults['Screen_Type'];
                    $spec_cpu = $sresults['CPU'];
                    $spec_gpu = $sresults['GPU'];
                    $spec_stosize = $sresults['Storage_Size'];
                    $spec_stotype = $sresults['Storage_Type'];
                    $spec_memsize = $sresults['Memory_Size'];
                    $spec_memtype = $sresults['Memory_Type'];
                    $spec_os = $sresults['Operating_System'];
                    $spec_weight = $sresults['Weight'];
                    $spec_colour = $sresults['Colour'];
                }
                else{echo "Specifications were not detected!";}
        ?>

                <!-- creating card for product information -->
                <div class="card mb-4 text-bg-dark" style="width: 120rem;">
                    <div class="row g-0">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <div><br></div>
                            <img src="images/products/<?php echo $productimage ?>" class="img-fluid rounded-start"
                            alt="images/alerts/file_notfound.png">
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <div class="card-body text-bg-dark">
                                <!-- display manufacturer and product names -->
                                <h2 class="card-title text-center fw-bold"><?php echo $manu_name ?> <?php echo $productname ?></h2>
                                <ul class="list text-center" style="font-size:12px" >
                                    <!-- display whether item is on sale -->
                                    <span class="badge rounded-pill text-bg-<?php echo $sale; ?>">
                                                                            <?php echo $salestatus; ?>
                                    </span>
                                </ul>
                                <ul class="list-group list-group-flush text-bg-dark" style="font-size:16px">
                                    <!-- display product cost and detect whether the current cost is less than original cost -->
                                    <?php if($productocost > $productccost){ ?>
                                        <!-- if cost is less than original -->
                                        <li class="list-group-item text-bg-dark"><b>Price: </b>$<?php echo $productccost ?>  $<del><?php echo $productocost ?> </del></li>
                                    <?php }
                                    else{ ?>
                                        <!-- if cost is not less than original -->
                                        <li class="list-group-item text-bg-dark"><b>Price: </b>$<?php echo $productccost ?></li>
                                    <?php } ?>
                                    <!-- display product category -->
                                    <li class="list-group-item text-bg-dark"><b>Product Category: </b><?php echo $productcat ?></li>
                                    <!-- display manufacture date -->
                                    <li class="list-group-item text-bg-dark"><b>Date Manufactured: </b><?php echo $productdatem ?></li>
                                    <!-- display product quantity value -->
                                    <li class="list-group-item text-bg-dark"><b>Amount in Stock: </b><?php echo $productqty ?></li>
                                </ul>

                                <!-- if user is a customer -->
                                <?php if($user_type == "Customer"){
                                    // if product has one or more in stock
                                    if ($productqty  > 0){ ?>
                                        <div class="card-body text-center" style="font-size:12px">
                                            <!-- link to add to cart -->
                                            <a href="addtocart.php?id=<?php echo $productid; ?>" class="btn btn-primary">Add to Cart</a>
                                            <!-- Manufacturer button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manufacturerModal">
                                                Manufacturer Information
                                            </button>
                                        </div>
                                    <?php }
                                    // if there is no product in stock
                                    else{ ?>
                                        <div class="card-body text-center" style="font-size:12px">
                                            <!-- button displaying product is not in stock -->
                                            <a href="#" class="btn btn-danger">Product is Unavailable</a>
                                            <!-- Manufacturer button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manufacturerModal">
                                                Manufacturer Information
                                            </button>
                                        </div>
                                    <?php }
                                }
                                // if user is an administrator
                                elseif($user_type == "Administrator"){?>
                                    <div class="card-body text-center" style="font-size:12px">
                                        <!-- link to edit product information -->
                                        <a href="editproductinfo.php?product=<?php echo $productid ?>" class="btn btn-primary">Edit Product Details</a>
                                        <!-- Manufacturer button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manufacturerModal">
                                        Manufacturer Information
                                        </button>
                                    </div>
                                <?php } ?>


                                <!-- Manufacturer Modal -->
                                <div class="modal fade" id="manufacturerModal" tabindex="-1" aria-labelledby="manufacturerModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content text-bg-dark">
                                            <div class="modal-header">
                                                <!-- display heading for modal -->
                                                <h1 class="modal-title fs-5" id="ModalLabel">Manufacturer Information</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card text-bg-dark" style="width: 36rem;">
                                                    <div class="card-body text-center">
                                                        <!-- display manufacturer name -->
                                                        <h2 class="card-title text-center fw-bold"><?php echo $manu_name ?></h2>
                                                        <ul class="list-group list-group-flush text-bg-dark" style="font-size:16px">
                                                            <!-- display manufacturer email -->
                                                            <li class="list-group-item text-bg-dark"><b>Email Address: </b><?php echo $manu_email ?></li>
                                                            <!-- display manufacturer phone number -->
                                                            <li class="list-group-item text-bg-dark"><b>Phone Number: </b><?php echo $manu_phone ?></li>
                                                            <!-- display manufacturer location -->
                                                            <li class="list-group-item text-bg-dark"><b>Location: </b><?php echo $manu_location ?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- display modal close button -->
                                            <div class="modal-footer text-center">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                <p></p>
                <p></p>
                <!-- display card with product specifications -->
                <div class="card mb-4 text-bg-dark" style="width: 120rem;">
                    <div class="row g-0">
                        <div class="col-md-12">
                            <div class="card-body">
                                <!-- card heading -->
                                <h2 class="card-title text-center fw-bold text-bg-dark">Product Specifications</h2>
                                <table class="table table-bordered text-center text-bg-dark">
                                    <thead>
                                        <tr>
                                            <!-- table headings -->
                                            <th>Screen</th>
                                            <th>CPU</th>
                                            <th>GPU</th>
                                            <th>Storage</th>
                                            <th>Memory</th>
                                            <th>Operating System</th>
                                            <th>Weight</th>
                                            <th>Colour</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!-- table rows -->
                                            <td><?php echo $spec_scrsize?>" <?php echo $spec_scrtype?></td>
                                            <td><?php echo $spec_cpu ?></td>
                                            <td><?php echo $spec_gpu ?></td>
                                            <td><?php echo $spec_stosize ?> <?php echo $spec_stotype?></td>
                                            <td><?php echo $spec_memsize ?> <?php echo $spec_memtype?></td>
                                            <td><?php echo $spec_os ?></td>
                                            <td><?php echo $spec_weight ?> Pounds</td>
                                            <td><?php echo $spec_colour ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
</div>

<?php
    //load Footer Page
	include('footer.php');
?>
