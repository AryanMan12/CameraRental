<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Console</title>
    <link rel="stylesheet" href="../assets/styles/admin_login.css?<?php echo time(); ?>">
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="col-left">
                <div class="login-text">
                    <h2>Welcome Back</h2>
                    <p class="btn">Clicker</p>
                </div>
            </div>
            <div class="col-right">
                <div class="login-form">
                    <h2>Admin Login</h2>
                    <form method="post">
                        <p>
                            <label>Username<span>*</span></label>
                            <input name="username" type="text" placeholder="Username" required>
                        </p>
                        <p>
                            <label>Password<span>*</span></label>
                            <input name="password" type="password" placeholder="Password" required>
                        </p>
                        <p>
                            <input type="submit" name="sign_in" value="Sign In" />
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


<?php
include 'global.php';


if (isset($_POST['sign_in'])) {
    AdminLogin($server, $username, $password, $database);
}

function AdminLogin($server, $username, $password, $database)
{
    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql3 = mysqli_query($con, "SELECT * FROM  admin_info WHERE username = '$username'");

    if (mysqli_num_rows($sql3) > 0) {
        $row = mysqli_fetch_assoc($sql3);
        $verify = strcmp($password, $row['password']);
        if ($verify == 0) {
            header('Location:' . 'admin_page.php');
            $_SESSION['username'] = $username;
        } else {
            echo "<script>alert('Incorrect Password'); window.location.replace('admin.php');</script>";
        }
    } else {
        echo "<script>alert('Invalid Admin'); window.location.replace('admin.php');</script>";
    }
    $con->close();
}

?>