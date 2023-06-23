<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/styles/admin_page.css?<?php echo time(); ?>">

</head>

<body>

    <body>
        <div class="navbar">
            <h1><b>Clicker</b></h1>
            <a class="logout-btn" href="admin_login.php">Logout</a>
        </div>
        <div class="grid-container">
            <button class="square-btn" onclick="window.location.href='manage_category.php';">Manage Category</button>
            <button class="square-btn" onclick="window.location.href='manage_items.php';">Manage Items</button>
            <button class="square-btn" onclick="window.location.href='manage_bookings.php';">Manage Bookings</button>
            <button class="square-btn" onclick="window.location.href='see_transactions.php';">See Past
                Transactions</button>
            <button class="square-btn" onclick="window.location.href='see_users.php';">See Users</button>
            <button class="square-btn" onclick="window.location.href='change_UPI.php';">Change UPI details</button>
        </div>
    </body>
</body>

</html>