<?php include 'components/alert.php';

?>

</body>
<html>
<header class="header">
    <div class="flex">
        <a href="home.php" class="logo"><img src="img/logo.jpg" alt="Logo"></a>
        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="view_products.php">products</a>
            <a href="order.php">orders</a>
            <a href="about.php">about us</a>
            <a href="contact.php">contact us</a>
        </nav>
        <div class="icons">
            <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_items = $count_wishlist_items->rowCount();
            ?>
            <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup><?= $total_wishlist_items ?></sup></a>
            <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
            ?>
            <a href="cart.php" class="cart-btn">
                <i class="bx bx-cart-download"></i><sup><?= $total_cart_items ?></sup>
            </a>
            <div class="search-container">
                <button class="search-button" onclick="toggleSearchArea()"><i class='bx bx-search-alt-2'></i></button>
                <!-- <input type="text" id="searchInput" class="search-input" placeholder="Type to search..."> -->
            </div>
            <div id="searchArea" class="search-area">
                <input
                    type="text"
                    id="searchInput"
                    class="search-input"
                    placeholder="Type to search..."
                    oninput="updateResults()">
            </div>
            <div id="resultBox" class="result-box">
                <p>Start typing to see results...</p>
            </div>
            <div class="icon">
                <i class="bx bxs-user" id="user-btn"></i>
                <!-- <i class="bx bx-list-plus" id="menu-btn"></i> -->
            </div>

            <!-- <a href="login.php" onclick="return confirm('Log out?');">
                <i class="bx bx-log-out"></i>
            </a> -->

        </div>

        <!-- <div class="user-box">
            <p>Username: <span><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest'; ?></span></p>
            <p>Email: <span><?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Not available'; ?></span></p>
            <a href="login.php" class="btn">login</a>
            <a href="register.php" class="btn">register</a>
            <form method="post">
                <button type="submit" name="logout" class="logout-btn">log out</button>
            </form>
        </div> -->
        <div class="profile-detail">
            <?php
            $query = $conn->prepare("SELECT name, email, dateob, gender, profile FROM users WHERE id = :user_id");
            $query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $query->execute();

            // Lấy dữ liệu của user
            if ($query->rowcount() > 0) {
                $user = $query->fetch(PDO::FETCH_ASSOC);

            ?>
                <div class="profile">
                    <img src="./image/<?= $user['profile'] ?? '0.jpg'; ?>" class="logo-img">
                    <p><?= $user['name']; ?></p> <!-- Sử dụng echo để in giá trị -->
                </div>
                <div class="flex-btn">
                    <a href="profile.php" class="btn">profile</a>
                    <a href="logout.php" onclick="return confirm('logout from this website');" class="btn">logout</a>
                </div>
            <?php } ?>
        </div>
</header>


</html>