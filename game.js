const canvas = document.getElementById("gameCanvas");
const context = canvas.getContext("2d");
const startGameButton = document.getElementById("game");
const outGameButton = document.getElementById("outGameButton");

const userElement = document.getElementById("user-data");
const userId = userElement.getAttribute("data-user-id");

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

let earnedVouchers = []; // Lưu danh sách voucher đã nhận
let vouchers = []; // Chứa thông tin về voucher từ server

function resetBall() {
  ballX = canvas.width / 2;
  ballY = canvas.height / 2;
  ballSpeedX = 6;
  ballSpeedY = 6;
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
    checkForVouchers();
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
    fetchVouchers();
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

// Hàm fetch để lấy vouchers từ server
async function fetchVouchers() {
  try {
    const response = await fetch(
      "get_voucher/api_get_voucher.php?category=game"
    );
    const text = await response.text(); // Nhận dữ liệu dưới dạng text
    console.log(text); // In ra nội dung nhận được

    // Kiểm tra và chuyển đổi dữ liệu nếu là JSON hợp lệ
    try {
      vouchers = JSON.parse(text); // Lưu mảng vouchers vào biến toàn cục
      console.log("Vouchers fetched:", vouchers);
      checkForVouchers(); // Sau khi có vouchers, gọi hàm kiểm tra
    } catch (e) {
      console.error("Error parsing JSON:", e);
    }
  } catch (error) {
    console.error("Error fetching vouchers:", error);
  }
}

// Hàm kiểm tra nếu có vouchers để nhận
function checkForVouchers() {
  console.error("Vouchers length:", vouchers.length); // Kiểm tra xem mảng vouchers có rỗng không
  vouchers.forEach((voucher) => {
    console.log("Voucher requirement:", voucher.requirement);
    if (
      score >= voucher.requirement && // Điểm đủ yêu cầu
      !earnedVouchers.includes(voucher.id) // Chưa nhận voucher này
    ) {
      earnedVouchers.push(voucher.id); // Đánh dấu là đã nhận
      giveVoucher(voucher.id); // Gửi yêu cầu nhận voucher
    }
  });
}

// Hàm gửi yêu cầu nhận voucher
async function giveVoucher(voucherId) {
  try {
    const response = await fetch("get_voucher/api_give_voucher.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ user_id: userId, voucher_id: voucherId }),
    });

    const result = await response.json();
    if (result.error) {
      alert("Congratulations for that score, but we ran out of this voucher");
    } else {
      alert("Congratulations! You earned a game voucher");
    }
  } catch (error) {
    console.error("Error giving voucher:", error);
  }
}
