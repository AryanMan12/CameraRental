<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="../assets/styles/change_pass.css?<?php echo time(); ?>">
</head>

<body>
    <div class="mainDiv">
        <div class="cardStyle">
            <form method="post" name="signupForm" id="signupForm">

                <h2 class="formTitle">
                    Change Password
                </h2>

                <div class="inputDiv">
                    <label class="inputLabel" for="old_pass">Old Password</label>
                    <input type="password" id="old_pass" name="old_pass" required>
                </div>

                <div class="inputDiv">
                    <label class="inputLabel" for="password">New Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="inputDiv">
                    <label class="inputLabel" for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword">
                </div>

                <div class="buttonWrapper">
                    <button type="submit" id="submitButton" name="changePass"
                        class="submitButton pure-button pure-button-primary">
                        <span>Continue</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</body>

</html>

<?php
include "global.php";

if (isset($_POST['changePass'])) {
    changePassword($server, $username, $password, $database);
}

function changePassword($server, $username, $password, $database)
{

    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        echo "Not connected";
    }

    $username = $_SESSION['username'];
    $pass = $_POST['password'];
    $oldpass = $_POST['old_pass'];
    $cPass = $_POST['confirmPassword'];


    $sql1 = "SELECT username FROM user_info WHERE username = '$username'";
    $query = mysqli_query($con, $sql1);
    if ($username == "") {
        echo "<script>alert('No User Found'); window.location.replace('login.php');</script>";
    } else if ($query->num_rows == 0) {
        echo "<script>alert('No User Found'); window.location.replace('login.php');
        </script>";
    } else {
        $sql3 = mysqli_query($con, "SELECT * FROM  user_info WHERE username = '$username'");
        if (mysqli_num_rows($sql3) > 0) {
            $row = mysqli_fetch_assoc($sql3);
            $verify = password_verify($oldpass, $row['password']);
            if ($verify == 1) {
                if (strcmp($pass, $cPass) == 0) {

                    $passwd = password_hash($pass, PASSWORD_DEFAULT);
                    $sql = $con->prepare("UPDATE `user_info` SET `password` = ? WHERE username='$username'");

                    $sql->bind_param("s", $passwd);
                    echo "<script>alert('Password Changed Successfully...'); window.location.replace('home.php');</script>";
                    $sql->execute();
                } else {
                    echo "<script>alert('New and Confirm Password did not matched!'); history.go(-1);
                </script>";
                }
            } else {
                echo "<script>alert('Incorrect Old Password'); history.go(-1);</script>";
            }
        }
        $con->close();
    }
}

?>