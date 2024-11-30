<?php
include 'components/connection.php';
session_start();

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

if(isset($_POST['submit'])){
   
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email,$pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount()>0) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        header('location: home.php');
    } else {
        $warning_msg[] = 'incorrect username or password';
    }
}
?>


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
        <h1>User Login</h1>
        <p class="text"> Hi there, let's buy green tea !</p>
    </div>
    <form action="" method="post">
    
        <div class="input-field">
            <p >Your email <sup>*</sup></p>
            <input type="email" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>
        <div class="input-field">
            <p>Your password <sup>*</sup></p>
            <input type="password" name="pass" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>

        <button type="submit" name="submit" class="btn">Login now</button>

          
        <p>Do not have an account? <a href="register.php">Register now</a></p>
    </form>
        <a href="admin/login.php">
            <button class="btn">Admin now</button>
        </a>  
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include 'components/alert.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>