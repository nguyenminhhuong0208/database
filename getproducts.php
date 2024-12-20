<?php
include './components/connection.php';

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


if (isset($_POST['add_to_wishlist'])) {
    $id = unique_id();
    $product_id = $_POST['product_id'];

    $varify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
    $varify_wishlist->execute([$user_id, $product_id]);

    $cart_num = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $cart_num->execute([$user_id, $product_id]);

    if ($varify_wishlist->rowCount() > 0) {
        $warning_msg[] = 'product already exist in your wishlist';
    } else if ($cart_num->rowCount() > 0) {
        $warning_msg[] = 'product already exist in your cart';
    } else {
        $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(id,user_id,product_id,price) VALUES(?,?,?,?)");
        $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
        $success_msg[] = 'product added to wishlist successfully!';
    }
}
//adding products in cart
if (isset($_POST['add_to_cart'])) {
    $id = unique_id();
    $product_id = $_POST['product_id'];

    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    $varify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $varify_cart->execute([$user_id, $product_id]);

    $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $max_cart_items->execute([$user_id]);

    if ($varify_cart->rowCount() > 0) {
        $warning_msg[] = 'product already exist in your wishlist';
    } else if ($max_cart_items->rowCount() > 20) {
        $warning_msg[] = 'cart is full';
    } else {
        $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_cart = $conn->prepare("INSERT INTO `cart`(id,user_id,product_id,price,qty) VALUES(?,?,?,?,?)");
        $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
        $success_msg[] = 'product added to cart successfully!';
    }
}




if (isset($_GET['keyword']) && $_GET['keyword'] !== '') {
    $keyword = '%' . $_GET['keyword'] . '%';

    $query = $conn->prepare("SELECT * FROM `products` WHERE `name` LIKE :keyword");
    $query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
} else {
    $results = [];
}
//echo $keyword; // Kiểm tra từ khóa được tạo

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
    <title>Search results</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Search</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/search</span>
        </div>
        <section class="products">
            <div class="box-container">
                <?php
                if (!empty($results)) {
                    foreach ($results as $product) {
                ?>
                        <form action="" method="post" class="box">
                            <img src="image/<?= $product['image']; ?>" class="img">
                            <div class="button">
                                <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                                <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                <a href="view_page.php?pid=<?php echo $product['id']; ?>" class="bx bxs-show"></a>
                            </div>
                            <h3 class="name"><?= $product['name']; ?></h3>
                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                            <div class="flex">
                                <p class="price">Price $<?= $product['price']; ?>/-</p>
                                <input type="number" name="qty" required min="1" max="99" maxlength="2" class="qty" value="1">
                            </div>
                            <a href="checkout.php?get_id=<?= $product['id']; ?>" class="btn">Buy now</a>
                        </form>
                <?php
                    }
                } else {
                    echo '<p></p><p class="empty">No products found yet!</p> </div>';
                }
                ?>

            </div>
        </section>


    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>


</html>