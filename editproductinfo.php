<?php

    //connect to database
    require('database.php');

    //load Header Page
	include('header.php');

    //retrieve session details
    $user_type = $_SESSION['usertype'];
    $parameter = $_SESSION['productid'];


    //capturing all product data from database
    $product_sql = "SELECT * FROM Products, Manufacturers WHERE ProductID =$parameter
                    AND Products.ManufacturerID=Manufacturers.ManufacturerID";
    $product_query = mysqli_query($db, $product_sql);

    //detecting products
    if(mysqli_num_rows($product_query) > 0){

        //fetch product details
        $prod_results = mysqli_fetch_array($product_query, MYSQLI_ASSOC);

            //create variables for each product detail
            $productid = $prod_results['ProductID'];
            $manuid = $prod_results['ManufacturerID'];
            $specid = $prod_results['SpecificationID'];
            $productname = $prod_results['Product_Name'];
            $manuname = $prod_results['Manufacturer_Name'];
            $productccost = $prod_results['Product_CurrentCost'];
            $productocost = $prod_results['Product_OriginalCost'];
            $productcat = $prod_results['Product_Category'];
            $productqty = $prod_results['Product_Quantity'];
            $productdatem = $prod_results['Date_Manufactured'];
            $_SESSION['productID'] = $prod_results['ProductID'];
        }
        else{echo "Product was not detected!";}

            //detecting product specifications
            $specification_sql = "SELECT * FROM Specifications WHERE SpecificationID = $specid";
            $specification_query = mysqli_query($db, $specification_sql);

            //confirm if specification id is valid
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

            //save values that was posted by user
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //create variables for each product detail
                $update_scrtype = $_POST['update-scrtype'];
                $update_scrsize = $_POST['update-scrsize'];
                $update_cpu = $_POST['update-cpu'];
                $update_gpu = $_POST['update-gpu'];
                $update_stortype = $_POST['update-stortype'];
                $update_storsize = $_POST['update-storsize'];
                $update_memtype = $_POST['update-memtype'];
                $update_memsize = $_POST['update-memsize'];
                $update_os = $_POST['update-os'];
                $update_weight = $_POST['update-weight'];
                $update_colour = $_POST['update-colour'];
                $update_productname = $_POST['update-pname'];
                $update_productcost = $_POST['update-pcost'];
                $update_productcategory = $_POST['update-pcat'];
                $update_productquantity = $_POST['update-pqty'];
                $update_datemanufactured = $_POST['update-mdate'];
                $update_manuname = $_POST['update-manu'];

                //query manufacturer name
                $manufacturer_sql = "SELECT * FROM Manufacturers WHERE Manufacturer_Name= '$update_manuname'";
                $manufacturer_query = mysqli_query($db, $manufacturer_sql);

                    //detecting manufacturer name
                    if(mysqli_num_rows($manufacturer_query) == 1){
                        $mresults = mysqli_fetch_array($manufacturer_query, MYSQLI_ASSOC);
                        //create variable for manufacturer id
                        $update_manuid = $mresults['ManufacturerID'];
                    }

                    //insert update SQL details and database query to execute
                    $spec_sql = "UPDATE Specifications
                                    SET Screen_Size='$update_scrsize',
                                        Screen_Type='$update_scrtype',
                                        CPU='$update_cpu',
                                        GPU='$update_gpu',
                                        Storage_Size='$update_storsize',
                                        Storage_Type='$update_stortype',
                                        Memory_Size='$update_memsize',
                                        Memory_Type='$update_memtype',
                                        Operating_System='$update_os',
                                        Weight='$update_weight',
                                        Colour='$update_colour'
                                    WHERE SpecificationID=$spec_id";
                    //execute query
                    $spec_query = mysqli_query($db, $spec_sql);

                    //if query was valid
                    if($spec_query){
                        // display confirmation message
                        echo '<div class="alert alert-success" role="alert">
                            Product Specifications were successfully updated!
                            </div>';
                    }
                    else{
                        echo '<div class="alert alert-danger" role="alert">
                            Product information was not updated!
                                </div>';
                    }

                    //insert update SQL details and database query to execute
                    $prod_sql = "UPDATE Products
                                    SET ManufacturerID ='$update_manuid',
                                        Product_Name='$update_productname',
                                        Product_CurrentCost='$update_productcost',
                                        Product_Category='$update_productcategory',
                                        Product_Quantity='$update_productquantity',
                                        Date_Manufactured='$update_datemanufactured'
                                    WHERE ProductID=$productid";
                    //execute query
                    $prod_query = mysqli_query($db, $prod_sql);

                    //if query was successful
                    if($prod_query){
                        echo '<div class="alert alert-success" role="alert">
                            Product Details were successfully updated!
                            </div>';
                    }
                    else{
                        echo '<div class="alert alert-danger" role="alert">
                            Product information was not updated!
                                </div>';
                    }
            }


?>

<!-- core page content -->
<div class="container">
    <div class="container" style="position:relative; top:40px; background-color:#102E33;">
        <ul class="nav justify-content-center" style="position:relative; top:5px;">
            <!-- heading for web page -->
            <h1 style="color:#F7F052">Edit Product Information</h1>
        </ul>
        <!-- edit product grid -->
        <div class="row">
        <!-- form action for add product web page -->
        <form action="editproductinfo.php" method="post">
            <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3" style="color:turquoise">
                                <!-- form field for manufacturer name -->
                                <label for="InputPName1" class="form-label">Manufacturer Name</label>
                                <input type="text" value="<?php echo $manuname ?>"
                                class="form-control" id="Inputmanu_name1"
                                aria-describedby="manu_nameHelp" name="update-manu">
                            </div>
                        </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-4">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product name -->
                                        <label for="InputPName1" class="form-label">Product Name</label>
                                        <input type="text" value="<?php echo $productname ?>"
                                        class="form-control" id="InputPName1"
                                        aria-describedby="pnameHelp" name="update-pname">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product category -->
                                        <label for="InputPCategory1" class="form-label">Product Category</label>
                                        <input type="text" value="<?php echo $productcat ?>"
                                        class="form-control" id="InputCat1"
                                        aria-describedby="pcatHelp" name="update-pcat">
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-4">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product quantity -->
                                        <label for="InputPQuantity1" class="form-label">Product Quantity</label>
                                        <input type="text" value="<?php echo $productqty ?>"
                                        class="form-control" id="InputPQuantity1"
                                        aria-describedby="pquantityHelp" name="update-pqty">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for current product cost -->
                                        <label for="InputPCost1" class="form-label">Product Current Cost</label>
                                        <input type="text" value="<?php echo $productccost ?>"
                                        class="form-control" id="InputPCost1"
                                        aria-describedby="pcostHelp" name="update-pcost">
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-4">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for manufacture date -->
                                        <label for="InputMDate1" class="form-label">Date Manufactured</label>
                                        <input type="text" value="<?php echo $productdatem ?>"
                                        class="form-control" id="InputMDate1"
                                        aria-describedby="mdateHelp" name="update-mdate">
                                    </div>
                                </div>
                            </div>
                            <!-- sub-heading for web page -->
                            <h2 class="nav justify-content-center" style="color:#F7F052">Product Specifications</h2>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product screen size -->
                                        <label for="InputScrSize1" class="form-label">Screen Size</label>
                                        <input type="text" value="<?php echo $spec_scrsize ?>"
                                        class="form-control" id="InputScrSize1"
                                        aria-describedby="scrsizeHelp" name="update-scrsize">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product screen type -->
                                        <label for="InputScrType1" class="form-label">Screen Type</label>
                                        <input type="text" value="<?php echo $spec_scrtype?>"
                                        class="form-control" id="InputScrType1"
                                        aria-describedby="scrtypeHelp" name="update-scrtype">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product operating system -->
                                        <label for="InputOpSys1" class="form-label">Operating System</label>
                                        <input type="text" value="<?php echo $spec_os ?>"
                                        class="form-control" id="InputOpSys1"
                                        aria-describedby="opsysHelp" name="update-os">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product cpu -->
                                        <label for="InputCPU1" class="form-label">CPU</label>
                                        <input type="text" value="<?php echo $spec_cpu ?>"
                                        class="form-control" id="InputCPU1"
                                        aria-describedby="cpuHelp" name="update-cpu">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product gpu -->
                                        <label for="InputGPU1" class="form-label">GPU</label>
                                        <input type="text" value="<?php echo $spec_gpu ?>"
                                        class="form-control" id="InputGPU1"
                                        aria-describedby="gpuHelp" name="update-gpu">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product weight -->
                                        <label for="InputWeight1" class="form-label">Weight</label>
                                        <input type="text" value="<?php echo $spec_weight ?>"
                                        class="form-control" id="InputWeight1"
                                        aria-describedby="weightHelp" name="update-weight">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product storage size -->
                                        <label for="InputStorSize1" class="form-label">Storage Size</label>
                                        <input type="text" value="<?php echo $spec_stosize ?>"
                                        class="form-control" id="InputStorSize1"
                                        aria-describedby="storsizeHelp" name="update-storsize">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product storage type -->
                                        <label for="InputStorType1" class="form-label">Storage Type</label>
                                        <input type="text" value="<?php echo $spec_stotype ?>"
                                        class="form-control" id="InputStorType1"
                                        aria-describedby="stortypeHelp" name="update-stortype">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product colour -->
                                        <label for="InputColour1" class="form-label">Colour</label>
                                        <input type="text" value="<?php echo $spec_colour ?>"
                                        class="form-control" id="InputColour1"
                                        aria-describedby="colourHelp" name="update-colour">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product memory size -->
                                        <label for="InputMemSize1" class="form-label">Memory Size</label>
                                        <input type="text" value="<?php echo $spec_memsize ?>"
                                        class="form-control" id="InputMemSize1"
                                        aria-describedby="memsizeHelp" name="update-memsize">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product memory type -->
                                        <label for="InputMemType1" class="form-label">Memory Type</label>
                                        <input type="text" value="<?php echo $spec_memtype ?>"
                                        class="form-control" id="InputMemType1"
                                        aria-describedby="memtypeHelp" name="update-memtype">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product image -->
                                        <label for="InputProdImage1" class="form-label">Product Image</label>
                                        <input type="file" class="form-control" name="prodimg" accept="image/*" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2></h2>
                    <!-- button to complete update of product details -->
                    <div class="row">
                        <button type="submit" name="submit" class="btn btn-success">Finish</button>
                    </div>
                    </div>
                </div>
            </div>
            </form>
        </div>

<?php
	//load Footer Page
	include('footer.php');
?>