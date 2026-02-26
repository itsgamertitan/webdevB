<?php
session_start();
include "db_conn.php";


if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}


if (isset($_POST['update_multiplier'])) {
    $event_name = $_POST['multiplier_event_name'];
    $multiplier = $_POST['multiplier'];
    $multiplier_msg = "SYSTEM OVERRIDE SUCCESS: $multiplier" . "x Multiplier active for '$event_name'!";
}


$sql_users = "SELECT * FROM users";
$result_users = mysqli_query($conn, $sql_users);


$sql_logs = "SELECT * FROM system_audit_logs ORDER BY timestamp DESC LIMIT 5";
$result_logs = mysqli_query($conn, $sql_logs);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div style="display:flex; justify-content:space-between; border-bottom:2px solid var(--neon-blue); padding-bottom:10px;">
        <h1>>> ADMIN_TERMINAL</h1>
        <p>USER: <?php echo $_SESSION['username']; ?> | <a href="logout.php">[ LOGOUT ]</a></p>
    </div>

    <div style="margin-top: 20px; border: 1px solid var(--neon-blue); padding: 15px; background-color: #0a0a0a;">
        <h3>>> EVENT_POINT_MULTIPLIER</h3>
        
        <?php if (isset($multiplier_msg)) { echo "<p style='color:var(--neon-green); font-weight:bold;'>$multiplier_msg</p>"; } else { ?>
            <p>Current Active Multiplier: <span style="color:var(--neon-green); font-size:1.5rem; font-weight:bold;">1.0x (Standard Rate)</span></p>
        <?php } ?>
        
        <form method="post" action="" style="margin-top:10px;">
            <label>Event Name:</label><br>
            <input type="text" name="multiplier_event_name" placeholder="e.g., APU Campus Cleanup" style="width: 100%; max-width: 400px; margin-bottom: 10px;" required><br>

            <label>Event Description:</label><br>
            <textarea name="multiplier_event_desc" rows="3" placeholder="Brief description of why the multiplier is active..." style="width: 100%; max-width: 400px; background:#000; color:#fff; border:2px solid var(--neon-blue); font-family:inherit; margin-bottom: 10px;" required></textarea><br>

            <label>Set New Multiplier:</label><br>
            <select name="multiplier" style="width: 150px; padding: 5px; margin-bottom: 15px; background:#000; color:#fff; border:2px solid var(--neon-blue); font-family:inherit;">
                <option value="1.0">1.0x (Standard)</option>
                <option value="1.5">1.5x (Boost)</option>
                <option value="2.0">2.0x (Double)</option>
                <option value="3.0">3.0x (Mega)</option>
            </select><br>

            <button type="submit" name="update_multiplier" style="padding: 10px 20px;">UPDATE SYSTEM</button>
        </form>
    </div>

    <div style="margin-top: 20px; border: 1px solid #fff; padding: 15px;">
        <h3>>> STAFF_WORK_QUOTA</h3>
        <p>Set weekly verification targets for staff members.</p>
        <table style="margin-top: 10px;">
            <tr>
                <th>STAFF USERNAME</th>
                <th>CURRENT QUOTA (Items/Week)</th>
                <th>ACTION</th>
            </tr>
            <tr>
                <td>pohyin_staff</td>
                <td>50</td>
                <td><button type="button" onclick="alert('Feature coming soon')">EDIT QUOTA</button></td>
            </tr>
            <tr>
                <td>aikyo_staff</td>
                <td>50</td>
                <td><button type="button" onclick="alert('Feature coming soon')">EDIT QUOTA</button></td>
            </tr>
        </table>
    </div>

    <h3 style="margin-top: 30px;">>> USER_DATABASE</h3>
    <a href="add_staff.php"><button style="margin-bottom: 10px;">+ CREATE NEW STAFF ACCOUNT</button></a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>USERNAME</th>
                <th>ROLE</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_users)) { ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo strtoupper($row['role']); ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $row['user_id']; ?>">[ EDIT ]</a>
                    <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" style="color:red; margin-left:10px;">[ DELETE ]</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <h3 style="margin-top: 30px;">>> SYSTEM_AUDIT_LOG</h3>
    <table>
        <thead>
            <tr>
                <th>TIME</th>
                <th>ACTION</th>
                <th>DETAILS</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result_logs) > 0) {
                while ($log = mysqli_fetch_assoc($result_logs)) { ?>
                <tr>
                    <td><?php echo $log['timestamp']; ?></td>
                    <td><?php echo $log['action_type']; ?></td>
                    <td><?php echo $log['details']; ?></td>
                </tr>
            <?php } 
            } else { echo "<tr><td colspan='3'>No logs detected.</td></tr>"; }
            ?>
        </tbody>
    </table>

</body>
</html>