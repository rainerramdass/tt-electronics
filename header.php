<?php
    // start of session with user details
    session_start();

    $userid = $_SESSION['userid'];
    $firstname = $_SESSION['firstname'];
    $email = $_SESSION['email'];
    $user_type = $_SESSION['usertype'];
?>

<html>
    <head>
            <!-- core admin generic content linking css, defining meta data-->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
            rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
            crossorigin="anonymous">
    </head>
        <!-- body of header -->
        <body style="background-color:#98A6AA">
            <?php
            // if detect user is a customer
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
                                    <!-- menu displaying links available to customer -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link active dropdown-toggle" style="color:white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Hi There <?= $firstname ?>!
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuDark">
                                        <!-- link to user's profile information -->
                                        <li><a class="dropdown-item" style="color:white" href="profileinfo.php">Profile Information</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <!-- link to logout -->
                                        <li><a class="dropdown-item" style="color:white" href="logout.php">Log Out</a></li>
                                    </ul>
                                </li>
                                <!-- link to cart -->
                                <li class="nav-item">
                                    <a class="nav-link active" style="color:white" aria-current="page" href="cart.php">Cart</a>
                                </li>
                                <!-- link to order list -->
                                <li class="nav-item">
                                    <a class="nav-link active" style="color:white" aria-current="page" href="order.php">Orders</a>
                                </li>
                            </ul>
                        </div>
                        <div class="me-auto p-2"></div>
                    </nav>
                <?php }
                // if system detects user is an admin
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
                                    <!-- link to product listing -->
                                    <a class="nav-link active" style="color:white" aria-current="page" href="productlisting.php">Home</a>
                                </li>
                                <!-- menu available to admins -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link active dropdown-toggle" style="color:white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Hi There <?= $firstname ?>!
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuDark">
                                        <!-- link to profile information -->
                                        <li><a class="dropdown-item" style="color:white" href="profileinfo.php">Profile Information</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <!-- link to log out -->
                                        <li><a class="dropdown-item" style="color:white" href="logout.php">Log Out</a></li>
                                    </ul>
                                </li>
                                <!-- link to admin only features -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link active dropdown-toggle" style="color:white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Admin Functions
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuDark">
                                        <!-- link to add admin web page -->
                                        <li><a class="dropdown-item" style="color:white" href="addadmin.php">Add a Admin</a></li>
                                        <!-- link to add product web page -->
                                        <li><a class="dropdown-item" style="color:white" href="addproduct.php">Add a Product</a></li>
                                        <!-- link to view orders web page -->
                                        <li><a class="dropdown-item" style="color:white" href="order.php">View All Orders</a></li>
                                    </ul>
                                </li>
                            </ul>
                            </div>
                        </div>
                        <div class="me-auto p-2"></div>
                    </nav>
                <?php } ?>