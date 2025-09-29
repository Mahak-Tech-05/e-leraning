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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beyine E And i</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #87CEEB;
      height: 100vh;
    }

    .game-container {
      position: relative;
      width: 100%;
      max-width: 1366px; /* your image original width */
    }

    .game-container img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* All buttons are placed relative to container */
    .btn {
      position: absolute;
      border: none;
      cursor: pointer;
      background: rgba(255, 255, 255, 0); /* fully transparent */
    }

    /* Start button */
    .btn-start {
      top: 38%;    /* Y position */
      left: 28%;   /* X position */
      width: 12%;  /* Button width */
      height: 8%;  /* Button height */
    }

    /* Hello button */
    .btn-hello {
      top: 35%;
      left: 55%;
      width: 12%;
      height: 8%;
    }

    /* Good Morning button */
    .btn-goodmorning {
      top: 35%;
      left: 69%;
      width: 18%;
      height: 8%;
    }

    /* Mic button */
    .btn-mic {
      top: 64%;
      left: 43%;
      width: 18%;
      height: 20%;
      border-radius: 50%;
    }

    /* Reward Screen button */
    .btn-reward {
      top: 76%;
      left: 70%;
      width: 20%;
      height: 20%;
    }
  </style>
</head>
<body>
  <div class="game-container">
    <img src="./assests/image.png" alt="Game UI">

    <!-- Clickable Buttons --><button class="btn btn-start" onclick="window.location.href='game.php'"></button>

    <button class="btn btn-hello" onclick="window.location.href='https://studio-8806440108-ada24.web.app/grammar'"></button>
    <button class="btn btn-goodmorning" onclick="window.location.href='https://studio-8806440108-ada24.web.app/story'"></button>
    <button class="btn btn-mic" onclick="window.location.href='https://studio-8806440108-ada24.web.app/pronunciation'"></button>
    <button class="btn btn-reward" onclick="window.location.href='https://studio-8806440108-ada24.web.app/quiz'"></button>
  </div>
</body>
</html>

