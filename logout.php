<?php
session_start(); //

session_unset();
session_destroy();

header("Location: index.php"); // Changed from login.php to index.php
exit();
?>