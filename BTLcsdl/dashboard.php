<?php
        include './index.php';

        session_start();

        $admin_id = $_SESSION['admin_id'];

        if(!isset($admin_id)) {
            header('location: login.php');
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
        <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
        <title>Tra xanh admin panel - dashboard page</title>
</head>
<body>
        <?php include './admin_header.php'; ?>
        <div class ="main_contain">
            <section>

            </section>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script type="text/javascript" src="script.js"></script>
        <?php include './alert.php'; ?>
</body>
</html>