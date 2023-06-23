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
    <link rel="stylesheet" href="../assets/styles/cart.css?<?php echo time(); ?>">
    <title>Cart</title>
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
                        <a class="nav-link active" href="cart.php">Cart</a>
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
            <div class="page_info">
                <?php
                include "global.php";
                $con = mysqli_connect($server, $username, $password, $database);
                if (!$con) {
                    echo "Not connected";
                }
                $sql3 = "SELECT * FROM cart_info WHERE user_name='{$uName}'";

                $result = $con->query($sql3);
                if (mysqli_num_rows($result) == 0) {
                    echo "<h1>No items in Cart Yet!</h1>";
                }
                while ($row1 = $result->fetch_assoc()) {
                    $sql2 = "SELECT * FROM item_info WHERE item_name='{$row1['prod_name']}'";
                    $query = mysqli_query($con, $sql2);
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<div class='card' style='width:325px'>";
                        echo "<img class='card-img-top' src={$row['item_image']} alt='Card image'>";
                        echo "<div class='card-body'>";
                        echo "<h4 class='card-title'>{$row['item_name']}</h4>";
                        echo "<p class='card-text'>{$row['item_category']}</p>";
                        echo "<h5 class='card-text'>Rs {$row['price']} per hr</h5>";
                        echo "<form method='post'><input type='hidden' name='btn_name' value={$row['item_name']} /><button id={$row['item_name']} name='add_to_cart' type='submit' class='btn btn-primary add_btn'>Added</button>";
                        echo "<a href='order.php?orderedItem={$row['item_name']}&orderedPrice={$row['price']}' class='btn btn-primary'>Order</a></form>";
                        echo "</div></div>";
                    }
                }
                ?>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

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
    $prod_name = $_POST["btn_name"];
    $sql1 = "SELECT * FROM cart_info WHERE prod_name = '$prod_name' AND user_name = '$uName'";
    $query = mysqli_query($con, $sql1);
    if ($query->num_rows > 0) {
        $sql2 = "DELETE FROM cart_info WHERE prod_name = '$prod_name' AND user_name = '$uName' ";
        $query = mysqli_query($con, $sql2);
        echo "<script>{$prod_name}.innerHTML = 'Cart';
        {$prod_name}.style.backgroundColor = '#007bff';
        history.go(-1);</script>";
    } else {
        $sql3 = $con->prepare("INSERT INTO cart_info (`prod_name`, `user_name`) VALUES (?,?)");
        $sql3->bind_param("ss", $prod_name, $uName);
        $sql3->execute();
        echo "<script>{$prod_name}.innerHTML = 'Added';
        {$prod_name}.style.backgroundColor = 'green';
        history.go(-1);</script>";
    }
}
?>