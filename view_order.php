<?php
    include 'components/connection.php';
    session_start();
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
    }

    if(isset($_POST['logout'])) {
        session_destroy();
        header("location: login.php");
    }
    if (isset($_GET['get_id'])) {
        $get_id = $_GET['get_id'];
      } else {
        $get_id = '';
        header('location: order.php');
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
            <h1>order detail</h1>
        </div>
        <div class="title2">
            <a href="home.php">home</a><span>\ order detail</span>
        </div>
        <section class="order-detail">
            <div class="box-container">
                <div class="title">
                    <image src="img/download.png" class="logo">
                    <h1>order detail</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto dolorum deserunt
                        minus variant
                        tenetur
                    </p>
                </div>
                <div class = "box-container">
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
                                    }
                                }
                            }
                        }
                    ?>
                    <div class="box">
                        <div class="col">
                            <p class="title" title="Ngày" class="bi bi-calendar-fill"><?= $fetch_order['date']; ?></p>
                            <img src="image/<?= $fetch_product['image']; ?>" class="image">
                            <p class="price"><?= $fetch_product['price']; ?> x <?= $fetch_order['qty']; ?></p>
                            <h3 class="name"><?= $fetch_product['name']; ?></h3>
                            <p class="grand-total">Total amount payable: <span>$<?= $grand_total; ?></span></p>
                        </div> 
                        <div class="col">

                        </div>
                    </div>
                    <?php
                                    }
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </section>
    </div>
    <!-- //<?php include 'components/footer.php'; ?> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>