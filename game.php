<?php
include("config.php");
$conn = new mysqli($host, $user, $pass, $db);

// Fetch the first question to initialize page
$result = $conn->query("SELECT * FROM objects ORDER BY RAND() LIMIT 1");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Kids Interactive Guessing Game</title>

<style>
  /* Reset */
  *, *::before, *::after {
    box-sizing: border-box;
  }

  body {
    font-family: 'Comic Sans MS', cursive, sans-serif;
    margin: 0; padding: 0;
    color: #004d40;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  #bg-container {
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    z-index: -1;
    background-color: #a8dadc;
  }

  #game-container {
    max-width: 480px;
    width: 100%;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.25);
    text-align: center;
  }

  dotlottie-wc {
    width: 100%;
    max-width: 320px;
    border-radius: 25px;
    box-shadow: 0 0 15px rgba(0, 128, 128, 0.6);
    margin-bottom: 20px;
    display: block;
    margin-left: auto;
    margin-right: auto;
  }

  #avatar-message {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 30px;
    color: #00796b;
    min-height: 40px;
  }

  #object-img {
    width: 100%;
    max-width: 280px;
    border-radius: 20px;
    border: 6px solid #004d40;
    margin-bottom: 30px;
    transition: transform 0.3s ease;
  }

  #object-img:hover {
    transform: scale(1.07);
    cursor: zoom-in;
  }

  .options-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }

  .option-btn {
    background: #00796b;
    border-radius: 40px;
    border: none;
    color: white;
    font-size: 26px;
    padding: 18px 0;
    cursor: pointer;
    user-select: none;
    transition: background-color 0.3s, transform 0.3s ease;
    outline: none;
  }

  .option-btn:hover:not(:disabled) {
    background-color: #004d40;
    transform: scale(1.1);
  }

  .option-btn:active:not(:disabled) {
    transform: scale(0.95);
  }

  .option-btn:disabled {
    cursor: not-allowed;
    background-color: #a4d4cf;
    transform: none !important;
  }

  @media (max-width: 480px) {
    .options-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>
  <div id="bg-container"></div>

  <div id="game-container">
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.1/dist/dotlottie-wc.js" type="module"></script>
    <dotlottie-wc id="avatar"
      src="https://lottie.host/d67110be-4cc1-4254-b87a-2e5f03d1dcad/LYmVtrHZ7X.lottie"
      autoplay loop></dotlottie-wc>

    <div id="avatar-message">Can you guess what this is?</div>

    <img id="object-img" src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Guess object" />

    <div class="options-grid">
      <button class="option-btn"><?php echo htmlspecialchars($row['option1']); ?></button>
      <button class="option-btn"><?php echo htmlspecialchars($row['option2']); ?></button>
      <button class="option-btn"><?php echo htmlspecialchars($row['option3']); ?></button>
      <button class="option-btn"><?php echo htmlspecialchars($row['option4']); ?></button>
    </div>
  </div>

  <audio id="correct-sound" src="correct.mp3" preload="auto"></audio>
  <audio id="wrong-sound" src="wrong.mp3" preload="auto"></audio>

  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

  <script>
    // Lazy load background for better performance
    const bgContainer = document.getElementById('bg-container');
    const bgObserver = new IntersectionObserver(([entry], observer) => {
      if(entry.isIntersecting){
        bgContainer.style.backgroundImage = "url('assests/bg.jpeg')";
        bgContainer.style.backgroundSize = 'cover';
        bgContainer.style.backgroundPosition = 'center';
        bgContainer.style.backgroundRepeat = 'no-repeat';
        observer.unobserve(bgContainer);
      }
    });
    bgObserver.observe(bgContainer);

    const avatar = document.getElementById('avatar');
    const avatarMsg = document.getElementById('avatar-message');
    const correctSound = document.getElementById('correct-sound');
    const wrongSound = document.getElementById('wrong-sound');
    const objectImg = document.getElementById('object-img');
    const buttons = document.querySelectorAll('.option-btn');

    let correctAnswer = "<?php echo addslashes($row['correct']); ?>";
    let dotLottieReady = false;

    avatar.addEventListener('load', () => {
      dotLottieReady = true;
    });

    function switchAnimation(url) {
      if(!dotLottieReady){
        avatar.addEventListener('load', () => {
          avatar.dotLottie.loadAnimation(url).then(() => avatar.dotLottie.play()).catch(console.error);
        }, {once:true});
      } else if(avatar.dotLottie){
        avatar.dotLottie.loadAnimation(url).then(() => avatar.dotLottie.play()).catch(console.error);
      }
    }

    function shootConfetti(){
      const duration = 4000;
      const animationEnd = Date.now() + duration;
      const colors = ['#bb0000', '#ffffff', '#00bb00', '#0000bb', '#ffaa00', '#00aaff', '#aa00ff', '#ff00aa'];

      (function frame(){
        confetti({particleCount:6, angle:60, spread:55, origin:{x:0}, colors:colors});
        confetti({particleCount:6, angle:120, spread:55, origin:{x:1}, colors:colors});
        if(Date.now() < animationEnd){
          requestAnimationFrame(frame);
        }
      })();
    }

    function loadQuestion(){
      fetch('get_question.php')
      .then(resp => resp.json())
      .then(data => {
        if(data.error){
          avatarMsg.textContent = "No more questions available!";
          buttons.forEach(btn => btn.disabled = true);
          return;
        }

        objectImg.src = data.image_url;
        const opts = [data.option1, data.option2, data.option3, data.option4];
        buttons.forEach((btn, i) => {
          btn.textContent = opts[i];
          btn.disabled = false;
        });
        correctAnswer = data.correct;
        avatarMsg.textContent = "Can you guess what this is?";
        switchAnimation('https://lottie.host/d67110be-4cc1-4254-b87a-2e5f03d1dcad/LYmVtrHZ7X.lottie');
      })
      .catch(() => {
        avatarMsg.textContent = "Error loading question.";
        buttons.forEach(btn => btn.disabled = true);
      });
    }

    buttons.forEach(button => {
      button.addEventListener('click', () => {
        if(button.textContent === correctAnswer){
          avatarMsg.textContent = "Yay! That's correct! 🎉";
          correctSound.play();
          switchAnimation('https://lottie.host/2e86bf4a-0585-4ede-823b-6273abc8a64e/EFI1BV11cp.lottie');
          shootConfetti();
          buttons.forEach(btn => btn.disabled = true);
          setTimeout(loadQuestion, 3000);
        } else {
          avatarMsg.textContent = "Oops! Try again!";
          wrongSound.play();
          switchAnimation('https://lottie.host/your_sad_animation_url.lottie');
          // disable only this button to prevent repeat
          button.disabled = true;
        }
      });
    });
  </script>
</body>
</html>
