<?php
session_start();
$_SESSION['isStudent'] = 'true';

$uName = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles/approved.css?<?php echo time(); ?>">
    <title>Waiting/Approved</title>
</head>


<body>
    <div class="main">
        <div class="header">

            <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
                <!-- Brand -->
                <a class="navbar-brand" href="home.php">Clicker</a>

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
                        <form method='post'><input type='hidden' name='btn_name' value='Waiting' /><button type="submit"
                                name="change_btn" class='nav-link'>Waiting</button></form>
                    </li>
                    <li class='nav-item'>
                        <form method='post'><input type='hidden' name='btn_name' value='Approved' /><button
                                type="submit" name="change_btn" class='nav-link'>Approved</button></form>
                    </li>
                </ul>
            </div>
            <div class="page_info">
                <?php
                include "global.php";
                $con = mysqli_connect($server, $username, $password, $database);
                if (!$con) {
                    echo "Not connected";
                }
                $sql3 = "SELECT * FROM booking_info WHERE client_name='{$uName}'";
                $btn_val = 'Remove';

                if (isset($_POST['change_btn'])) {
                    $changeTo = $_POST['btn_name'];
                    if ($changeTo == "Waiting") {
                        $sql3 = "SELECT * FROM booking_info WHERE client_name='{$uName}'";
                        $btn_val = 'Remove';
                    } else {
                        $sql3 = "SELECT * FROM approved_info WHERE client_name='{$uName}'";
                        $btn_val = 'Pay';
                    }
                }

                $query = mysqli_query($con, $sql3);
                if (mysqli_num_rows($query) == 0) {
                    echo "<h1>No items Ordered Yet!</h1>";
                }

                while ($row = mysqli_fetch_assoc($query)) {
                    $new_price = $row['amount'];
                    $sql3 = "SELECT * FROM item_info WHERE item_name='{$row['booking_for']}'";
                    $query = mysqli_query($con, $sql3);
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<div class='card' style='width:325px'>";
                        echo "<img class='card-img-top' src={$row['item_image']} alt='Card image'>";
                        echo "<div class='card-body'>";
                        echo "<h4 class='card-title'>{$row['item_name']}</h4>";
                        echo "<p class='card-text'>{$row['item_category']}</p>";
                        echo "<h5 class='card-text'>To be paid: Rs {$new_price}</h5>";
                        echo "<form method='post'><input type='hidden' name='btn_name' value={$row['item_name']} /><button id={$row['item_name']} name='{$btn_val}' type='submit' class='btn btn-primary $btn_val'>$btn_val</button><form>";
                        echo "</div></div>";
                    }
                }
                ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    </div>

</body>

</html>

<?php

if (isset($_POST['Remove'])) {
    removeOrder($server, $username, $password, $database);
} else if (isset($_POST['Pay'])) {
    Pay();
}
function removeOrder($server, $username, $password, $database)
{

    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $prod_name = $_POST["btn_name"];
    $uName = $_SESSION['username'];

    $sql = $con->prepare("DELETE FROM `booking_info` WHERE `client_name` = ? and `booking_for`= ?");
    $sql->bind_param("ss", $uName, $prod_name);
    $sql->execute();
    $con->close();
    echo "<script> window.location.replace('approved.php');</script>";
}

function Pay()
{
    $prod_name = $_POST["btn_name"];
    echo "<script> window.location.replace('payment.php?prod_name={$prod_name}');</script>";
}
?>