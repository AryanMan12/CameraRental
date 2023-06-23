<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="../assets/styles/manage_bookings.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/styles/table.css?<?php echo time(); ?>">
</head>

<body>
    <div class="container">
        <?php
        makeBookingTable();
        ?>
    </div>
</body>

</html>

<?php
include "global.php";

if (isset($_POST['accept_btn'])) {
    acceptBooking($server, $username, $password, $database);
} else if (isset($_POST['reject_btn'])) {
    removeBooking($server, $username, $password, $database);
}

function acceptBooking($server, $username, $password, $database)
{
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $id = (int)$_POST['accepting'];

    $sql3 = "SELECT * FROM booking_info WHERE `booking_id` = $id";
    $query = mysqli_query($con, $sql3);
    while ($row = mysqli_fetch_assoc($query)) {
        $sql = $con->prepare("INSERT INTO `approved_info` (`client_name`,`booking_for`, `from_time`, `to_time`, `total_time`, `amount`) VALUES (?,?,?,?,?,?)");
        $sql->bind_param("sssssi", $row['client_name'], $row['booking_for'], $row['from_time'], $row['to_time'], $row['total_time'], $row['amount']);
        $sql->execute();
    }
    $sql = $con->prepare("DELETE FROM `booking_info` WHERE `booking_id` = ?");
    $sql->bind_param("i", $id);
    echo "<script> history.go(-1)</script>";
    $sql->execute();


    $con->close();
}

function removeBooking($server, $username, $password, $database)
{
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $id = (int)$_POST['rejecting'];
    $sql = $con->prepare("DELETE FROM `booking_info` WHERE `booking_id` = ?");
    $sql->bind_param("i", $id);
    echo "<script> history.go(-1)</script>";
    $sql->execute();
    $con->close();
}

function makeBookingTable()
{
    include "global.php";

    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $sql3 = "SELECT * FROM booking_info";
    $query = mysqli_query($con, $sql3);
    if (!$query || mysqli_num_rows($query) == 0) {
        echo "<h1>No Booking yet...</h1>";
    } else {
?>
        <table>
            <thead>
                <tr>
                    <th>Booking Id</th>
                    <th>Client Name</th>
                    <th>Booking For</th>
                    <th>From Time</th>
                    <th>To Time</th>
                    <th>Total Time</th>
                    <th>Amount</th>
                    <th>Accept</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $num = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    $id = $row["booking_id"];
                    echo "<tr>
                    <td>{$id}</td>
                    <td>{$row['client_name']}</td>
                    <td>{$row['booking_for']}</td>
                    <td>{$row['from_time']}</td>
                    <td>{$row['to_time']}</td>
                    <td>{$row['total_time']}</td>
                    <td>{$row['amount']}</td>
                    <td><form method='post'><input type='hidden' name='accepting' value=$id><input class='table_button' type='submit' name='accept_btn' value='Accept'></form></td>
                    <td><form method='post'><input type='hidden' name='rejecting' value=$id><input class='table_button' type='submit' name='reject_btn' value='Reject'></form></td></tr>\n";
                    $num++;
                }
                ?>
            </tbody>
        </table>

<?php
    }
    $con->close();
}
?>