<style type="text/css">
    <?php include 'styleregister.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green tea - Login now</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
        <div class="title">
                    <img src="img/download.png">
                    <h1>Green tea Page</h1>
                    <p class="text">Hello you, welcome to our green tea page!</p>
                </div>
            <div class = "button-container">
                    <a href="login.php">
                        <button class="btn">Login as a customer</button>
                    </a>  

                    <a href="admin/login.php">
                        <button class="btn">Login as an admin</button>
                    </a> 
            </div>
            <h4>Contact us</h4>
            <div class="box-container">
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
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include 'components/alert.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>