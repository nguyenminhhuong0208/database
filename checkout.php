<?php
include 'components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

    if(isset($_POST['logout'])) {
        session_destroy();
        header("location: login.php");
    }
    if (isset($_POST['place_order'])) {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $address = $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pincode'];
        $address = filter_var($address, FILTER_SANITIZE_STRING);
        $address_type = $_POST['address_type'];
        $address_type = filter_var($address_type, FILTER_SANITIZE_STRING);
        $method = $_POST['method'];
        $method = filter_var($method, FILTER_SANITIZE_STRING);

        $discounted_total = isset($_POST['discounted_total']) ? filter_var($_POST['discounted_total'], FILTER_VALIDATE_FLOAT) : 0;

        $voucher_id = isset($_POST['voucher']) ? $_POST['voucher'] : null;
            
        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
        $verify_cart->execute([$user_id]);
    
        if (isset($_GET['get_id'])) {
            $get_product = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
            $get_product->execute([$_GET['get_id']]);
            if ($get_product->rowCount() > 0) {
                while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                    echo "<pre>";
print_r([$user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'], 1]);
echo "</pre>";

                    $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, name, number, email, address, address_type, method, product_id, price, qty, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");

                    $insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'],$fetch_p['price']- $fetch_p['price']*$discounted_total/100, 1,"in progress"]);

                    if($voucher_id && $voucher_id != 0){
                        $update_voucher_qty = "UPDATE user_voucher SET qty = qty - 1 WHERE voucher_id = ? AND qty > 0";
                        $update_voucher = $conn->prepare($update_voucher_qty);
                        $update_voucher->execute([$voucher_id]);
                    }
                    header('location: order.php');
                    exit();
                }
            }else{
                $warning_msg[] = 'something went wrong';
            }
        }elseif ($verify_cart->rowCount()>0) {
            if ($verify_cart->rowCount() > 0) {
                while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
                    $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $f_cart['product_id'], $f_cart['price'] - $f_cart['price'] * $discounted_total / 100, 1]);
                }
                if ($insert_order) {
                    $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                    $delete_cart_id->execute([$user_id]);
                    header('location: order.php');
                }
                if($voucher_id && $voucher_id != 0){
                    $update_voucher_qty = "UPDATE user_voucher SET qty = qty - 1 WHERE voucher_id = ? AND qty > 0";
                    $update_voucher = $conn->prepare($update_voucher_qty);
                    $update_voucher->execute([$voucher_id]);
                }
            }            
        }else{
            $warning_msg[] = 'something went wrong';
        }
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
            <h1>checkout summary</h1>
        </div>
        <div class="title2">
            <a href="home.php">home</a><span>\ checkout summary</span>
        </div>
        <section class="checkout">
            <div class="title">
                <img src="img/download.png" class="logo">
                <h1>checkout summary</h1>
            </div>
            <div class="row">
                <form method="post">
                    <h3>Billing details</h3>
                    <div class="flex">
                        <div class="box">
                            <div class="input-field">
                                <?php
                                $select_user_information = $conn->prepare("SELECT * FROM USERS WHERE ID = ?");
                                $select_user_information->execute([$user_id]);
                                $fetch_user_information = $select_user_information->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <p>Your name <span>*</span></p>
                                <input type="text" name="name" required maxlength="50" placeholder="Enter Your name"
                                    class="input"
                                    value="<?php echo htmlspecialchars($fetch_user_information['name']); ?>">
                            </div>
                            <div class="input-field">
                                <p>Your number <span>*</span></p>
                                <input type="number" name="number" required maxlength="10"
                                    placeholder="Enter Your number" class="input">
                            </div>
                            <div class="input-field">
                                <p>Your email <span>*</span></p>
                                <input type="text" name="email" required maxlength="50" placeholder="Enter Your email"
                                    class="input"
                                    value="<?php echo htmlspecialchars($fetch_user_information['email']); ?>">
                            </div>
                            <div class="input-field">
                                <p>Payment method <span>*</span></p>
                                <select name="method" class="input">
                                    <option value="cash on delivery">cash on delivery</option>
                                    <option value="credit card">credit card</option>
                                    <option value="net banking">net banking</option>
                                    <option value="VNpay">VNpay</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <p>Address type<span>*</span></p>
                                <select name="address_type" class="input">
                                    <option value="home">home</option>
                                    <option value="office">office</option>
                                </select>
                            </div>
                        </div>
                        <div class="box">
                            <div class="input-field">
                                <p>address line 01 <span>*</span></p>
                                <input type="text" name="flat" required maxlength="50"
                                    placeholder="e.g flat & building number" class="input">
                            </div>
                            <div class="input-field">
                                <p>address line 02 <span>*</span></p>
                                <input type="text" name="street" required maxlength="50" placeholder="e.g street name"
                                    class="input">
                            </div>
                            <div class="input-field">
                                <p>city name <span>*</span></p>
                                <input type="text" name="city" required maxlength="50"
                                    placeholder="Enter your city name" class="input">
                            </div>
                            <div class="input-field">
                                <p>country name <span>*</span></p>
                                <input type="text" name="country" required maxlength="50"
                                    placeholder="Enter your city name" class="input">
                            </div>
                            <div class="input-field">
                                <p>pincode <span>*</span></p>
                                <input type="number" name="pincode" required maxlength="6" placeholder="110022" min="0"
                                    max="999999" class="input">
                            </div>
                            <div class="input-field">
                                <p>Choose a voucher (optional)</p>
                                <select name="voucher" id="voucher-select" class="input">
                                    <option value="0">-- Select Voucher --</option>
                                    <?php
                                        $select_vouchers = $conn->prepare("SELECT V.*, UV.qty AS voucher_count
                                        FROM VOUCHER V
                                        LEFT JOIN USER_VOUCHER UV ON V.id = UV.voucher_id
                                        WHERE UV.user_id = ? AND UV.qty>0
                                        GROUP BY UV.voucher_id,UV.user_id;");
                                        $select_vouchers->execute([$user_id]);
                                        while ($voucher = $select_vouchers->fetch(PDO::FETCH_ASSOC)) {
                                            $voucher_name = htmlspecialchars($voucher['description']); // Escape special characters
                                            $voucher_discount = htmlspecialchars($voucher['discount']); // Escape special characters
                                            echo "<option value='{$voucher['id']}' data-discount='{$voucher['discount']}'>$voucher_name - $voucher_discount% off</option>";
                                        }
                                    ?>
                                </select>
                                <input type="hidden" name="discounted_total" id="hidden-discounted-amount" value=0>

                            </div>

                        </div>
                    </div>
                    <button type="submit" name="place_order" class="btn">Place Order</button>
                </form>

                <div class="summary">
                    <h3>my bag</h3>
                    <div class="box-container">
                        <?php
                            $grand_total = 0;
                            if (isset($_GET['get_id'])) {
                                $select_get = $conn->prepare("SELECT * FROM `products` WHERE id=?");
                                $select_get->execute([$_GET['get_id']]);
                                while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                                    $sub_total = $fetch_get['price'];
                                    $grand_total += $sub_total;
                            ?>
                        <div class="flex">
                            <img src="image/<?= $fetch_get['image']; ?>" class="image">
                            <div>
                                <h3 class="name"><?= $fetch_get['name']; ?></h3>
                                <p class="price"><?= $fetch_get['price']; ?></p>
                            </div>
                        </div>
                        <?php
                                }
                            }else {
                                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
                                $select_cart->execute([$user_id]);
                                if ($select_cart->rowCount() > 0) {
                                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id=?");
                                        $select_products->execute([$fetch_cart['product_id']]);
                                        $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                                        $sub_total = ($fetch_cart['qty'] * $fetch_product['price']);
                                        $grand_total += $sub_total;
                            ?>
                        <div class="flex">
                            <img src="image/<?= $fetch_product['image']; ?>" class="image">
                            <div>
                                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                <p class="price"><?= $fetch_product['price']; ?> X <?= $fetch_cart['qty']; ?></p>
                            </div>
                        </div>
                        <?php
                                }
                            } else {
                                echo '<p class="empty">your cart is empty</p>';
                            }
                        }
                        ?>
                    </div>
                    <div class="grand-total">
                        <span>total amount payable: </span>$<?= $grand_total; ?>/-
                    </div>
                </div>
            </div>
            <div class="grand-total">
                <p>Total amount payable: <span id="total-amount">$<?= number_format($grand_total, 2); ?></span>
                </p>
            </div>
    </div>
    </div>
    <div id="voucher-info">
        <?php $voucher_id = $_POST['voucher'] ?? null; ?>
        Selected Voucher ID: <?php echo $voucher_id ? htmlspecialchars($voucher['discount']) : "None"; ?>
    </div>


    </section>

    <!-- //<?php include 'components/footer.php'; ?> -->
    </div>
    <script type="text/javascript" src="script.js"></script>
</body>


<script>
// Lấy phần tử select và div
const voucherSelect = document.getElementById('voucher-select');
const voucherInfo = document.getElementById('voucher-info');

// Lắng nghe sự thay đổi của select
voucherSelect.addEventListener('change', function() {
    const selectedVoucherId = voucherSelect.value; // Lấy giá trị của tùy chọn đã chọn
    if (selectedVoucherId) {
        voucherInfo.innerHTML = `Selected Voucher ID: ${selectedVoucherId}`;
    } else {
        voucherInfo.innerHTML = "Selected Voucher ID: None";
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const voucherSelect = document.getElementById("voucher-select");
    const totalAmountSpan = document.getElementById("total-amount");
    const hiddenDiscountedAmount = document.getElementById("hidden-discounted-amount");
    const grandTotal = parseFloat(<?= $grand_total; ?>);

    voucherSelect.addEventListener("change", function() {
        const selectedOption = this.options[this.selectedIndex];
        const selectedVoucherId = selectedOption.value;
        const discount = parseFloat(selectedOption.getAttribute('data-discount')) ||
            0; // Lấy discount từ data-discount
        const discountedAmount = grandTotal * (1 - discount / 100);
        totalAmountSpan.textContent = `$${discountedAmount.toFixed(2)}`;
        hiddenDiscountedAmount.value = discount.toFixed(2);

    });
});
</script>


</html>