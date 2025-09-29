<?php
$host = "sql205.infinityfree.com";   // your server
$user = "if0_40005859";        // your MySQL username
$pass = "avSEWJ9fbmJPr";            // your MySQL password
$db   = "if0_40005859_brightspeak"; // database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
