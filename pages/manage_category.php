<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Category</title>
    <link rel="stylesheet" href="../assets/styles/manage_category.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/styles/table.css?<?php echo time(); ?>">


</head>

<body>
    <div class="container">
        <form class="form" method="post">
            <label for="categ">Add New Category</label>
            <input type="text" id="categ" name="categ" required>
            <button class="sub_button" name="sub_btn" type="submit">Submit</button>
        </form>
        <?php
        makeCategoryTable()
        ?>
    </div>
</body>

</html>

<?php
include "global.php";

if (isset($_POST['sub_btn'])) {
    addCategory($server, $username, $password, $database);
} else if (isset($_POST['remove_btn'])) {
    removeCategory($server, $username, $password, $database);
}

function addCategory($server, $username, $password, $database)
{
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $category = $_POST['categ'];

    if (empty($category)) {
        echo "<script>alert('Fields cannot be empty'); window.location.replace('manage_category.php');</script>";
    } else {
        $sql3 = "SELECT * FROM category_info WHERE category_name = '$category'";
        $query = mysqli_query($con, $sql3);
        if ($query->num_rows > 0) {
            echo "<script>alert('Category Already there!'); history.go(-1);</script>";
        } else {
            $sql = $con->prepare("INSERT INTO `category_info` (`category_name`) VALUES (?)");
            $sql->bind_param("s", $category);
            echo "<script> history.go(-1)</script>";
            $sql->execute();
        }
    }
    $con->close();
}

function removeCategory($server, $username, $password, $database)
{
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $id = (int)$_POST['categories'];
    $sql = $con->prepare("DELETE FROM `category_info` WHERE `category_id` = ?");
    $sql->bind_param("i", $id);
    echo "<script> history.go(-1)</script>";
    $sql->execute();

    $con->close();
}
function makeCategoryTable()
{
    include "global.php";

    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $sql3 = "SELECT * FROM  category_info";
    $query = mysqli_query($con, $sql3);
    if (!$query || mysqli_num_rows($query) == 0) {
        echo "<h1>No Category Added yet...</h1>";
    } else {
?>
        <table>
            <thead>
                <tr>
                    <th>Category Id</th>
                    <th>Category Name</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $num = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    $id = $row["category_id"];
                    echo "<tr><td>{$num}</td>
                    <td>{$row['category_name']}</td>
                    <td><form method='post'><input type='hidden' name='categories' value=$id><input class='table_button' type='submit' name='remove_btn' value='Remove'></form></td></tr>\n";
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