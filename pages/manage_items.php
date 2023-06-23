<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items</title>
    <link rel="stylesheet" href="../assets/styles/manage_items.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/styles/table.css?<?php echo time(); ?>">
</head>

<body>
    <div class="addItem" id="addItem">
        <form class="login-form" method="post">
            <h1>Add Item</h1>
            <div class="form-input-material">
                <label for="name">Item Name</label>
                <input type="text" name="name" id="name" placeholder=" " autocomplete="off" class="form-control-material" required />
            </div>
            <div class="form-input-material">
                <label for="img_url">Image URL</label>
                <input type="text" name="img_url" id="img_url" placeholder=" " autocomplete="off" class="form-control-material" required />
            </div>
            <div class="form-input-material">
                <label for="price">Price per hour</label>
                <input type="number" name="price" id="Price" placeholder=" " autocomplete="off" class="form-control-material" required />
            </div>
            <div class="form-input-material">
                <label for="Category">Category</label>
                <select name="category" id="Category" placeholder=" " autocomplete="off" class="form-control-material" required>
                    <?php
                    include "global.php";
                    $con = mysqli_connect($server, $username, $password, $database);
                    if (!$con) {
                        echo "Not connected";
                    }
                    $sql3 = "SELECT * FROM category_info";
                    $query = mysqli_query($con, $sql3);
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<option value={$row['category_name']}>{$row['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="add_item_btn" class="btn btn-primary btn-ghost">Add Item</button>
        </form>
    </div>
    <div class="container">
        <input type="button" id="add_btn" class="add_btn" name="add_btn" onclick="toggleAddItem()" value="Add Item" />

        <?php
        makeItemsTable()
        ?>
    </div>
    <script src="../assets/js/manage_item.js"></script>
</body>

</html>


<?php
include "global.php";

if (isset($_POST['remove_item'])) {
    removeItem($server, $username, $password, $database);
} else if (isset($_POST['add_item_btn'])) {
    addItem($server, $username, $password, $database);
}

function  addItem($server, $username, $password, $database)
{
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $category = $_POST['category'];
    $name = $_POST['name'];
    $url = $_POST['img_url'];
    $price = (int)$_POST['price'];

    if (empty($name) || empty($url) || empty($price)) {
        echo "<script>alert('Fields cannot be empty'); window.location.replace('manage_items.php');</script>";
    } else {
        $sql3 = "SELECT * FROM item_info WHERE item_name = '$name'";
        $query = mysqli_query($con, $sql3);
        if ($query->num_rows > 0) {
            echo "<script>alert('Item Already there!'); history.go(-1);</script>";
        } else {
            $sql = $con->prepare("INSERT INTO `item_info` (`item_name`, `item_image`, `item_category`, `price`) VALUES (?,?,?,?)");
            $sql->bind_param("sssi", $name, $url, $category, $price);
            echo "<script> history.go(-1)</script>";
            $sql->execute();
        }
    }
    $con->close();
}

function removeItem($server, $username, $password, $database)
{
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $id = (int)$_POST['items'];
    $sql = $con->prepare("DELETE FROM `item_info` WHERE `item_id` = ?");
    $sql->bind_param("i", $id);
    echo "<script> history.go(-1)</script>";
    $sql->execute();
    $con->close();
}

function makeItemsTable()
{
    include "global.php";

    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $sql3 = "SELECT * FROM  item_info";
    $query = mysqli_query($con, $sql3);
    if (!$query || mysqli_num_rows($query) == 0) {
        echo "<h1>No Items Added yet...</h1>";
    } else {
?>
        <div class="table_container">
            <table>
                <thead>
                    <tr>
                        <th>Item Id</th>
                        <th>Item Name</th>
                        <th>Item Image URL</th>
                        <th>Item Category</th>
                        <th>Price per Hour</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 1;
                    while ($row = mysqli_fetch_assoc($query)) {
                        $id = $row["item_id"];
                        echo "<tr><td>{$num}</td>
                    <td>{$row['item_name']}</td>
                    <td>{$row['item_image']}</td>
                    <td>{$row['item_category']}</td>
                    <td>{$row['price']}</td>
                    <td><form method='post'><input type='hidden' name='items' value=$id><input type='submit' class='table_button' name='remove_item' value='Remove'></form></td></tr>\n";
                        $num++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
<?php
    }
    $con->close();
}
?>