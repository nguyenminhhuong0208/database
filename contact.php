<?php
include 'components/connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = '';
}

if (isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = '';
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// Message sending

if (isset($_POST['submit-btn'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $message = $_POST['message'];

    // Insert message into database 
    $insert_message = $conn->prepare("INSERT INTO `message` (user_id, name, email, message) VALUES (?, ?, ?, ?)");
    $insert_message->execute([$user_id, $name, $email, $message]);
    $success_msg[] = 'Message sent successfully!';
    // echo 'Message sent successfully';

    //e xoa doan nay nua de no hien thong bao
    //vang a
    // Redirect with success parameter
    //header("Location: contact.php?success=1");
    //exit;
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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <title>Green Coffee - contact page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Contact us</h1>
        </div class="form-container">
        <form action="" method="post">
            <div class="title">
                <img src="img/download.png" class="logo">
                <h1>Leave a message</h1>
            </div>
            <div class="input-field">
                <p>Your name <sup>*<sup></p>
                <input type="text" name="name">
            </div>
            <div class="input-field">
                <p>Your email <sup>*<sup></p>
                <input type="email" name="email">
            </div>
            <div class="input-field">
                <p>Your message <sup>*<sup></p>
                <textarea name="message" id=""></textarea>
            </div>
            <button type="submit" name="submit-btn" class="btn">Send message</button>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <!-- <p class="success-message">Message sent successfully!</p> -->
            <?php endif; ?>
        </form>
    </div>
    <div class="address">
        <div class="title">
            <img src="img/download.png" alt="" class="logo">
            <h1>Contact detail</h1>
        </div>

        <div class="box-container">
            <div class="box">
                <i class="bx bxs-map-pin"></i>
                <div>
                    <h4>Address</h4>
                    <p>Truong Dai Hoc Cong Nghe</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-call"></i>
                <div>
                    <h4>Facebook</h4>
                    <p><?php
                        echo '<a href="https://www.facebook.com/profile.php?id=100029231884618" target="_blank">Minh Huong</a>';
                        ?></p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-call"></i>
                <div>
                    <h4>Facebook</h4>
                    <p><?php
                        echo '<a href="https://www.facebook.com/profile.php?id=100051391368220" target="_blank">Thanh Tuyen</a>';
                        ?></p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-call"></i>
                <div>
                    <h4>Facebook</h4>
                    <p><?php
                        echo '<a href="https://www.facebook.com/hoaithuon.me" target="_blank">Hoai Thuong</a>';
                        ?></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>