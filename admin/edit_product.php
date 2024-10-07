<?php
        include '../components/connection.php';

        session_start();

        $admin_id = $_SESSION['admin_id'];

        if(!isset($admin_id)) {
            header('location: login.php');
        }


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
        <title>Tra xanh admin panel - edit products page</title>
</head>
<body>
        <?php include '../components/admin_header.php'; ?>
        <div class ="main_contain">
                <div class="banner">
                        <h1>edit products</h1>
                </div>
                <div class="title2">
                        <a href="dashboard.php">dashboard</a><span>/ edit products</span>
                </div>
        <section class="edit-post">
                <h1 class="heading">edit products</h1>
                <?php 
                $post_id = $_GET['id'];
                $select_product = $conn->prepare("SELECT *FROM `products` WHERE id = ?");
                $select_product->execute([$post_id]);

                if($select_product->rowCount() > 0){
                    while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){

                    
                ?>
                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">
                        <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                        <div class="input-field">
                            <label> update status</label>
                            <select name="status">
                                <option selected disabled value="<?= $fetch_product['status']; ?>"><?= $fetch_product['image']; ?> </option>
                                <option value="active">active</option>
                                <option value="deactive">deactive</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>product name</label>
                            <input type="text" name="name" value="<?= $fetch_product['name']; ?>">

                        </div>

                        <div class="input-field">
                            <label>product price</label>
                            <input type="number" name="price" value="<?= $fetch_product['price']; ?>"> 
                        </div>
                    </form>
                </div>
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