<?php
include 'components/connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = '';
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}
?>

<style type="text/css">
<?php include 'style.css';
?>
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <title>Green Coffee - home page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>


    <div id="user-data" data-user-id="<?php echo htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'); ?>"></div>
    <div class="main">
        <div class="banner">
            <h1>dashboard</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span></span>
        </div>
        <section section class="dashboard">
            <div class="box-container">
                <div class="box">
                    <h3>welcome!</h3>
                    <a href="" class="btn">Home</a>
                </div>
                <div class="box">
                    <?php
                            $select_product = $conn->prepare("SELECT * FROM `products`");
                            $select_product->execute();
                            $num_of_products = $select_product->rowCount();
                            ?>
                    <h3><?= $num_of_products; ?></h3>
                    <p>All Products</p>
                    <a href="view_products.php" class="btn">View products</a>
                </div>
                <div class="box">
                    <?php
                            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id= ?");
                            $select_orders->execute([$user_id]);
                            $num_of_orders = $select_orders->rowCount();
                        ?>
                    <h3><?= $num_of_orders; ?></h3>
                    <p>Your orders</p>
                    <a href="view_order.php" class="btn">view your orders</a>
                </div>
                <div class="box">
                    <?php
                            $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id= ?");
                            $select_wishlist->execute([$user_id]);
                            $num_of_wishlist = $select_wishlist->rowCount();
                        ?>
                    <h3><?= $num_of_wishlist; ?></h3>
                    <p>Your Wishlist</p>
                    <a href="wishlist.php" class="btn">view your wishlist</a>
                </div>
                <div class="box">
                    <?php
                            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id= ?");
                            $select_cart->execute([$user_id]);
                            $num_of_cart = $select_cart->rowCount();
                        ?>
                    <h3><?= $num_of_cart; ?></h3>
                    <p>Your cart</p>
                    <a href="cart.php" class="btn">View your cart</a>
                </div>
                <div class="box">
                    <p>Do you want to play game?</p>
                    <button id="game" class="btn" onclick="playPickleBallMusic()">Play PickleBall</button>
                    <button id="outGameButton" class="btn" style="display:none;"
                        onclick="pausePickleBallMusic()">Pause</button>

                    <div id="scoreDisplay" class="score">Score: 0</div>
                    <div id="maxScoreDisplay" class="score">Max Score: 0</div>

                </div>
                <div id="PongGame">
                    <canvas id="gameCanvas" width="800" height="600"></canvas>
                    <script src="game.js"></script>
                </div>
            </div>
        </section>
    </div>
    <?php include 'components/footer.php'; ?>
    </main>
</body>

</html>