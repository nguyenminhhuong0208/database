<?php
        include '../components/connection.php';

        session_start();

        $admin_id = $_SESSION['admin_id'];

        if(!isset($admin_id)) {
            header('location: login.php');
        }

        //add voucher in database

        if(isset($_POST['publish'])){
            $id = unique_id();

            $description = $_POST['description'];
            $description = filter_var($description, FILTER_SANITIZE_STRING);

            $requirement = $_POST['requirement'];
            $requirement = filter_var($requirement, FILTER_SANITIZE_STRING);

            $discount = $_POST['discount'];
            $discount = filter_var($discount, FILTER_SANITIZE_STRING);

            $quantity = $_POST['quantity'];
            $quantity = filter_var($quantity, FILTER_SANITIZE_STRING);

            $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
            
            $insert_voucher = $conn->prepare("INSERT INTO `voucher` (discount, requirement, description,qty,category) VALUES(?, ?, ?, ?,?)");
            $insert_voucher->execute([$discount, $requirement, $description, $quantity, $category]);
            $success_msg[] = 'voucher inserted successfully!';
        }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Tra xanh admin panel - add voucher page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main_contain">
        <div class="banner">
            <h1>add voucher</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">dashboard</a><span> / add voucher</span>
        </div>
        <section class="form-container">
            <h1 class="heading">add voucher</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-field">
                    <label>voucher description <sup>*</sup></label>
                    <textarea id="description-input" name="description" required maxlength="10000" required
                        placeholder="write voucher description"></textarea>
                </div>
                <div class="input-field">
                    <label>voucher category <sup>*</sup></label>
                    <select name="category" id="category-select">
                        <option value="Bulk_discount">Bulk discount</option>
                        <option value="Game_Reward_Discount">Game Reward Discount</option>
                        <option value="Special_Occasion_Voucher">Special Occasion Voucher</option>
                    </select>
                </div>
                <div class="input-field">
                    <label>voucher requirement <sup>*</sup></label>
                    <div class="flex-box">
                        <label id="dynamic-label">Have more than </label>
                        <input id="requirement-input" type="text" name="requirement" maxlength="100" required
                            placeholder="num">
                        <label id="unit-label">orders</label>
                    </div>
                </div>

                <div class="input-field">
                    <label>voucher discount <sup>*</sup></label>
                    <div class="flex-box">
                        <input id="discount-input" type="number" name="discount" maxlength="100" required
                            placeholder="discount">
                        <label>%</label>
                    </div>
                </div>
                <div class="input-field">
                    <label>quantity<sup>*</sup></label>
                    <input id="quantity-input" type="number" name="quantity" maxlength="100" required
                        placeholder="add voucher quantity">
                </div>
                <div class="flex-btn">
                    <button type="summit" name="publish" class="btn">publish voucher</button>
                    <button type="summit" name="draft" class="btn">save as draft</button>
                </div>
            </form>

            <div style="margin-top: 50px;">
                <label style="color:black;">Voucher Demo</label>
            </div>
            <div class="zigzag-border">
                <div class="wave-border"></div>
                <label id="demo-description" class="voucher-description">description</label>
                <label id="demo-discount" class="voucher-discount">discount %</label>
                <label id="demo-quantity" class="voucher-quantity">voucher remain</label>

            </div>

        </section>
    </div>

    <script>
    const categorySelect = document.getElementById('category-select');
    const unitLabel = document.getElementById('unit-label');
    const dynamicLabel = document.getElementById('dynamic-label');
    const requirementInput = document.getElementById('requirement-input');

    // Define label content for each category
    const labelUnitMapping = {
        "Bulk_discount": "orders",
        "Game_Reward_Discount": "score",
        "Special_Occasion_Voucher": "requirement"
    };
    const labelDynamicMapping = {
        "Bulk_discount": "Have more than",
        "Game_Reward_Discount": "Have more than",
        "Special_Occasion_Voucher": "Do not have to add"
    };

    // Add event listener to update the label dynamically
    categorySelect.addEventListener('change', function() {
        const selectedValue = categorySelect.value;
        unitLabel.textContent = labelUnitMapping[selectedValue] || "";
        dynamicLabel.textContent = labelDynamicMapping[selectedValue] || "";
        if (selectedValue === "Special_Occasion_Voucher") {
            requirementInput.style.display = "none"; // Hide input
        } else {
            requirementInput.style.display = "inline-block"; // Show input
        }
    });


    //demo voucher
    const demoDescription = document.getElementById('demo-description');
    const demoDiscount = document.getElementById('demo-discount');
    const demoQuantity = document.getElementById('demo-quantity');

    const descriptionInput = document.getElementById('description-input');
    const discountInput = document.getElementById('discount-input');
    const quantityInput = document.getElementById('quantity-input');

    descriptionInput.addEventListener('input', function() {
        demoDescription.textContent = descriptionInput.value || "description";
    });

    discountInput.addEventListener('input', function() {
        demoDiscount.textContent = "discount: " + discountInput.value + " %" || "discount %";
    });

    quantityInput.addEventListener('input', function() {
        demoQuantity.textContent = quantityInput.value + " vouchers remain" || "discount %";
    });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>

</html>