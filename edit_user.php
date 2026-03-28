<?php
session_start();
include "db_conn.php"; 


if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM users WHERE user_id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}


if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    
    $sql = "UPDATE users SET username='$username', full_name='$full_name', email='$email', role='$role' WHERE user_id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php?msg=User updated successfully");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css"> </head>
<body style="text-align:center;">

    <h1>>> EDIT_USER_DATA</h1>

    <form method="post" action="">
        <label>USERNAME:</label><br>
        <input type="text" name="username" value="<?php echo $row['username']; ?>"><br>

        <label>FULL NAME:</label><br>
        <input type="text" name="full_name" value="<?php echo $row['full_name']; ?>"><br>

        <label>EMAIL:</label><br>
        <input type="email" name="email" value="<?php echo $row['email']; ?>"><br>

        <label>ROLE:</label><br>
        <select name="role">
            <option value="student" <?php if($row['role']=='student') echo 'selected'; ?>>Student</option>
            <option value="staff" <?php if($row['role']=='staff') echo 'selected'; ?>>Staff</option>
            <option value="admin" <?php if($row['role']=='admin') echo 'selected'; ?>>Admin</option>
        </select><br><br>

        <button type="submit" name="update">UPDATE DATABASE</button>
        <br><br>
        <a href="admin_dashboard.php">[ CANCEL ]</a>
    </form>

</body>
</html>