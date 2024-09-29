
<?php 
//include './alert.php';
include './index.php';
if(isset($_POST['register'])){
    $id = unique_id();

    $name = $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

    $pass = sha1($_POST['password']);
    $pass = filter_var($pass,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $confirmpass = sha1($_POST['confirmpass']);
    $confirmpass = filter_var($confirmpass,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $select_email = $connection->prepare("SELECT * FROM `admin` WHERE email = ?");
    $select_email->execute([$email]);

    if($select_email->rowCount() > 0){
        $warning_msg[] = 'Email already exits';
    }else{
        if($pass!= $confirmpass){
            $warning_msg[] = 'Confirm password not matched! Please do it again';
        }else{
            $insert_in = $connection-> prepare("INSERT INTO `admin` (id,name,email,password) VALUES(?,?,?,?)");
            $insert_in-> execute([$id, $name, $email, $confirmpass]);
            $success_msg[] = 'Register successfully!';
        }
    }


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="styleregister.css?v=<?php echo time(); ?>">
    <title>Register in our page</title>
</head>
<body>
    <div class ="main_contain">
        <section>
            <div class = "form_container" id = "admin_login">
                <form action="" method = "post" enctype="multipart/form-data">
                    <h3>Register now</h3>
                    <div class = "input_flied">
                        <label > User name <sup>*</sup></label>
                        <input type="text" name ="name" maxlength="20" required placeholder="Enter your username" oninput="this.value.replace(/\//g,'')">
                    </div>

                    <div class = "input_flied">
                        <label > User email <sup>*</sup></label>
                        <input type="email" name ="email" maxlength="20" required placeholder="Enter your email" oninput="this.value.replace(/\//g,'')">
                    </div>

                    <div class = "input_flied">
                        <label > Password <sup>*</sup></label>
                        <input type="password" name ="password" maxlength="20" required placeholder="Enter your password" oninput="this.value.replace(/\//g,'')">
                    </div>

                    <div class = "input_flied">
                        <label > Confirm password <sup>*</sup></label>
                        <input type="password" name ="confirmpass" maxlength="20" required placeholder="Confirm password" oninput="this.value.replace(/\//g,'')">
                    </div>

                    <button type ="submit" name="register" class="btn">Register now</button>
                    <p>Already have an account ? 
                        <a href="login.php"> Login now</a> </p>
                </form>

            </div>
        </section>
    </div>
    <?php include './alert.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>

</body>
</html>