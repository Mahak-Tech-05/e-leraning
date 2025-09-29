<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === 'teacher') {
                header("Location: dashboard.php");
            } else {
                header("Location: home.php");
            }
            exit;
        } else {
            echo "<p style='color:red;text-align:center;'>Invalid password!</p>";
        }
    } else {
        echo "<p style='color:red;text-align:center;'>No such user found!</p>";
    }
}
?>
