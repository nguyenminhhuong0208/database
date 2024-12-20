<?php
include '../components/connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['category']) && $_GET['category'] === 'game') {
    // Prepare the query to fetch vouchers for the 'game' category
    $query = "SELECT * FROM voucher WHERE category = 'Game_Reward_Discount'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $vouchers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Set content type to JSON
    header('Content-Type: application/json');

    // Check if vouchers exist and return appropriate response
    if ($vouchers) {
        echo json_encode($vouchers);  // Return vouchers in JSON format
    } else {
        echo json_encode(["error" => "No vouchers found"]);  // Return error if no vouchers are found
    }

    exit;
}
?>