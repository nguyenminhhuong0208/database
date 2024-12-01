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
            <div class="box-container">
                <a href="login.php">
                    <button class="btn">Login as a customer</button>
                </a>  

                <a href="admin/login.php">
                    <button class="btn">Login as an admin</button>
                </a> 
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include 'components/alert.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>