const canvas = document.getElementById("gameCanvas");
const context = canvas.getContext("2d");
const startGameButton = document.getElementById("game");
const outGameButton = document.getElementById("outGameButton");

const paddleWidth = 200,
  paddleHeight = 7,
  ballRadius = 30;
let paddleX = (canvas.width - paddleHeight) / 2;
let ballX, ballY;
let ballSpeedX, ballSpeedY;

let score = 0;
let maxScore = 0;

const ballImage = new Image();
ballImage.src = "img/tom1.jpg";

function resetBall() {
  ballX = canvas.width / 2;
  ballY = canvas.height / 2;
  ballSpeedX = 20;
  ballSpeedY = 20;
}

function drawEverything() {
  context.fillStyle = "black";
  context.fillRect(0, 0, canvas.width, canvas.height);

  context.fillStyle = "white";
  context.fillRect(
    paddleX,
    canvas.height - paddleHeight,
    paddleWidth,
    paddleHeight
  );

  drawCircularImage(context, ballImage, ballX, ballY, ballRadius);
}

function drawCircularImage(ctx, img, x, y, radius) {
  ctx.save();
  ctx.beginPath();
  ctx.arc(x, y, radius, 0, Math.PI * 2, true);
  ctx.closePath();
  ctx.clip();

  ctx.drawImage(img, x - radius, y - radius, radius * 2, radius * 2);
  ctx.restore();
}

function moveEverything() {
  ballX += ballSpeedX;
  ballY -= ballSpeedY;

  if (ballX < ballRadius || ballX > canvas.width - ballRadius) {
    ballSpeedX = -ballSpeedX;
  }

  if (
    ballY + ballRadius > canvas.height - paddleHeight &&
    ballX > paddleX &&
    ballX < paddleX + paddleWidth
  ) {
    ballSpeedY = -ballSpeedY;
    score += 1;

    if (score != 0 && score % 5 == 0) {
      ballSpeedX++;
      ballSpeedY++;
      score++;
    }

    if (score > maxScore) {
      maxScore = score;
      maxScoreDisplay.textContent = "Max Score: " + maxScore; // Cập nhật giao diện
    }

    scoreDisplay.textContent = "Score: " + score;
  }

  if (ballY < ballRadius) {
    ballSpeedY = -ballSpeedY;
  }

  if (ballY + ballRadius > canvas.height) {
    resetBall();
    score = 0;
    scoreDisplay.textContent = "Score: " + score;
  }
}

canvas.addEventListener("mousemove", function (evt) {
  const mousePos = calculateMousePos(evt);
  paddleX = mousePos.x - paddleWidth / 2;
});

function calculateMousePos(evt) {
  const rect = canvas.getBoundingClientRect();
  const root = document.documentElement;
  const mouseX = evt.clientX - rect.left - root.scrollLeft;
  const mouseY = evt.clientY - rect.top - root.scrollTop;
  return {
    x: mouseX,
    y: mouseY,
  };
}

let isPlaying = false;
function gameLoop() {
  if (isPlaying) {
    moveEverything();
    drawEverything();
    requestAnimationFrame(gameLoop);
  }
}

ballImage.onload = function () {
  requestAnimationFrame(gameLoop);
  startGameButton.addEventListener("click", () => {
    startGameButton.style.display = "none";
    canvas.style.display = "inline-block";
    outGameButton.style.display = "inline-block";
    resetBall();
    isPlaying = true;
    gameLoop();
  });

  outGameButton.addEventListener("click", () => {
    isPlaying = false;
    startGameButton.style.display = "inline-block";
    outGameButton.style.display = "none";
    canvas.style.display = "none";
  });

  resetBall();
};

const pickleBallMusic = new Audio("music/pickleBall.mp3");
function playPickleBallMusic() {
  pickleBallMusic.play();
}
function pausePickleBallMusic() {
  pickleBallMusic.pause();
}
