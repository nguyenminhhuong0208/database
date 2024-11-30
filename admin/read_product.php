<?php
        include '../components/connection.php';

        session_start();

        $admin_id = $_SESSION['admin_id'];

        if(!isset($admin_id)) {
            header('location: login.php');
        }

        $get_id = $_GET['post_id'];
        //delete product

        if(isset($_POST['delete'])){

                $p_id = $_POST['product_id'];
                $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

                $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $delete_image->execute(['$p_id']);

                $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

                if($fetch_delete_image['image'] != ''){
                    unlink('../image/'.$fetch_delete_image['image']);
                }

                $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
                $delete_product->execute([$p_id]);

                header('location:view_product.php');

        }


?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
        <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
        <title>Tra xanh admin panel - read products page</title>
</head>
<body>
        <?php include '../components/admin_header.php'; ?>
        <div class ="main_contain">
                <div class="banner">
                        <h1>read products</h1>
                </div>
                <div class="title2">
                        <a href="dashboard.php">dashboard</a><span>/ read products</span>
                </div>
        <section class="read-post">
                <h1 class="heading">read products</h1>
                <?php 
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_product->execute([$get_id]);

                if($select_product->rowCount() > 0){
                    while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){

                    
                
                ?>
                <form action="" method="post">
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                    <div class="status" style="color: <?php if($fetch_product['status'] == 'active'){echo "green";} else{ echo "red";} ?>"><?= $fetch_product['status']; ?></div>
                    <?php if($fetch_product['image'] != ''){ ?>
                        <img src="../image/<?=$fetch_product['image']; ?>" class="image">
                    <?php } ?>
                    <div class="price">$<?=$fetch_product['price']; ?>/-</div>
                    <div class="title"><?=$fetch_product['name']; ?></div>
                    <div class="content"><?=$fetch_product['product_detail']; ?></div>
                    <div class="flex-btn">
                        <a href="edit_product.php?id=<?=$fetch_product['id']; ?>" class="btn"> edit</a>
                        <button type="submit" name="delete" class="btn" onclick="return confirm('delete this product');"> delete</button>
                        <a href="view_product.php?id=<?=$get_id; ?>" class="btn"> go back</a>

                    </div>
                </form>
                <?php 

            }
    }else{
        echo'
    <div class = "empty">
            <p>No product added yet! <br> <a href="add_products.php" style="margin-top:1.5rem;" class="btn"> Add product</a></p>
    </div>
            ';
    }
            ?>
            
        
        </section>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script type="text/javascript" src="script.js"></script>
        <?php include '../components/alert.php'; ?>
</body>
</html>