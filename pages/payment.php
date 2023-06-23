<?php
session_start();
$uName = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles/payment.css?<?php echo time(); ?>">
    <title>Payment</title>
</head>

<body>
    <div class="container">
        <h1>Payment Gateway</h1>
        <div class="info">
            <?php
            include "global.php";
            $con = mysqli_connect($server, $username, $password, $database);
            if (!$con) {
                echo "Not connected";
            }
            $prod_name = $_GET['prod_name'];
            $sql3 = "SELECT * FROM approved_info WHERE booking_for='{$prod_name}' AND client_name = '{$uName}'";
            $query = mysqli_query($con, $sql3);
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<h3>Payment of {$row['amount']} has to be Done on the given UPI!</h3>";
            }
            ?>
        </div>
        <h3 class="ty">Thank You!!</h3>
        <?php
        include "global.php";
        $con = mysqli_connect($server, $username, $password, $database);
        if (!$con) {
            echo "Not connected";
        }
        $sql3 = "SELECT * FROM upi_info";
        $query = mysqli_query($con, $sql3);
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<img class='image' src={$row['upi_url']} alt='image'>";
        }
        ?>

        <form class="form" method="post">
            <button class="sub_button" name="sub_button" type="submit">Done</button>
        </form>
    </div>
</body>

</html>


<?php
include 'global.php';
if (isset($_POST['sub_button'])) {
    transactionComplete();
}

function transactionComplete()
{
    include "global.php";
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $prod_name = $_GET['prod_name'];
    $uName = $_SESSION['username'];

    $sql3 = "SELECT * FROM approved_info WHERE booking_for='{$prod_name}' AND client_name = '{$uName}'";
    $query = mysqli_query($con, $sql3);
    while ($row = mysqli_fetch_assoc($query)) {
        $sql = $con->prepare("INSERT INTO `transaction_info` (`client_name`,`booking_for`, `from_time`, `to_time`, `total_time`, `amount`) VALUES (?,?,?,?,?,?)");
        $sql->bind_param("sssssi", $row['client_name'], $row['booking_for'], $row['from_time'], $row['to_time'], $row['total_time'], $row['amount']);
        $sql->execute();
    }
    $sql = ("DELETE FROM `approved_info` WHERE booking_for='{$prod_name}' AND client_name = '{$uName}'");
    $query = mysqli_query($con, $sql);
    echo "<script> window.location.replace('home.php');</script>";


    $con->close();
}
?>