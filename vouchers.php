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

if (isset($_POST['get_voucher'])) {
    $id = unique_id();
    if (isset($_POST['voucher_id']) && !empty($_POST['voucher_id'])) {
        $voucher_id = $_POST['voucher_id'];
    } else {
        $warning_msg[] = 'Voucher ID is missing.';
    }

    $query = "SELECT * 
            FROM voucher
            WHERE id = ?";
    $select_get_voucher=$conn->prepare($query);
    $select_get_voucher->execute([$voucher_id]);

    if ($select_get_voucher->rowCount() > 0) {
        $fetch_voucher = $select_get_voucher->fetch(PDO::FETCH_ASSOC); // Lấy thông tin voucher
        
        if ($fetch_voucher['category'] === "Game_Reward_Discount") {
            $warning_msg[] = 'Please play a game to get this voucher.';
        } elseif ($fetch_voucher['category'] === "Bulk_discount") {
            $select_count_order = "SELECT COUNT(*) AS order_count FROM orders WHERE user_id = ?";
            $count_order = $conn->prepare($select_count_order);
            $count_order->execute([$user_id]);
            $fetch_count_order=$count_order->fetch(PDO::FETCH_ASSOC);
            if ($fetch_count_order['order_count'] >= $fetch_voucher['requirement']) {
                // Giảm số lượng voucher trong bảng `vouchers`
                $update_voucher_qty = "UPDATE voucher SET qty = qty - 1 WHERE id = ? AND qty > 0";
                $update_voucher = $conn->prepare($update_voucher_qty);
                $update_voucher->execute([$voucher_id]);
        
                if ($update_voucher->rowCount() > 0) { // Chỉ tiếp tục nếu giảm thành công (tồn tại voucher đủ số lượng)
                    // Kiểm tra xem người dùng đã sở hữu voucher này chưa
                    $select_user_voucher = "SELECT qty FROM user_voucher WHERE user_id = ? AND voucher_id = ?";
                    $check_user_voucher = $conn->prepare($select_user_voucher);
                    $check_user_voucher->execute([$user_id, $voucher_id]);
        
                    if($select_get_voucher->rowCount() > 3) {
                        $warning_msg[] = 'You already have 3 of these vouchers, so you cannot get more';
                        $update_voucher_qty = "UPDATE voucher SET qty = qty + 1 WHERE id = ? AND qty > 0";
                        $update_voucher = $conn->prepare($update_voucher_qty);
                        $update_voucher->execute([$voucher_id]);
                        exit();
                    }else if ($check_user_voucher->rowCount() > 0) {
                        // Nếu đã sở hữu, tăng số lượng voucher của người dùng
                        $update_user_voucher_qty = "UPDATE user_voucher SET qty = qty + 1 WHERE user_id = ? AND voucher_id = ?";
                        $update_user_voucher = $conn->prepare($update_user_voucher_qty);
                        $update_user_voucher->execute([$user_id, $voucher_id]);
                    } else {
                        // Nếu chưa sở hữu, thêm một dòng mới vào bảng `user_voucher`
                        $insert_user_voucher = "INSERT INTO user_voucher (user_id, voucher_id, qty) VALUES (?, ?, 1)";
                        $add_user_voucher = $conn->prepare($insert_user_voucher);
                        $add_user_voucher->execute([$user_id, $voucher_id]);
                    }
        
                    // Thông báo thành công
                    $success_msg[] = 'You got this voucher!';
                } else {
                    // Nếu không giảm được số lượng voucher, thông báo lỗi
                    $warning_msg[] = 'Sorry, no vouchers left.';
                }
            } else {
                $warning_msg[] = 'You do not meet the requirements.';
            }
        }else if ($fetch_voucher['category'] === "Special_Occasion_Voucher") {
            if($fetch_voucher['qty'] > 0) {
                $update_voucher_qty = "UPDATE voucher SET qty = qty - 1 WHERE id = ? AND qty > 0";
                $update_voucher = $conn->prepare($update_voucher_qty);
                $update_voucher->execute([$voucher_id]);
        
                if ($update_voucher->rowCount() > 0) { // Chỉ tiếp tục nếu giảm thành công (tồn tại voucher đủ số lượng)
                    // Kiểm tra xem người dùng đã sở hữu voucher này chưa
                    $select_user_voucher = "SELECT qty FROM user_voucher WHERE user_id = ? AND voucher_id = ?";
                    $check_user_voucher = $conn->prepare($select_user_voucher);
                    $check_user_voucher->execute([$user_id, $voucher_id]);
                    $user_voucher_data = $check_user_voucher->fetch(PDO::FETCH_ASSOC);

                    // Kiểm tra số lượng voucher của người dùng
                    if ($user_voucher_data['qty'] >= 3) {
                        $update_voucher_qty = "UPDATE voucher SET qty = qty + 1 WHERE id = ? AND qty > 0";
                        $update_voucher = $conn->prepare($update_voucher_qty);
                        $update_voucher->execute([$voucher_id]);
                        $warning_msg[] = 'You already have 3 of these vouchers, so you cannot get more';
                    }else if ($check_user_voucher->rowCount() > 0) {
                        // Nếu đã sở hữu, tăng số lượng voucher của người dùng
                        $update_user_voucher_qty = "UPDATE user_voucher SET qty = qty + 1 WHERE user_id = ? AND voucher_id = ?";
                        $update_user_voucher = $conn->prepare($update_user_voucher_qty);
                        $update_user_voucher->execute([$user_id, $voucher_id]);
                    } else {
                        // Nếu chưa sở hữu, thêm một dòng mới vào bảng `user_voucher`
                        $insert_user_voucher = "INSERT INTO user_voucher (user_id, voucher_id, qty) VALUES (?, ?, 1)";
                        $add_user_voucher = $conn->prepare($insert_user_voucher);
                        $add_user_voucher->execute([$user_id, $voucher_id]);
                    }
        
                    // Thông báo thành công
                    $success_msg[] = 'You got this voucher!';
                } else {
                    // Nếu không giảm được số lượng voucher, thông báo lỗi
                    $warning_msg[] = 'Sorry, no vouchers left.';
                }
            } else {
                $warning_msg[] = 'You do not meet the requirements.';
            }
        } else {
            $warning_msg[] = 'i do not know';
        }
    } else {
        $warning_msg[] = 'Voucher not found.';
    }
}


$criteria = isset($_POST['criteria']) ? $_POST['criteria'] : "all vouchers";
$valid_criteria = ["all vouchers", "my vouchers", "best vouchers"];

if (!in_array($criteria, $valid_criteria)) {
    $criteria = "all vouchers"; 
}
if ($criteria === "my vouchers") {
    $query = "SELECT V.*, UV.qty AS voucher_count
          FROM VOUCHER V
          LEFT JOIN USER_VOUCHER UV ON V.id = UV.voucher_id
          WHERE UV.user_id = ? AND UV.qty>0
          GROUP BY UV.voucher_id,UV.user_id;";
    $search_product = $conn->prepare($query);
    $search_product->execute([$user_id]);
} elseif ($criteria === "best vouchers") {
    $query = "SELECT V.*, UV.qty  AS voucher_count
          FROM VOUCHER V
          LEFT JOIN USER_VOUCHER UV ON V.id = UV.voucher_id
          GROUP BY V.id
          ORDER BY V.discount DESC;";
    $search_product = $conn->prepare($query);
    $search_product->execute();
} else {
    $query = "SELECT V.*, UV.qty AS voucher_count
          FROM VOUCHER V
          LEFT JOIN USER_VOUCHER UV ON V.id = UV.voucher_id
          GROUP BY V.id;";
    $search_product = $conn->prepare($query);
    $search_product->execute();
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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <title>Green Coffee - checkout page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Voucher hunting</h1>
        </div>
        <div class="title2">
            <a href="home.php">home</a><span> / Voucher hunting</span>
        </div>
        <section class="voucher">
            <div class="title">
                <img src="img/download.png" class="logo">
                <h1>Voucher hunting</h1>
                <p>let's hunt vouchers</p>
            </div>
            <!-- search criteria -->
            <form method="POST" action="" class="choiceBox">
                <select name="criteria">
                    <option value="all vouchers" <?= $criteria === "all vouchers" ? "selected" : ""; ?>>All Vouchers
                    </option>
                    <option value="my vouchers" <?= $criteria === "my vouchers" ? "selected" : ""; ?>>My Vouchers
                    </option>
                    <option value="best vouchers" <?= $criteria === "best vouchers" ? "selected" : ""; ?>>Best vouchers
                    </option>
                </select>
                <input type="hidden" name="voucher_id" value="<php= $fetch_voucher['v.id']; ?>">
                <button type=" submit" class="btn">search</button>
            </form>

            <div>
                <div>
                    <h3>vouchers</h3>
                    <div class="box-container">
                        <?php
        if ($search_product->rowCount() > 0) {
            while ($fetch_voucher = $search_product->fetch(PDO::FETCH_ASSOC)) {
        ?>
                        <div class="summary">
                            <div class="zigzag-border">
                                <div class="wave-border">
                                </div>
                                <label class="voucher-description"><?= $fetch_voucher['description']; ?></label>
                                <label class="voucher-discount">Discount: <?= $fetch_voucher['discount']; ?>%</label>
                                <label class="voucher-quantity">Require: <?= $fetch_voucher['requirement']; ?></label>
                                <label class="voucher-quantity">You have: <?= $fetch_voucher['voucher_count']; ?>
                                    vouchers</label>

                                <form method="POST" class="button-container">
                                    <input type="hidden" name="voucher_id" value="<?= $fetch_voucher['id']; ?>">
                                    <button type="submit" name="get_voucher" class="btn">Get voucher</button>
                                </form>
                            </div>
                        </div>
                        <?php
        }
    } else {
        echo '<p class="empty">No vouchers available for the selected criteria.</p>';
    }
    ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- //<?php include 'components/footer.php'; ?> -->
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>