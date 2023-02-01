<?php

    //connect to database
    require('database.php');

    //load Header Page
	include('header.php');

    //retrieve user type from session data
    $user_type = $_SESSION['usertype'];

    //retrieve product details and specifications that user posted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //create variables for each product detail
        $scrtype = $_POST['add-scrtype'];
        $scrsize = $_POST['add-scrsize'];
        $cpu = $_POST['add-cpu'];
        $gpu = $_POST['add-gpu'];
        $stortype = $_POST['add-stortype'];
        $storsize = $_POST['add-storsize'];
        $memtype = $_POST['add-memtype'];
        $memsize = $_POST['add-memsize'];
        $os = $_POST['add-os'];
        $weight = $_POST['add-weight'];
        $colour = $_POST['add-colour'];

        //insert record into specifications table
        $addspecsql = "INSERT INTO Specifications (Screen_Size, Screen_Type, CPU, GPU, Storage_Size, Storage_Type, Memory_Size, Memory_Type, Operating_System, Weight, Colour)
                                                    VALUES ('$scrtype', '$scrsize', '$cpu', '$gpu', '$stortype', '$storsize', '$memtype', '$memsize','$os', '$weight', '$colour')";
        //contact database with specification insertion sql code
        $addspecquery = mysqli_query($db, $addspecsql);

        //if query was completed
        if($addspecquery){
            //retrieve specification id from recent query
            $specid = mysqli_insert_id($db);
            //create variables for each product detail
            $productname = $_POST['add-pname'];
            $productcost = $_POST['add-pcost'];
            $productcategory = $_POST['add-pcat'];
            $productimage = $_POST['prodimg'];
            $productquantity = $_POST['add-pqty'];
            $datemanufactured = $_POST['add-mdate'];
            $manu_name = $_POST['add-manu'];

            //query manufacturer name from manufacturer table
            $manufacturer_sql = "SELECT * FROM Manufacturers WHERE Manufacturer_Name= '$manu_name'";
            $manufacturer_query = mysqli_query($db, $manufacturer_sql);

                //detecting manufacturer name from manufacturer id
                if(mysqli_num_rows($manufacturer_query) == 1){
                    $mresults = mysqli_fetch_array($manufacturer_query, MYSQLI_ASSOC);
                    //create variable for manufacturer name
                    $manuid = $mresults['ManufacturerID'];

                    //insert record into product table
                    $addprodsql = "INSERT INTO Products (ManufacturerID, SpecificationID, Product_Name, Product_CurrentCost, Product_OriginalCost,  Product_Category, Product_Image, Product_Quantity, Date_Manufactured)
                                            VALUES ('$manuid', '$specid', '$productname', '$productcost', '$productcost', '$productcategory', '$productimage', '$productquantity','$datemanufactured')";
                    //contact database with product insertion sql code
                    $addprodquery = mysqli_query($db, $addprodsql);

                    //if query is completed
                        if($addprodquery){
                            // display query success message
                            echo '<div class="alert alert-success" role="alert">
                            New Product was successfully added!
                                </div>';
                        }
                        else{
                        //Query was unsuccessful, show warning
                            echo '<div class="alert alert-danger" role="alert">
                            Product was unable to be added!
                                </div>';
                        }
                    }
                    else{//Query was unsuccessful, show warning
                        echo '<div class="alert alert-danger" role="alert">
                                Manufacturer was not detected
                                    </div>';
                }
            }
        }


?>

<!-- core page content -->
<div class="container">

    <!-- add product modal -->
    <div class="container" style="position:relative; top:40px; background-color:#102E33;">
        <ul class="nav justify-content-center" style="position:relative; top:5px;">
            <h1 style="color:#F7F052">Add New Product</h1>
        </ul>
        <!-- add product grid -->
        <div class="row">
        <!-- form action for add product page -->
        <form action="addproduct.php" method="post">
            <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3" style="color:turquoise">
                                <!-- form field for manufacturer name -->
                                <label for="InputPName1" class="form-label">Manufacturer Name</label>
                                <input type="text" placeholder="Manufacturer Name" required
                                class="form-control" id="Inputmanu_name1"
                                aria-describedby="manu_nameHelp" name="add-manu">
                            </div>
                        </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-4">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's name -->
                                        <label for="InputPName1" class="form-label">Product Name</label>
                                        <input type="text" placeholder="Product Name"
                                        class="form-control" id="InputPName1"
                                        aria-describedby="pnameHelp" name="add-pname">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's category -->
                                        <label for="InputPCategory1" class="form-label">Product Category</label>
                                        <input type="text" placeholder="Product Category" required
                                        class="form-control" id="InputCat1"
                                        aria-describedby="pcatHelp" name="add-pcat">
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-4">
                                    <div class="mb-3" style="color:turquoise">
                                    <!-- form field for product's quantity -->
                                        <label for="InputPQuantity1" class="form-label">Product Quantity</label>
                                        <input type="text" placeholder="Product Quantity"
                                        class="form-control" id="InputPQuantity1"
                                        aria-describedby="pquantityHelp" name="add-pqty">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's cost -->
                                        <label for="InputPCost1" class="form-label">Product Cost</label>
                                        <input type="text" placeholder="000.00"
                                        class="form-control" id="InputPCost1"
                                        aria-describedby="pcostHelp" name="add-pcost">
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-4">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for manufacture date -->
                                        <label for="InputMDate1" class="form-label">Date Manufactured</label>
                                        <input type="text" placeholder="YYYY-MM-DD"
                                        class="form-control" id="InputMDate1"
                                        aria-describedby="mdateHelp" name="add-mdate">
                                    </div>
                                </div>
                            </div>
                            <h2 class="nav justify-content-center" style="color:#F7F052">Product Specifications</h2>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's screen size -->
                                        <label for="InputScrSize1" class="form-label">Screen Size</label>
                                        <input type="text" placeholder="Screen Size"
                                        class="form-control" id="InputScrSize1"
                                        aria-describedby="scrsizeHelp" name="add-scrsize">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for  product screen type -->
                                        <label for="InputScrType1" class="form-label">Screen Type</label>
                                        <input type="text" placeholder="Screen Type"
                                        class="form-control" id="InputScrType1"
                                        aria-describedby="scrtypeHelp" name="add-scrtype">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's operating system -->
                                        <label for="InputOpSys1" class="form-label">Operating System</label>
                                        <input type="text" placeholder="Operating System"
                                        class="form-control" id="InputOpSys1"
                                        aria-describedby="opsysHelp" name="add-os">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's cpu -->
                                        <label for="InputCPU1" class="form-label">CPU</label>
                                        <input type="text" placeholder="CPU"
                                        class="form-control" id="InputCPU1"
                                        aria-describedby="cpuHelp" name="add-cpu">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's gpu  -->
                                        <label for="InputGPU1" class="form-label">GPU</label>
                                        <input type="text" placeholder="GPU"
                                        class="form-control" id="InputGPU1"
                                        aria-describedby="gpuHelp" name="add-gpu">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's weight -->
                                        <label for="InputWeight1" class="form-label">Weight</label>
                                        <input type="text" placeholder="Weight"
                                        class="form-control" id="InputWeight1"
                                        aria-describedby="weightHelp" name="add-weight">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's storage size -->
                                        <label for="InputStorSize1" class="form-label">Storage Size</label>
                                        <input type="text" placeholder="Storage Size"
                                        class="form-control" id="InputStorSize1"
                                        aria-describedby="storsizeHelp" name="add-storsize">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's storage type-->
                                        <label for="InputStorType1" class="form-label">Storage Type</label>
                                        <input type="text" placeholder="Storage Type"
                                        class="form-control" id="InputStorType1"
                                        aria-describedby="stortypeHelp" name="add-stortype">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's colour -->
                                        <label for="InputColour1" class="form-label">Colour</label>
                                        <input type="text" placeholder="Colour"
                                        class="form-control" id="InputColour1"
                                        aria-describedby="colourHelp" name="add-colour">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's memory size  -->
                                        <label for="InputMemSize1" class="form-label">Memory Size</label>
                                        <input type="text" placeholder="Memory Size"
                                        class="form-control" id="InputMemSize1"
                                        aria-describedby="memsizeHelp" name="add-memsize">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's memory type -->
                                        <label for="InputMemType1" class="form-label">Memory Type</label>
                                        <input type="text" placeholder="Memory Type"
                                        class="form-control" id="InputMemType1"
                                        aria-describedby="memtypeHelp" name="add-memtype">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="mb-3" style="color:turquoise">
                                        <!-- form field for product's image -->
                                        <label for="InputProdImage1" class="form-label">Product Image</label>
                                        <input type="file" class="form-control" name="prodimg" accept="image/*" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2></h2>
                    <!-- button to complete product addition -->
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