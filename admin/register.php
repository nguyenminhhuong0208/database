<?php
include '../components/alert.php';
include '../components/connection.php';
if (isset($_POST['register'])) {

    $id = unique_id();

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $pass = sha1($_POST['password']);
    $pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $confirmpass = sha1($_POST['confirmpass']);
    $confirmpass = filter_var($confirmpass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../image/' . $image;

    $select_email = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
    $select_email->execute([$email]);

    if ($select_email->rowCount() > 0) {
        $warning_msg[] = 'Email already exits';
    } else {
        if ($pass != $confirmpass) {
            $warning_msg[] = 'Confirm password not matched! Please do it again';
        } else {
            $insert_in = $conn->prepare("INSERT INTO `admin` (id,name,email,password,profile)
             VALUES(?,?,?,?,?)");
            $insert_in->execute([$id, $name, $email, $confirmpass, $image]);
            move_uploaded_file($image_tmp_name, $image_folder);
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
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Register in our page</title>
</head>

<body>
    <div class="main_contain">
        <section>
            <div class="form_container" id="admin_login">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>Register Admin now</h3>
                    <div class="input_flied">
                        <label> User name </label>
                        <input type="text" name="name" maxlength="20" required placeholder="Enter your username" oninput="this.value.replace(/\s/g,'')">
                    </div>

                    <div class="input_flied">
                        <label> User email </label>
                        <input type="email" name="email" maxlength="20" required placeholder="Enter your email" oninput="this.value.replace(/\s/g,'')">
                    </div>

                    <div class="input_flied">
                        <label> Password</label>
                        <input type="password" name="password" maxlength="20" required placeholder="Enter your password" oninput="this.value.replace(/\s/g,'')">
                    </div>

                    <div class="input_flied"><label> Confirm password <sup>*</sup></label>
                        <input type="password" name="confirmpass" maxlength="20" required
                            placeholder="Confirm password" oninput="this.value.replace(/\s/g,'')">
                    </div>

                    <div class="input_flied">
                        <label> Select profile <sup>*</sup></label>
                        <input type="file" name="image" accept="image">
                    </div>

                    <button type="submit" name="register" class="btn">Register now</button>
                    <p>Already have an account ?
                        <a href="login.php"> Login now</a>
                    </p>
                </form>

            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>

</html>