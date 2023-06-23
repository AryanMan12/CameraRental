<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel="stylesheet" href="../assets/styles/see_transactions.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/styles/table.css?<?php echo time(); ?>">


</head>

<body>
    <div class="container">
        <?php
        makeTranscationsTable()
        ?>
    </div>

</body>

</html>

<?php
include "global.php";
function makeTranscationsTable()
{
    include "global.php";

    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $sql3 = "SELECT * FROM transaction_info";
    $query = mysqli_query($con, $sql3);
    if (!$query || mysqli_num_rows($query) == 0) {
        echo "<h1>No Transactions yet...</h1>";
    } else {
?>
<table>
    <thead>
        <tr>
            <th>Transaction Id</th>
            <th>Client Name</th>
            <th>Booking For</th>
            <th>From Time</th>
            <th>To Time</th>
            <th>Total Time</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
                $num = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    $id = $row["transaction_id"];
                    echo "<tr>
                    <td>{$id}</td>
                    <td>{$row['client_name']}</td>
                    <td>{$row['booking_for']}</td>
                    <td>{$row['from_time']}</td>
                    <td>{$row['to_time']}</td>
                    <td>{$row['total_time']}</td>
                    <td>{$row['amount']}</td></tr>\n";
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