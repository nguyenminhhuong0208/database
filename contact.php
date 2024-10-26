<?php
include 'components/connection.php';
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';

}

if(isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" >
    <title>Green Coffee - contact page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
    <div class="banner">
        <h1>Contact us</h1>
    </div>
    <div class="title2">
        <a href="home.php"> Home</a> <span>/ contact us</span>
    </div>
    <div class="form-container">
        <form method="post">
            <div class="title">
                <img src="img/download.png" alt="" class="logo">
                <h1>Leave a message</h1>
            </div>
            <div class="input-field">
                <p>Your name <sup>*</sup> </p>
                <input type="text" name="name">
            </div>
            <div class="input-field">
                <p>Your email <sup>*</sup> </p>
                <input type="email" name="email">
            </div>
            <div class="input-field">
                <p>Your number <sup>*</sup> </p>
                <input type="text" name="number">
            </div>
            <div class="input-field">
                <p>Your message <sup>*</sup> </p>
                <textarea name="message" id=""></textarea>
            </div>
            <button type="submit" name="submit-btn" class="btn"> Send message</button>

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
                        <p>100 WestStone Lane, Milky Way</p>
                    </div>
                </div>
                <div class="box"> 
                    <i class="bx bxs-phone-call"></i>
                    <div>
                        <h4>Phone number</h4>
                        <p>0367731245</p>
                    </div>
                </div>
                <div class="box"> 
                    <i class="bx bxs-map-pin"></i>
                    <div>
                        <h4>Email </h4>
                        <p>myHeartbumpbump512@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>