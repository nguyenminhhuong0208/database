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

if (isset($_POST['qty'])) {
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
}

//adding products in wishlist
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

    // Kiểm tra và làm sạch giá trị qty
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT);  // Làm sạch input và đảm bảo là số nguyên

    if ($qty <= 0 || $qty > 99) {
        $warning_msg[] = 'Invalid quantity. Please enter a number between 1 and 99.';
    } else {
        $varify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $varify_cart->execute([$user_id, $product_id]);

        $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
        $max_cart_items->execute([$user_id]);

        if ($varify_cart->rowCount() > 0) {
            $update_cart = $conn->prepare("UPDATE cart SET qty = qty + ? WHERE user_id = ? AND product_id = ?");
            $update_cart->execute([$qty, $user_id, $product_id]);
            $success_msg[] = 'Product quantity updated in your cart.';
        } else if ($max_cart_items->rowCount() > 20) {
            $warning_msg[] = 'Cart is full.';
        } else {
            $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            $insert_cart = $conn->prepare("INSERT INTO cart(id, user_id, product_id, price, qty) VALUES(?,?,?,?,?)");
            $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
            $success_msg[] = 'Product added to cart successfully!';
        }
    }
}

$criteria = isset($_POST['criteria']) ? $_POST['criteria'] : "all products";
$valid_criteria = ["all products", "most ordered", "A to Z"];

if (!in_array($criteria, $valid_criteria)) {
    $criteria = "all products";
}

if ($criteria === "most ordered") {
    $query = "SELECT p.*, COUNT(o.product_id) AS purchase_count 
                      FROM products p 
                      LEFT JOIN orders o ON p.id = o.product_id 
                      GROUP BY p.id 
                      ORDER BY purchase_count DESC";
} elseif ($criteria === "A to Z") {
    $query = "SELECT p.*, COUNT(o.product_id) AS purchase_count 
                      FROM products p 
                      LEFT JOIN orders o ON p.id = o.product_id 
                      GROUP BY p.id 
                      ORDER BY p.name ASC";
} else {
    $query = "SELECT p.*, COUNT(o.product_id) AS purchase_count 
                      FROM products p 
                      LEFT JOIN orders o ON p.id = o.product_id 
                      GROUP BY p.id";
}


$search_product = $conn->prepare($query);
$search_product->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Tra xanh admin panel - All Products Page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>shop</h1>
        </div>
        <div class="title2">
            <a href="home.php">HOME</a><span> / OUR SHOP</span>
        </div>
        <section class="products">
            <h1 class="heading">Products</h1>
            <form method="POST" action="" class="choiceBox">
                <select name="criteria">
                    <option value="all products" <?= $criteria === "all products" ? "selected" : ""; ?>>All Products
                    </option>
                    <option value="most ordered" <?= $criteria === "most ordered" ? "selected" : ""; ?>>Most
                        Ordered</option>
                    <option value="A to Z" <?= $criteria === "A to Z" ? "selected" : ""; ?>>A to Z</option>
                </select>
                <button class="btn" type="submit" name="search">Search</button>
            </form>
            <div class="box-container">

                <?php if ($search_product->rowCount() > 0): ?>
                    <?php while ($fetch_products = $search_product->fetch(PDO::FETCH_ASSOC)): ?>
                        <form action="" method="post" class="box">
                            <img src="image/<?= $fetch_products['image']; ?>" class="img">

                            <div class="button">
                                <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                                <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bx bxs-show"></a>
                            </div>
                            <h3 class="name"><?= $fetch_products['name']; ?></h3>
                            <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                            <div class="flex">
                                <p class="price">Price $<?= $fetch_products['price']; ?>/-</p>

                                <input type="number" name="qty" required min="1" max="99" maxlength="2" class="qty" value="1">

                            </div>
                            <a href="#" onclick="redirectToCheckout('<?= $fetch_products['id']; ?>')" class="btn">Buy now</a>

                            <div class="purchase-count">Ordered: <?= $fetch_products['purchase_count']; ?> times</div>
                        </form>
                        <script>
                            function redirectToCheckout(productId) {
                                const qty = document.getElementById(`qty_${productId}`).value; // Lấy giá trị từ input
                                const url = `checkout.php?get_id=${productId}&qty=${qty}`; // Tạo URL
                                window.location.href = url; // Chuyển hướng
                            }
                        </script>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty">
                        <p>No product added yet!<br>
                            <a href="add_products.php" style="margin-top:1.5rem;" class="btn">Add Product</a>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>