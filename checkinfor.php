<?php
$db_name = 'mysql:host=localhost;dbname=BTLcsdl';
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password);

if (!$conn) {
    echo "Can not connect to the database";
}

function getUserID(string $password, string $email)
{
    // Kiểm tra xem tên người dùng và email có hợp lệ không
    if (empty($password) || empty($email)) {
        return null; // Trả về null nếu tên người dùng hoặc email trống
    }

    $db = new mysqli('localhost', 'password', 'password', 'database_name');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Truy vấn tìm ID người dùng theo password và email
    $sql = "SELECT id FROM users WHERE password = ? AND email = ?";
    $stmt = $db->prepare($sql);

    // Gán tham số vào câu lệnh SQL
    $stmt->bind_param('ss', $password, $email);

    // Thực thi câu lệnh SQL
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userID);
        $stmt->fetch();
        return $userID; // Trả về ID người dùng
    } else {

        return null; // Không tìm thấy người dùng
    }

    // Đóng kết nối và statement
    $stmt->close();
    $db->close();
}

function checkPassword(string $password)
{
    $index = "?!@%^$&*";
    $lowerCase = "abcdefghijklmnopqrstuvwxyz";
    $upperCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $number = "0123456789";

    // Kiểm tra độ dài mật khẩu
    if (strlen($password) < 6) {
        return "* Password cannot be shorter than 6 characters.";
    }

    // Kiểm tra có ít nhất 1 ký tự đặc biệt
    $hasSpecialChar = false;
    for ($i = 0; $i < strlen($password); $i++) {
        if (strpos($index, $password[$i]) !== false) {
            $hasSpecialChar = true;
            break;
        }
    }

    // Kiểm tra có ít nhất 1 chữ cái viết thường
    $hasLowerCase = false;
    for ($i = 0; $i < strlen($password); $i++) {
        if (strpos($lowerCase, $password[$i]) !== false) {
            $hasLowerCase = true;
            break;
        }
    }

    // Kiểm tra có ít nhất 1 chữ cái viết hoa
    $hasUpperCase = false;
    for ($i = 0; $i < strlen($password); $i++) {
        if (strpos($upperCase, $password[$i]) !== false) {
            $hasUpperCase = true;
            break;
        }
    }

    // Kiểm tra có ít nhất 1 số
    $hasNumber = false;
    for ($i = 0; $i < strlen($password); $i++) {
        if (strpos($number, $password[$i]) !== false) {
            $hasNumber = true;
            break;
        }
    }

    // Kiểm tra tất cả các điều kiện
    if (!$hasSpecialChar) {
        return "* Password must contain at least one special character.";
    }

    if (!$hasLowerCase) {
        return "* Password must contain at least one lowercase letter.";
    }

    if (!$hasUpperCase) {
        return "* Password must contain at least one uppercase letter.";
    }

    if (!$hasNumber) {
        return "* Password must contain at least one number.";
    }

    // Nếu mật khẩu hợp lệ
    return "";
}

function checkProductStatus($productId)
{
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'your_database_name';

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT status FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);  // Bind the productId to the query
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();

    if ($status === "canceled") {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'getProducts') {
    function getProducts()
    {
        $db_name = 'mysql:host=localhost;dbname=BTLcsdl;charset=utf8';
        $user_name = 'root';
        $user_password = '';

        try {
            $conn = new PDO($db_name, $user_name, $user_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Truy vấn lấy sản phẩm
            $query = $conn->prepare("SELECT name FROM `products`");
            $query->execute();

            // Trả về danh sách sản phẩm
            return $query->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            // Trả về mảng trống nếu lỗi
            return [];
        }
    }

    header('Content-Type: application/json');
    echo json_encode(getProducts());
    exit;
}
function getOrdersByStatus($conn, $status)
{
    if ($status === '') {
        $select_orders = $conn->prepare("SELECT * FROM `orders`"); // Lấy tất cả đơn hàng nếu không có status
    } else {
        $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?"); // Lọc theo status
        $select_orders->execute([$status]);
    }

    $select_orders->execute();
    return $select_orders->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả các đơn hàng
}

function checkWishlist($conn, $userID, $productID)
{
    $query = $conn->prepare("SELECT 1 FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $query->execute([$userID, $productID]);

    if ($query->rowCount() > 0) {
        return "<i class='bx bxs-heart'></i>"; // Trái tim đầy nếu sản phẩm có trong wishlist
    } else {
        return "<i class='bx bx-heart'></i>"; // Trái tim rỗng nếu sản phẩm không có trong wishlist
    }
}
