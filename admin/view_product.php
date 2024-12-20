<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location: login.php');
    exit();
}

if (isset($_POST['delete'])) {
    $p_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);

    if ($p_id) {
        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
        if ($delete_product->execute([$p_id])) {
            $success_msg[] = 'Product deleted successfully';
        } else {
            $error_msg[] = 'Failed to delete the product.';
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
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Tra xanh admin panel - All Products Page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>

    <div class="main_contain">
        <div class="banner">
            <h1>Products</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / All Products</span>
        </div>
        <section class="show_post">
            <h1 class="heading">Products</h1>
            <form method="POST" action="">
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
                    <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                    <?php if (!empty($fetch_products['image'])): ?>
                    <img src="../image/<?= $fetch_products['image']; ?>" class="image">
                    <?php endif; ?>
                    <div class="status"
                        style="color: <?= $fetch_products['status'] === 'active' ? 'green' : 'red'; ?>;">
                        <?= ucfirst($fetch_products['status']); ?>
                    </div>
                    <div class="price">$<?= $fetch_products['price']; ?>/-</div>
                    <div class="title"><?= htmlspecialchars($fetch_products['name']); ?></div>

                    <div class="purchase-count">Ordered: <?= $fetch_products['purchase_count']; ?> times</div>

                    <div class="flex-btn">
                        <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">Edit</a>
                        <button type="submit" name="delete" class="btn"
                            onclick="return confirm('Delete this product?');">Delete</button>
                        <a href="read_product.php?post_id=<?= $fetch_products['id']; ?>" class="btn">View</a>
                    </div>
                </form>
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
    <?php include '../components/alert.php'; ?>
</body>

</html>