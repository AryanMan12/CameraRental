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
    <link rel="stylesheet" href="../assets/styles/home.css?<?php echo time(); ?>">
    <title>Home</title>
</head>

<body>
    <div class="main">
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
        <div class="main_body">
            <div class="category">
                <ul class="nav nav-tabs">
                    <li class='nav-item'>
                        <form method='post'><input type='hidden' name='btn_name' value='All' /><button type="submit"
                                name="change_btn" class='nav-link'>All</button></form>
                    </li>
                    <?php
                    include "global.php";
                    $con = mysqli_connect($server, $username, $password, $database);
                    if (!$con) {
                        echo "Not connected";
                    }
                    $sql3 = "SELECT * FROM category_info";
                    $query = mysqli_query($con, $sql3);
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<li class='nav-item'><form method='post'><input type='hidden' name='btn_name' value={$row['category_name']} /><button class='nav-link' type='submit' name='change_btn'>{$row['category_name']}</button></form></li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="page_info">
                <?php
                include "global.php";
                $con = mysqli_connect($server, $username, $password, $database);
                if (!$con) {
                    echo "Not connected";
                }
                $sql3 = "SELECT * FROM item_info";
                if (isset($_POST['change_btn'])) {
                    $changeTo = $_POST['btn_name'];
                    if ($changeTo == "All") {
                        $sql3 = "SELECT * FROM item_info";
                    } else {
                        $sql3 = "SELECT * FROM item_info WHERE item_category='{$changeTo}'";
                    }
                }

                $query = mysqli_query($con, $sql3);
                if (mysqli_num_rows($query) == 0) {
                    echo "<h1>No items in this Category Yet!</h1>";
                }
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<div class='card' style='width:270px'>";
                    echo "<img class='card-img-top' src={$row['item_image']} alt='Card image'>";
                    echo "<div class='card-body'>";
                    echo "<h4 class='card-title'>{$row['item_name']}</h4>";
                    echo "<p class='card-text'>{$row['item_category']}</p>";
                    echo "<h5 class='card-text'>Rs {$row['price']} per hr</h5>";
                    echo "<form method='post'><input type='hidden' name='btn_name_val' value={$row['item_name']} /><button id={$row['item_name']} name='add_to_cart' type='submit' class='btn btn-primary'>Cart</button>";
                    echo "<a href='order.php?orderedItem={$row['item_name']}&orderedPrice={$row['price']}' class='btn btn-primary'>Order</a></form>";
                    echo "</div></div>";
                }
                ?>
            </div>
        </div>
        <div class="footer">

            <footer class="text-center text-lg-start bg-white text-muted">

                <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom"
                    style="background-color: rgba(0, 0, 0, 0.025);">

                    <div class=" me-5 d-none d-lg-block">
                        <span>Get connected with us on social networks:</span>
                    </div>



                    <div>
                        <a href="https://twitter.com" class="me-4 link-secondary">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=ajayjaiswar669@gmail.com"
                            class="me-4 link-secondary">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="https://instagram.com/ajay_jaiswar_20" class="me-4 link-secondary">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://linkedin.com" class="me-4 link-secondary">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>

                </section>

                <section class="">
                    <div class="container text-center text-md-start mt-5">

                        <div class="row mt-3">

                            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

                                <h6 class="text-uppercase fw-bold mb-4">
                                    <b>Clicker</b>
                                </h6>
                                <p>
                                    Our goal is to provide everyone a camera who needs it and cannot afford to buy it.
                                    So here is what we have brought to you... a site to rent on cameras.
                                </p>
                            </div>

                            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

                                <h6 class="text-uppercase fw-bold mb-4">
                                    <b>Want to know More?</b>
                                </h6>
                                <p>
                                    <a href="home.php" class="text-reset">Home</a>
                                </p>
                                <p>
                                    <a href="about_us.php" class="text-reset">About Us</a>
                                </p>
                            </div>

                            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

                                <h6 class="text-uppercase fw-bold mb-4"><b>Contact Ajay</b></h6>
                                <p><i class="fas fa-home me-3 text-secondary"></i> Ghatkopar, Mumbai</p>
                                <p>
                                    <i class="fas fa-envelope me-3 text-secondary"></i>
                                    ajayjaiswar669@gmail.com
                                </p>
                                <p><i class="fas fa-phone me-3 text-secondary"></i> +91 93214 46340</p>
                                <p><i class="fab fa-instagram"></i> @ajay_jaiswar_20</p>
                            </div>

                            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

                                <h6 class="text-uppercase fw-bold mb-4"><b>Contact Ashish</b></h6>
                                <p><i class="fas fa-home me-3 text-secondary"></i> Kanjur Marg, Mumbai</p>
                                <p>
                                    <i class="fas fa-envelope me-3 text-secondary"></i>
                                    ashishgupta.sign@gmail.com
                                </p>
                                <p><i class="fas fa-phone me-3 text-secondary"></i> +91 89280 91443</p>
                                <p><i class="fab fa-instagram"></i> @_ashish.5342_</p>
                            </div>

                        </div>

                    </div>
                </section>

                <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.025);">
                    © 2023 Copyright:
                    <a class="text-reset fw-bold" href="#">Clicker.com</a>
                </div>

            </footer>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/8b2513931f.js" crossorigin="anonymous"></script>


</body>

</html>

<?php
include 'global.php';
if (isset($_POST['add_to_cart'])) {
    addToCart();
}

function addToCart()
{
    include "global.php";
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $uName = $_SESSION['username'];
    $prod_name = $_POST["btn_name_val"];
    echo "$prod_name";
    $sql1 = "SELECT * FROM cart_info WHERE prod_name = '$prod_name' AND user_name = '$uName'";
    $query = mysqli_query($con, $sql1);
    if ($query->num_rows > 0) {
        $sql2 = "DELETE FROM cart_info WHERE prod_name = '$prod_name' AND user_name = '$uName' ";
        $query = mysqli_query($con, $sql2);
        echo "<script>{$prod_name}.innerHTML = 'Cart';
        {$prod_name}.style.backgroundColor = '#007bff';</script>";
    } else {
        $sql3 = $con->prepare("INSERT INTO cart_info (`prod_name`, `user_name`) VALUES (?,?)");
        $sql3->bind_param("ss", $prod_name, $uName);
        $sql3->execute();
        echo "<script>{$prod_name}.innerHTML = 'Added';
        {$prod_name}.style.backgroundColor = 'green'; </script>";
    }
}
?>