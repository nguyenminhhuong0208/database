<?php
include 'components/connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = '';
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}


if (isset($_POST['logout'])) {
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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <title>Green Coffee - About us page</title>
</head>

<body>

    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>About us</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a> <span> / About</span>
        </div>
        <div class="class">
            <div class="about-category">
                <div class="box">
                    <img src="img/3.webp" alt="">
                    <div class="detail">
                        <span>Coffee</span>
                        <h1>Lemon green</h1>
                        <a href="view_products.php" class="btn"> Shop now</a>
                    </div>
                </div>
                <div class="box">
                    <img src="img/2.webp" alt="">
                    <div class="detail">
                        <span>Coffee</span>
                        <h1>Green Tea</h1>
                        <a href="view_products.php" class="btn"> Shop now</a>
                    </div>
                </div>
                <div class="box">
                    <img src="img/about.png" alt="">
                    <div class="detail">
                        <span>Coffee</span>
                        <h1>Matcha</h1>
                        <a href="view_products.php" class="btn"> Shop now</a>
                    </div>
                </div>

                <div class="box">
                    <img src="img/1.webp" alt="">
                    <div class="detail">
                        <span>Coffee</span>
                        <h1>Matcha Freeze</h1>
                        <a href="view_products.php" class="btn"> Shop now</a>
                    </div>
                </div>
            </div>

            <section class="services">
                <div class="title">
                    <img src="img/download.png" alt="" class="logo">
                    <h1>Why choose us</h1>
                    <p>Our products and services are designed with the environment in mind, helping you reduce your carbon footprint while enhancing your business efficiency</p>
                </div>
                <div class="box-container">
                    <div class="box">
                        <img src="img/icon2.png" alt="">
                        <div class="detail">
                            <h3> Great savings</h3>
                            <p>Save big every order</p>
                        </div>
                    </div>
                    <div class="box">
                        <img src="img/icon1.png" alt="">
                        <div class="detail">
                            <h3> 24/7 support</h3>
                            <p>One-on-one support</p>
                        </div>
                    </div>
                    <div class="box">
                        <img src="img/icon0.png" alt="">
                        <div class="detail">
                            <h3>Gift voucher</h3>
                            <p>Vouchers on every festivals</p>
                        </div>
                    </div>
                    <div class="box">
                        <img src="img/icon.png" alt="">
                        <div class="detail">
                            <h3> Great savings</h3>
                            <p>Save big every order</p>
                        </div>
                    </div>

                </div>
            </section>
            <div class="about">
                <div class="row">
                    <div class="img-box">
                        <img src="img/3.png" alt="">
                    </div>
                    <div class="detail">
                        <h1>Visit our beautiful showroom!</h1>
                        <p>🌿 Here, you can explore a carefully curated selection of premium green teas sourced from the finest tea gardens across the globe. From the vibrant notes of matcha to the soothing aroma of jasmine-infused blends, our collection caters to every tea lover's taste.

                            Not only will you find a variety of exquisite teas, but our showroom also features an array of high-quality tea brewing accessories, including traditional teapots, cups, and matcha whisk sets to elevate your tea experience. Our knowledgeable staff is always on hand to guide you through the selection process, offer brewing tips, and share the rich history and health benefits of green tea.</p>
                        <a href="view_products.php" class="btn"> Shop now</a>

                    </div>
                </div>
            </div>

            <div class="testimonial-container">
                <div class="title">
                    <img src="img/download.png" alt="" class="logo">
                    <h1>What people say about us</h1>
                    <p>
                        A magnificent trio of titans, united by vision, strength, and wisdom, forms an unstoppable force capable of shaping worlds and conquering any challenge.</p>
                    <p>Each brings unmatched brilliance to the group, creating a harmonious balance that elevates them to legendary status.</p>
                </div>

                <div class="container">
                    <div class="testimonial-item active">
                        <img src="img/01.jpg" alt="">
                        <h1> Nguyen Doan Hoai Thuong</h1>
                        <p>She is a magnificent girl, a true vision of strength, grace, and brilliance. With a heart full of kindness and a mind filled with wisdom, she inspires everyone around her to dream bigger and strive harder.Truly, she is a force to be reckoned with, a magnificent soul who leaves a lasting impact on everyone she meets.</p>
                    </div>
                    <div class="testimonial-item">
                        <img src="img/02.jpg" alt="">
                        <h1>Nguyen Minh Huong</h1>
                        <p>
                            She is a beautiful, smart, and amazing girl who effortlessly captivates everyone around her. Her intelligence is matched only by her grace, and she handles every challenge with confidence and poise. Whether through her sharp wit or her compassionate nature, she inspires those fortunate enough to know her. Her beauty isn't just skin deep; it's reflected in her character, kindness, and ability to make the world a better place. She's a true embodiment of strength, wisdom, and elegance, leaving a lasting impression wherever she goes.</p>
                    </div>
                    <div class="testimonial-item">
                        <img src="img/03.jpg" alt="">
                        <h1> Nguyen Thi Thanh Tuyen</h1>
                        <p>She is a beautiful, bright, and good-hearted girl whose presence lights up any room she enters. With a heart full of kindness and a mind full of curiosity, she radiates positivity and warmth. Her intelligence shines through in every conversation, and her genuine goodness is evident in her actions. She inspires those around her to be better, spreading joy and compassion wherever she goes. Truly, she is a remarkable person who embodies both beauty and brilliance, inside and out.</p>
                    </div>
                    <div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
                    <div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
                </div>


            </div>
        </div>

        <?php include 'components/footer.php';
        ?>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>