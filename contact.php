<?php
include "db_conn.php"; 

$msg = "";
if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $message = $_POST['message'];
    
    $msg = "MESSAGE SENT! ADMIN WILL REPLY SOON.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Admin</title>
    <link rel="stylesheet" href="style.css"> </head>
<body style="text-align:center;">

    <h1>>> CONTACT_SYSTEM_ADMIN</h1>

    <?php if ($msg) { echo "<h3 style='color:#00ff00; border:1px solid #00ff00; display:inline-block; padding:10px;'>$msg</h3><br>"; } ?>

    <form method="post" action="">
        <label>YOUR NAME:</label><br>
        <input type="text" name="name" required><br>

        <label>MESSAGE / ISSUE:</label><br>
        <textarea name="message" rows="5" style="width:300px; background:#000; color:#fff; border:2px solid var(--neon-blue); font-family:inherit;" required></textarea><br>
        
        <br>
        <button type="submit" name="send">TRANSMIT MESSAGE</button>
        <br><br>
        <a href="index.php">[ BACK TO LOGIN ]</a>
    </form>

</body>
</html>