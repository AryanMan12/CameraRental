<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="../assets/styles/see_users.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/styles/table.css?<?php echo time(); ?>">

</head>

<body>
    <div class="container">
        <?php
        makeUsersTable()
        ?>
    </div>
</body>

</html>

<?php
include "global.php";
function makeUsersTable()
{
    include "global.php";

    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $sql3 = "SELECT * FROM user_info";
    $query = mysqli_query($con, $sql3);
    if (!$query || mysqli_num_rows($query) == 0) {
        echo "<h1>No Users yet...</h1>";
    } else {
?>
        <table>
            <thead>
                <tr>
                    <th>User Id</th>
                    <th>User Name</th>
                    <th>User Username</th>
                    <th>User Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $num = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    $id = $row["user_id"];
                    echo ("<tr>
                    <td>{$id}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td></tr>\n");
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