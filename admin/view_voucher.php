<?php
        include '../components/connection.php';

        session_start();

        $admin_id = $_SESSION['admin_id'];

        if(!isset($admin_id)) {
            header('location: login.php');
        }

        //delete voucher

        if(isset($_POST['delete'])){

                $p_id = $_POST['voucher_id'];
                $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

                $delete_voucher = $conn->prepare("DELETE FROM `voucher` WHERE id = ?");
                $delete_voucher->execute([$p_id]);

                $success_msg[] = 'voucher deleted successfully';
        }


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Tra xanh admin panel - all voucher page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main_contain">
        <div class="banner">
            <h1>all voucher</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">dashboard</a><span> / all voucher</span>
        </div>
        <section class="show_post">
            <h1 class="heading">all voucher</h1>
            <div class="box-container">
                <?php
                       $select_voucher = $conn->prepare("SELECT * FROM `voucher`");
                       $select_voucher->execute();

                        while ($fetch_voucher = $select_voucher->fetch(PDO::FETCH_ASSOC))
                        {
                       
                       ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="id" value="<?= $fetch_voucher['id']; ?>">
                    <div class="zigzag-border">
                        <div class="wave-border"></div>
                        <label id="demo-description"
                            class="voucher-description"><?= $fetch_voucher['description']?></label>
                        <label id="demo-discount" class="voucher-discount">discount :<?= $fetch_voucher['discount']?>
                            %</label>
                        <label id="demo-quantity" class="voucher-quantity"><?= $fetch_voucher['qty']?> voucher
                            remain</label>
                    </div>
                </form>
                <?php 
                        }
                ?>

            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>

</html>