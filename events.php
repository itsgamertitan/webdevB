<?php
include "db_conn.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upcoming Events</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .event-card {
            border: 2px dashed var(--neon-blue);
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            text-align: left;
        }
        .date-box {
            background-color: var(--neon-blue);
            color: #000;
            padding: 5px 10px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body style="text-align:center;">

    <h1>>> SUSTAINABILITY_EVENTS</h1>
    <p>Earn extra points by attending these events!</p>
    <br>

    <div class="event-card">
        <div class="date-box">📅 MARCH 15, 2026</div>
        <h3>BEACH CLEANUP DRIVE</h3>
        <p>Location: Port Dickson Beach</p>
        <p>Join us to remove plastic waste from the ocean. Earn <strong>500 Points</strong> for participating.</p>
        <button>REGISTER NOW</button>
    </div>

    <div class="event-card">
        <div class="date-box">📅 APRIL 02, 2026</div>
        <h3>E-WASTE COLLECTION DAY</h3>
        <p>Location: APU Campus, Atrium</p>
        <p>Bring your old electronics (phones, batteries) for safe recycling.</p>
        <button>REGISTER NOW</button>
    </div>

    <br>
    <a href="admin_dashboard.php">[ BACK TO DASHBOARD ]</a>

</body>
</html>