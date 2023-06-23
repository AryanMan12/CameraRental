<?php
session_start();
$_SESSION['isStudent'] = 'true';

$uName = $_SESSION['username'];
$ordered_item = $_GET['orderedItem'];
$price = $_GET['orderedPrice'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles/order.css?<?php echo time(); ?>">
    <title>Order</title>
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
                            <a class="dropdown-item" href="login.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="main_body">
            <div class="page_info">
                <form method="post">
                    <div class="form">
                        <div class="title">Place Order</div>
                        <div class="subtitle">Enter Details to Continue!</div>
                        <div class="subtitle1">Use 24 hr format (hh:mm)</div>
                        <div class="input-container ic1">
                            <?php
                            echo "<input id='prod_name' name='prod_name' class='input' type='text' placeholder=' ' value='{$ordered_item}' disabled=true />";
                            ?>
                            <div class="cut"></div>
                            <label for="prod_name" class="placeholder">Product Name</label>
                        </div>
                        <div class="input-container ic1">
                            <input id="from_time" name="from_time" class="input" type="text" placeholder=" " />
                            <div class="cut"></div>
                            <label for="from_time" class="placeholder">From Time</label>
                        </div>
                        <div class="input-container ic2">
                            <input id="to_time" name="to_time" class="input" type="text" placeholder=" " />
                            <div class="cut"></div>
                            <label for="to_time" class="placeholder">To Time</label>
                        </div>
                        <div class="input-container ic2">
                            <input id="total_time" name="total_time" class="input" type="text" placeholder=" " value="To be Calculated" disabled=true />
                            <div class="cut cut-short"></div>
                            <label for="total_time" class="placeholder">Total Time</label>
                        </div>
                        <div class="input-container ic2">
                            <input id="price" name="price" class="input" type="text" placeholder=" " value="To be Calculated" disabled=true />
                            <div class="cut cut-short"></div>
                            <label for="price" class="placeholder">Amount</label>
                        </div>
                        <button type="submit" name="calculate" class="submit">Calculate</button>
                        <button type="submit" name="order" class="submit">Order</button>
                    </div>
                </form>
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
if (isset($_POST['calculate'])) {
    calculate();
} else if (isset($_POST['order'])) {
    order($server, $username, $password, $database);
}

function calculate()
{
    $from_time = $_POST['from_time'];
    $to_time = $_POST['to_time'];

    $from_hr = (int)substr($from_time, 0, 2);
    $from_min = (int)substr($from_time, 3, 2);

    $to_hr = (int)substr($to_time, 0, 2);
    $to_min = (int)substr($to_time, 3, 2);

    $total_from = ($from_hr * 60) + $from_min;
    $total_to = ($to_hr) * 60 + $to_min;
    $total_time_hr = intdiv(($total_to - $total_from), 60);
    $total_time_min = ($total_to - $total_from) - ($total_time_hr * 60);
    $price = $_GET['orderedPrice'];
    $total_price = round(($total_time_hr * $price) + ($total_time_min / 60 * $price), 2);


    if (strlen((string)$total_time_hr) == 1) {
        $total_time_hr =  '0' . (string)$total_time_hr;
    }
    if (strlen((string)$total_time_min) == 1) {
        $total_time_min = '0' . (string)$total_time_min;
    }

    echo "<script>from_time.value = '{$from_time}'</script>";
    echo "<script>to_time.value = '{$to_time}'</script>";
    echo "<script>total_time.value = '{$total_time_hr}:{$total_time_min}'</script>";
    echo "<script>price.value = '{$total_price}'</script>";
}

function order($server, $username, $password, $database)
{
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }

    calculate();
    $uName = $_SESSION['username'];
    $ordered_item = $_GET['orderedItem'];
    $from_time = $_POST['from_time'];
    $to_time = $_POST['to_time'];
    $price = $_GET['orderedPrice'];

    $from_hr = (int)substr($from_time, 0, 2);
    $from_min = (int)substr($from_time, 3, 2);

    $to_hr = (int)substr($to_time, 0, 2);
    $to_min = (int)substr($to_time, 3, 2);

    $total_from = ($from_hr * 60) + $from_min;
    $total_to = ($to_hr) * 60 + $to_min;
    $total_time_hr = intdiv(($total_to - $total_from), 60);
    $total_time_min = ($total_to - $total_from) - ($total_time_hr * 60);
    $price = $_GET['orderedPrice'];
    $total_price = round(($total_time_hr * $price) + ($total_time_min / 60 * $price), 2);


    if (strlen((string)$total_time_hr) == 1) {
        $total_time_hr =  '0' . (string)$total_time_hr;
    }
    if (strlen((string)$total_time_min) == 1) {
        $total_time_min = '0' . (string)$total_time_min;
    }
    $total_time = $total_time_hr . ':' . $total_time_min;

    echo "$total_time";

    $sql = $con->prepare("INSERT INTO `booking_info` (`client_name`,`booking_for`, `from_time`, `to_time`, `total_time`, `amount`) VALUES (?,?,?,?,?,?)");
    $sql->bind_param("sssssi", $uName, $ordered_item, $from_time, $to_time, $total_time, $total_price);
    $sql->execute();
    echo "<script>alert('Order Placed'); window.location.replace('approved.php');</script>";
}



?>