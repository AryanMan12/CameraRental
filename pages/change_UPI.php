<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI settings</title>
    <link rel="stylesheet" href="../assets/styles/changeUPI.css?<?php echo time(); ?>">

</head>


<body>
    <div class="container">
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
            <label for="upi-url">New UPI Image URL:</label>
            <input type="text" id="upi-url" name="upi-url" required>
            <button class="sub_button" name="sub_button" type="submit">Submit</button>
        </form>
    </div>
</body>

</html>



<?php
include "global.php";

if (isset($_POST['sub_button'])) {
    addUPI($server, $username, $password, $database);
}

function addUPI($server, $username, $password, $database)
{
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $upi = $_POST['upi-url'];

    if (empty($upi)) {
        echo "<script>alert('Fields cannot be empty'); window.location.replace('change_UPI.php');</script>";
    } else {
        $sql3 = "SELECT * FROM upi_info WHERE upi_url = '$upi'";
        $query = mysqli_query($con, $sql3);
        if ($query->num_rows > 0) {
            echo "<script>alert('UPI Already there!'); upi-url.value = ''; history.go(-1);</script>";
        } else {
            $sql = $con->prepare("DELETE FROM `upi_info`");
            $sql->execute();
            $sql = $con->prepare("INSERT INTO `upi_info` (`upi_url`) VALUES (?)");
            $sql->bind_param("s", $upi);
            echo "<script> history.go(-1); upi-url.value = '';</script>";
            $sql->execute();
        }
    }
    $con->close();
}
?>