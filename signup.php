<?php include("config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BrightSpeak - Sign Up</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Fredoka One', sans-serif;
      margin: 0;
      height: 100vh;
      background: linear-gradient(to top, rgba(168,230,255,0.7), rgba(217,250,255,0.7)),
                  url('./assests/sign.png');
      background-size: cover;
      background-position: center;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container {
      background: #ffffffd9;
      padding: 30px;
      border-radius: 25px;
      width: 330px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      text-align: center;
    }
    h2 { color: #4caf50; margin-bottom: 15px; }
    input, select {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 20px;
      border: 1px solid #ccc;
      font-family: 'Fredoka One', sans-serif;
    }
    .btn {
      background: #4caf50;
      color: white;
      padding: 12px;
      border: none;
      width: 100%;
      border-radius: 20px;
      cursor: pointer;
    }
    .btn:hover { background: #45a049; }
    a { display: block; margin-top: 10px; color: #007bff; text-decoration: none; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Create Account</h2>
    <form method="POST">
      <input type="text" name="username" placeholder="Enter Username" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <select name="role">
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
      </select>
      <button type="submit" class="btn">Sign Up</button>
    </form>
    <a href="index.html">Already have an account? Login</a>
  </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        if ($conn->query($sql)) {
            echo "<script>alert('Account created successfully!'); window.location='index.html';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
