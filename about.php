<?php
include 'components/connection.php';
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
            <a href="home.php">Home</a> <span>\About</span>
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
                        <h1>Lemon Teaname</h1>
                        <a href="view_produccts.php" class="btn"> Shop now</a>
                    </div>
                </div>
                <div class="box">
                    <img src="img/about.png" alt="">
                    <div class="detail">
                        <span>Coffee</span>
                        <h1>Lemon green</h1>
                        <a href="view_produccts.php" class="btn"> Shop now</a>
                    </div>
                </div>

                <div class="box">
                    <img src="img/1.webp" alt="">
                    <div class="detail">
                        <span>Coffee</span>
                        <h1>Lemon green</h1>
                        <a href="view_produccts.php" class="btn"> Shop now</a>
                    </div>
                </div>
            </div>

            <section class="services">
                <div class="title">
                    <img src="img/download.png" alt="" class="logo">
                    <h1>Why choose us</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos sed excepturi cumque fuga dolore, ea eius cupiditate aspernatur maiores possimus error labore consectetur, molestias, iure sequi eaque provident reprehenderit amet.</p>
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
                            <h3> 24*7 support</h3>
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
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo beatae voluptates, accusamus quae quas autem magnam sit? Reprehenderit architecto nesciunt dolores, nobis quibusdam ipsam excepturi dolore, eaque repudiandae provident fugit?
                            Doloremque eaque exercitationem laborum veritatis incidunt accusamus cupiditate unde natus molestiae fugiat blanditiis, quod ex! Laborum consectetur sit facere, dolorem reiciendis ipsam, praesentium laboriosam, inventore delectus cum officia doloremque quibusdam?
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Itaque possimus aliquam sed eligendi dolores expedita laboriosam nemo a fuga, officia aut error voluptatum, voluptates est eos perspiciatis corrupti quidem hic!</p>
                        <a href="view_products.php" class="btn"> Shop now</a>

                    </div>
                </div>
            </div>

            <div class="testimonial-container">
                <div class="title">
                    <img src="img/download.png" alt="" class="logo">
                    <h1>What people say obout us</h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fuga, dolores. Animi sunt enim omnis maxime repellat? Nam quo dolor incidunt, deserunt asperiores quas minus atque recusandae distinctio molestias, inventore voluptatem?</p>

                </div>

                <div class="container">
                    <div class="testimonial-item active">
                        <img src="img/01.jpg" alt="">
                        <h1> Nguyen Doan Hoai Thuong</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa dolorum autem numquam magni delectus assumenda culpa. Eos porro perspiciatis id quod optio cum illum. Delectus eius debitis quae corrupti ipsum.
                            Ea tempora sapiente expedita nam voluptatibus, aut enim recusandae iusto sit dicta nihil aliquam eveniet exercitationem omnis fuga placeat deleniti dolorum unde repellat inventore? Velit excepturi consequuntur perferendis recusandae tempore.</p>
                    </div>
                    <div class="testimonial-item">
                        <img src="img/01.jpg" alt="">
                        <h1> Nguyen Doan Hoai Thuong</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa dolorum autem numquam magni delectus assumenda culpa. Eos porro perspiciatis id quod optio cum illum. Delectus eius debitis quae corrupti ipsum.
                            Ea tempora sapiente expedita nam voluptatibus, aut enim recusandae iusto sit dicta nihil aliquam eveniet exercitationem omnis fuga placeat deleniti dolorum unde repellat inventore? Velit excepturi consequuntur perferendis recusandae tempore.</p>
                    </div>
                    <div class="testimonial-item">
                        <img src="img/02.jpg" alt="">
                        <h1>Nguyen Minh Huong</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa dolorum autem numquam magni delectus assumenda culpa. Eos porro perspiciatis id quod optio cum illum. Delectus eius debitis quae corrupti ipsum.
                            Ea tempora sapiente expedita nam voluptatibus, aut enim recusandae iusto sit dicta nihil aliquam eveniet exercitationem omnis fuga placeat deleniti dolorum unde repellat inventore? Velit excepturi consequuntur perferendis recusandae tempore.</p>
                    </div>
                    <div class="testimonial-item">
                        <img src="img/03.jpg" alt="">
                        <h1> Nguyen Thi Thanh Tuyen</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa dolorum autem numquam magni delectus assumenda culpa. Eos porro perspiciatis id quod optio cum illum. Delectus eius debitis quae corrupti ipsum.
                            Ea tempora sapiente expedita nam voluptatibus, aut enim recusandae iusto sit dicta nihil aliquam eveniet exercitationem omnis fuga placeat deleniti dolorum unde repellat inventore? Velit excepturi consequuntur perferendis recusandae tempore.</p>
                    </div>
                    <div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
                    <div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
                </div>


            </div>
        </div>

        <!-- <?php //include 'components/footer.php'; 
                ?> -->

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>