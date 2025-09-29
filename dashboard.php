<?php 
session_start(); 
if(!isset($_SESSION['username'])){ 
    header("Location: login.php"); 
    exit; 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>User Dashboard</title>
<style>
  /* Reset & Base */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body {
    height: 100vh;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: 
      linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
      url('./assests/login.png') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* Container */
  .dashboard {
    background: rgba(255, 255, 255, 0.95);
    padding: 50px 40px;
    border-radius: 18px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.35);
    text-align: center;
    width: 380px;
    animation: fadeIn 1.2s ease-in-out;
  }

  /* Heading */
  .dashboard h1 {
    font-size: 2.4rem;
    color: #0d6efd;
    font-weight: 800;
    margin-bottom: 1.5rem;
  }

  .sub-text {
    font-size: 1rem;
    color: #444;
    margin-bottom: 2rem;
  }

  /* Button Group */
  .btn-group {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  /* Buttons */
  .button-link {
    display: block;
    padding: 14px 20px;
    background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: 10px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    box-shadow: 0 6px 15px rgba(13, 110, 253, 0.3);
  }
  .button-link:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(13, 110, 253, 0.45);
  }

  /* Animation for entry */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
</head>
<body>
  <div class="dashboard">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p class="sub-text">Choose an option below to continue:</p>
    <div class="btn-group">
      <a href="./admin.php" class="button-link">➕ Add Questions</a>
      <a href="./db_view.php" class="button-link">👥 View Students</a>
      <a href="./home.php" class="button-link">📊 Students Dashboard</a>
    </div>
  </div>
</body>
</html>
