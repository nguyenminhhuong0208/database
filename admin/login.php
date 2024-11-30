<?php
    include '../components/connection.php';

    session_start();

    if(isset($_POST['login'])){

        $email = $_POST['email'];
        $email = filter_var($email,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $pass = sha1($_POST['password']);
        $pass = filter_var($pass,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ?
        AND password = ?");
        $select_admin->execute([$email,$pass]);

        if ($select_admin->rowCount() >0) {
            $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
            $_SESSION['admin_id'] = $fetch_admin_id['id'];
            header('location:dashboard.php');
        } else {
            $warning_msg[] = 'incorrect email or password';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>ra xanh admin panel - Login</title>
</head>
<body>
    <div class ="main_contain">
        <section>
            <div class = "form_container" id = "admin_login">
                <form action="" method = "post" enctype="multipart/form-data">
                    <h3>Admin Login</h3>

                    <div class = "input_flied">
                        <label > User email <sup>*</sup></label>
                        <input type="email" name ="email" maxlength="20" required placeholder
                        ="Enter your email" oninput="this.value.replace(/\//g,'')">
                    </div>

                    <div class = "input_flied">
                        <label > Password <sup>*</sup></label>
                        <input type="password" name ="password" maxlength="20" required
                        placeholder="Enter your password" oninput="this.value.replace(/\s/g,'')">
                    </div>

                    <button type ="submit" name="login" class="btn">Login now</button>
                </form>
                <a href="../login.php">
                    <button class="btn">User now</button>
                </a>
                <p>Do not have an account ?
                    <a href="register.php"> Register now</a> </p>

            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include '../components/alert.php'; ?>
    <script type="text/javascript" src="script.js"></script>

</body>
</html>