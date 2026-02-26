<?php
session_start(); //
include "db_conn.php"; //

// If the user is ALREADY logged in, send them straight to the dashboard
if (isset($_SESSION['username']) && $_SESSION['role'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit();
}

// LOGIN LOGIC
if (isset($_POST['login'])) {
    // - Get data from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // - Check database for user
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Check if they are an Admin
        if ($row['role'] == 'admin') {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            
            header("Location: admin_dashboard.php"); // Redirect to Dashboard
            exit();
        } else {
            $error = "Access Denied: You are not an Admin.";
        }
    } else {
        $error = "Incorrect Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>P2C System Login</title>
    <link rel="stylesheet" href="style.css"> </head>
<body style="text-align:center; padding-top:100px;">

    <h1>>> SYSTEM_LOGIN</h1>
    
    <form method="post" action="">
        
        <?php if (isset($error)) { ?>
            <p class="error" style="color:red; border:1px solid red; padding:5px; display:inline-block;">
                <?php echo $error; ?>
            </p><br>
        <?php } ?>
        
        <label>USERNAME:</label><br>
        <input type="text" name="username" required><br>
        
        <label>PASSWORD:</label><br>
        <input type="password" name="password" required><br>
        
        <button type="submit" name="login">ENTER SYSTEM</button>

    </form>

</body>
</html>