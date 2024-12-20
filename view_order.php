<?php
include 'components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location: order.php');
}

if (isset($_POST['cancel'])) {
    $update_order = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $update_order->execute(['canceled', $get_id]);
    header("Location: order.php");
    exit();
}
?>

<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <title>Green Coffee - order detail page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Order Detail</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>\ Order Detail</span>
        </div>
        <section class="order-detail">
            <div class="box-container">
                <div class="title">
                    <img src="img/download.png" class="logo">
                    <h1>Order Detail</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto dolorum deserunt minus variant tenetur.</p>
                </div>
                <div class="box-container">
                    <?php
                    $grand_total = 0;
                    $select_orders = $conn->prepare("SELECT * FROM orders WHERE id=? LIMIT 1");
                    $select_orders->execute([$get_id]);

                    if ($select_orders->rowCount() > 0) {
                        while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                            $select_product = $conn->prepare("SELECT * FROM products WHERE id=? LIMIT 1");
                            $select_product->execute([$fetch_order['product_id']]);

                            if ($select_product->rowCount() > 0) {
                                while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                                    $sub_total = ($fetch_order['price'] * $fetch_order['qty']);
                                    $grand_total += $sub_total;
                    ?>
                                    <div class="box">
                                        <div class="col">
                                            <p class="title"><?= $fetch_order['date']; ?></p>
                                            <img src="image/<?= $fetch_product['image']; ?>" class="image">
                                            <p class="price"><?= $fetch_product['price']; ?> x <?= $fetch_order['qty']; ?></p>
                                            <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                            <p class="grand-total">Total amount payable: <span>$<?= $grand_total; ?></span></p>
                                        </div>
                                        <div class="col">
                                            <p class="title">Status</p>
                                            <p class="status" style="color:<?php if ($fetch_order['status'] == 'delivered') {
                                                                                echo 'green';
                                                                            } elseif ($fetch_order['status'] == 'canceled') {
                                                                                echo 'red';
                                                                            } else {
                                                                                echo 'orange';
                                                                            } ?>"><?= $fetch_order['status'] ?></p>
                                            <?php if ($fetch_order['status'] == 'canceled') { ?>
                                                <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>?" class="btn">Order Again</a>
                                            <?php } else { ?>
                                                <form method="post">
                                                    <button type="submit" name="cancel" class="btn" onclick="return confirm('Do you want to cancel this order?')">Cancel Order</button>
                                                </form>
                                            <?php } ?>
                                        </div>
                                    </div>
                    <?php
                                }
                            }
                        }
                    } else {
                        echo '<p class="empty">No order placed yet!</p>';
                    }
                    ?>
                </div>
            </div>

            <div class="suggestion">
                <label for="suggest"> recommendation</label>
            </div>
        </section>
        <div class="products carousel">
            <div class="box-container carousel-track">
                <?php
                $suggest_orders = $conn->prepare("SELECT * FROM products");
                $suggest_orders->execute();
                if ($suggest_orders->rowCount() > 0) {
                    while ($suggest_product = $suggest_orders->fetch(PDO::FETCH_ASSOC)) {
                ?>

                        <form action="" method="post" class="box">
                            <img src="image/<?= $suggest_product['image']; ?>" class="img">
                            <div class="button">
                                <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                                <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                <a href="view_page.php?pid=<?php echo $suggest_product['id']; ?>" class="bx bxs-show"></a>
                            </div>
                            <h3 class="name"><?= $suggest_product['name']; ?></h3>
                            <input type="hidden" name="product_id" value="<?= $suggest_product['id']; ?>">
                            <div class="flex">
                                <p class="price">Price $<?= $suggest_product['price']; ?>/-</p>
                                <input type="number" name="qty" required min="1" max="99" maxlength="2" class="qty" value="1">
                            </div>
                            <a href="checkout.php?get_id=<?= $suggest_product['id']; ?>" class="btn">Buy now</a>
                        </form>

                <?php
                    }
                }
                ?>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>