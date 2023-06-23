<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles/about.css?<?php echo time(); ?>">
    <title>About</title>
</head>

<body>
    <div class="header">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <!-- Brand -->
            <a class="navbar-brand" href="home.php"><b>Clicker</b></a>

            <!-- Links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="approved.php">Waiting/Approved</a>
                </li>
                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        More
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="change_password.php">Change Password</a>
                        <a class="dropdown-item" href="login.php">Logout</a>
                    </div>

                </li>
            </ul>
        </nav>
    </div>
    <div class="responsive-container-block bigContainer">
        <div class="responsive-container-block Container bottomContainer">
            <div class="allText bottomText">
                <p class="text-blk headingText">
                    About
                </p>
                <p class="text-blk subHeadingText">
                    Clicker and Us
                </p>
                <p class="text-blk description">
                    Our goal is to provide everyone a camera who needs it and cannot afford to buy it.
                    So here is what we have brought to you... a site to rent on cameras. The Website is designed by Ajay
                    and Ashish, we are college students who are intreseted in photography but cannot afford cameras as
                    they are expensive so we decided why not rent them, so there comes our idea and this website is the
                    outcome of that idea.
                </p>
                <p class="text-blk description" style="margin-bottom:10px;">
                    To know about us More, follow us on:
                </p>
                <a href="https://instagram.com/ajay_jaiswar_20" style="margin:10px;" class="me-4 link-secondary text-blk description">
                    <i class="fab fa-instagram"> Ajay Jaiswar</i>
                </a>
                <br>
                <a href="https://instagram.com/_ashish.5342_" style="margin:10px;" class="me-4 link-secondary text-blk description">
                    <i class="fab fa-instagram"> Ashish Gupta</i>
                </a>
                <br>
                <br>
                <a href="home.php">
                    <button class="explore">
                        Explore
                    </button>
                </a>
            </div>
            <div class="videoContainer">
                <img class="mainVideo" src="https://images.unsplash.com/photo-1598218674125-61de0837f8ab?ixid=MnwxMzcxOTN8MHwxfHNlYXJjaHwyfHxkc2xyfGVufDB8fHx8MTY0MjM1NDk3Mw&ixlib=rb-1.2.1&fm=jpg&w=3943&h=2957&fit=max">
                <img class="dotsImg image-block" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/cw3.svg">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/8b2513931f.js" crossorigin="anonymous"></script>

</body>


</html>