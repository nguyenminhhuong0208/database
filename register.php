<?php
include 'components/connection.php';
session_start();

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';

}

//register user
if(isset($_POST['submit'])){
    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){
        $message[] = 'Email already exist!';
        echo 'Email already exist!';
    }else{
        if($pass != $cpass){
            $message[] = 'Comfirm your password';
            echo 'Comfirm your password';
        }else{
            $insert_user = $conn->prepare("INSERT INTO `users`(id,name,email,password) VALUES(?,?,?,?)");
            $insert_user->execute([$id,$name,$email,$pass]);
            header('location: home.php');
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
            $select_user->execute([$email, $pass]);
            $row = $select_user->fetch(PDO::FETCH_ASSOC);
            if($select_user->rowCount() > 0){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];

            }
        }
    }

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
    <title>Green tea - Resgiter now</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
        <img src="img/download.png">
        <h1>Register Now</h1>
        <p class="text"> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Delectus porro voluptate aspernatur exercitationem. Aliquam, reiciendis accusamus! </p>
    </div>
    <form action="" method="post">
        <div class="input-field">
            <p >Your name <sup>*</sup></p>
            <input type="text" name="name" required placeholder="Enter your name" maxlength="50">
        </div>
        <div class="input-field">
            <p >Your email <sup>*</sup></p>
            <input type="email" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>
        <div class="input-field">
            <p>Your password <sup>*</sup></p>
            <input type="password" name="pass" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>
        <div class="input-field">
            <p>Confirm password <sup>*</sup></p>
            <input type="password" name="cpass" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>

        <button type ="submit" name="submit" class="btn">Register now</button>
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>

        </section>
    </div>
</body>
</html><?php
include 'components/connection.php';
session_start();

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';

}

//register user
if(isset($_POST['submit'])){
    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){
        $message[] = 'Email already exist!';
        echo 'Email already exist!';
    }else{
        if($pass != $cpass){
            $message[] = 'Comfirm your password';
            echo 'Comfirm your password';
        }else{
            $insert_user = $conn->prepare("INSERT INTO `users`(id,name,email,password) VALUES(?,?,?,?)");
            $insert_user->execute([$id,$name,$email,$pass]);
            header('location: home.php');
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
            $select_user->execute([$email, $pass]);
            $row = $select_user->fetch(PDO::FETCH_ASSOC);
            if($select_user->rowCount() > 0){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];

            }
        }
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
    <title>Green tea - Resgiter now</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
        <img src="img/download.png">
        <h1>Register Now</h1>
        <p class="text"> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Delectus porro voluptate aspernatur exercitationem. Aliquam, reiciendis accusamus! </p>
    </div>
    <form action="" method="post">
        <div class="input-field">
            <p >Your name <sup>*</sup></p>
            <input type="text" name="name" required placeholder="Enter your name" maxlength="50">
        </div>
        <div class="input-field">
            <p >Your email <sup>*</sup></p>
            <input type="email" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>
        <div class="input-field">
            <p>Your password <sup>*</sup></p>
            <input type="password" name="pass" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>
        <div class="input-field">
            <p>Confirm password <sup>*</sup></p>
            <input type="password" name="cpass" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>

        <button type ="submit" name="submit" class="btn">Register now</button>
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>

        </section>
    </div>
</body>
</html>