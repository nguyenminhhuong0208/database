<?php
include '../components/connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu JSON từ body
    $data = json_decode(file_get_contents('php://input'), true);

    // Lấy user_id và voucher_id từ dữ liệu
    $userId = $data['user_id'] ?? null;
    $voucherId = $data['voucher_id'] ?? null;

    // Kiểm tra nếu thiếu userId hoặc voucherId
    if (!$userId || !$voucherId) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing user ID or voucher ID']);
        exit;
    }

    // Kiểm tra xem voucher có còn số lượng không
    $query = "SELECT qty FROM voucher WHERE id = ? AND qty > 0";
    $stmt = $conn->prepare($query);
    $stmt->execute([$voucherId]);
    $qty = $stmt->fetch(PDO::FETCH_ASSOC);
    // Nếu không còn voucher, trả về lỗi
    if ($qty <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Voucher not available']);
        exit;
    }

    // Giảm số lượng voucher trong bảng `voucher`
    $query = "UPDATE voucher SET qty = qty - 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$voucherId]);

    // Kiểm tra xem người dùng đã nhận voucher này chưa
    $select_user_voucher = "SELECT qty FROM user_voucher WHERE user_id = ? AND voucher_id = ?";
    $check_user_voucher = $conn->prepare($select_user_voucher);
    $check_user_voucher->execute([$userId, $voucherId]);

    // Nếu đã có voucher, cập nhật số lượng
    if ($check_user_voucher->rowCount() > 0) {
        $query = "UPDATE user_voucher SET qty = qty + 1 WHERE user_id = ? AND voucher_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$userId, $voucherId]);
    } else {
        // Nếu chưa có, thêm mới vào bảng user_voucher
        $query = "INSERT INTO user_voucher (user_id, voucher_id, qty)
                  VALUES (?, ?, 1)
                  ON DUPLICATE KEY UPDATE qty = qty + 1";
        $stmt = $conn->prepare($query);
        $stmt->execute([$userId, $voucherId]);
    }

    // Trả về thông báo thành công
    echo json_encode(['success' => 'Voucher granted']);
    exit;
}
?>