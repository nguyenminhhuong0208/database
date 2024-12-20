<?php
include './components/connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}

$total_products_query = $conn->prepare("SELECT COUNT(*) FROM orders");
$total_products_query->execute();
$total_products = $total_products_query->fetchColumn();

// Số sản phẩm trên mỗi trang
$products_per_page = 8;

// Tính tổng số trang
$total_pages = ceil($total_products / $products_per_page);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Tính vị trí bắt đầu
$offset = ($page - 1) * $products_per_page;

$query = $conn->prepare("SELECT products.name AS product_name,orders.qty as qty, orders.price as price, orders.date as date, orders.status as status
                         FROM orders 
                         JOIN products ON orders.product_id = products.id 
                         WHERE orders.user_id = :user_id
                         ORDER BY orders.date DESC
                         LIMIT :offset, :limit");
$query->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->bindValue(':limit', $products_per_page, PDO::PARAM_INT);
$query->execute();

$orders = $query->fetchAll(PDO::FETCH_ASSOC);

$canceled = $conn->prepare("SELECT products.name AS product_name,orders.qty as qty, orders.price as price, orders.date as date, orders.status as status
                         FROM orders 
                         JOIN products ON orders.product_id = products.id 
                         WHERE orders.user_id = :user_id and orders.status = 'canceled'
                         ORDER BY orders.date DESC
                         LIMIT :offset, :limit");
$canceled->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$canceled->bindValue(':offset', $offset, PDO::PARAM_INT);
$canceled->bindValue(':limit', $products_per_page, PDO::PARAM_INT);
$canceled->execute();

$cancelorders = $canceled->fetchAll(PDO::FETCH_ASSOC);

$message = $conn->prepare("SELECT message.name as name,message.email as email,  message, subject
                         FROM message 
                         JOIN users ON users.id = message.user_id
                         WHERE message.user_id = :user_id 
                         LIMIT :offset, :limit");
$message->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$message->bindValue(':offset', $offset, PDO::PARAM_INT);
$message->bindValue(':limit', $products_per_page, PDO::PARAM_INT);
$message->execute();

$messages = $message->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['save-infor'])) {
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $name = $_POST['fullname'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['dob'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST['gender'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    // $image = $_POST['profile_image'];
    // $image = filter_var($image, FILTER_SANITIZE_URL);

    $image = $_FILES['profile_image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_tmp_name = $_FILES['profile_image']['tmp_name'];
    $image_folder = 'image/' . $image;
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($image_extension, $allowed_extensions)) {
        $select_user = $conn->prepare("SELECT * FROM users WHERE email = ? and id != ?");
        $select_user->execute([$email, $user_id]);
        //$row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($select_user->rowCount() > 0) {
            $warning_msg[] = 'Email already exist!';
            echo 'Email already exist!';
        } else {
            $update_user = $conn->prepare("UPDATE users SET name = ?, fullname = ?, email = ?, dateob = ?, gender = ?, profile = ? WHERE id = ?");
            // $insert_user = $conn->prepare("INSERT INTO `users`(fullname, email, dateob, gender, profile) VALUES(?,?,?,?,?)");
            $update_user->execute([$username, $name, $email, $pass, $cpass, $image, $user_id]);
            move_uploaded_file($image_tmp_name, $image_folder);

            $success_msg[] = 'Thay doi thong tin thanh cong!';
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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <title>My Profile</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Profile</h1>
        </div>
        <div class="title2">
            <a href="home.php">home</a><span> / profile</span>
        </div>
        <div class="all-infor">
            <div class="left-side">
                <ul class="details-list">
                    <!-- <li onclick="toggleDetails('detail1')">Thông tin cá nhân</li>
                <li onclick="toggleDetails('detail2')">Kinh nghiệm làm việc</li>
                <li onclick="toggleDetails('detail3')">Kỹ năng</li> -->
                    <div class="detail">
                        <li onclick="showcontent('content1')">Your information</li>
                    </div>
                    <div class="detail">
                        <li onclick="showcontent('content2')">Buy History</li>
                    </div>
                    <div class="detail">
                        <li onclick="showcontent('content3')">Cancelled Orders</li>
                    </div>
                    <div class="detail">
                        <li onclick="showcontent('content4')">Sent Message</li>
                    </div>
                </ul>
            </div>
            <div id="content1" class="main-infor active">
                <?php
                $query = $conn->prepare("SELECT name, email, dateob, gender, profile FROM users WHERE id = :user_id");
                $query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $query->execute();

                // Lấy dữ liệu của user
                if ($query->rowcount() > 0) {
                    $user = $query->fetch(PDO::FETCH_ASSOC);

                ?>
                    <form action="" method="post" id="profile-form" enctype="multipart/form-data">

                        <div class="profile">

                            <!-- anh cua user -->
                            <!-- <img src="../image/0.jpg" class="logo-img"> -->

                            <!-- Hình ảnh người dùng -->

                            <button type="button" onclick="showBox(event)">
                                <img src="image/<?= $user['profile'] ?? 'image/0.jpg'; ?>" id="user-image" class="logo-img">
                            </button>
                            <input type="file" name="profile_image" id="image-upload" accept="image" style="display:none;">

                            <!-- <div id="image-viewer" class="image-viewer" style="display:none;">
                                <button onclick="closeViewer()">Đóng</button>
                            </div> -->
                            <!-- Modal để hiển thị ảnh -->
                            <div id="image-viewer" style="display:none; width:450px; height:450px; position: fixed; top: 20%; left: 20%; z-index: 9999; background-color: rgba(0, 0, 0, 0.8); padding: 20px; text-align: center;">
                                <img id="image-preview" src="" alt="Image" style="width: 400px; height: 400px; border:none; border-radius: 0px">
                                <button onclick="closeImageViewer(event)" style="color: white; font-size: 30px; background-color: transparent; border: none; padding: 10px 10px; cursor: pointer; position: relative;">
                                    <span style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); font-size: 30px;">&times;</span>
                                </button>
                            </div>


                            <div id="popup-box" class="popup-box" style="display:none;">
                                <div id="image-modal" class="modal">
                                    <button onclick="viewImage(event)">View Image</button>
                                    <button onclick="changeImage(event)">Change Image</button>
                                </div>
                            </div>



                            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['name'] ?? ''); ?>" disabled>
                            <button type="button" id="edit-button" onclick="enableEdit()"><i class='bx bx-edit-alt'></i></button>
                            <button type="submit" name="save-infor" id="save-button" style="display: none;"><i class='bx bx-save'></i></button>
                            </input>
                            <!-- <button type="button" id="edit-button" onclick="enableEdit()"><i class='bx bx-edit-alt'></i></button>
                            <button type="submit" name="save-infor" id="save-button" style="display: none;"><i class='bx bx-save'></i></button> -->
                        </div>
                        <div class="profile-edit">
                            <div class="text">
                                <!-- <label for="fullname">Fullname :</label> -->
                                <p>Fullname</p>
                                <input type="text" name="fullname" id="fullname-user" value="<?= htmlspecialchars($user['name'] ?? ''); ?>" placeholder="Fullname cua ban" disabled>
                            </div>
                            <div class="text">
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="email-user" value="<?= htmlspecialchars($user['email'] ?? ''); ?>" disabled>
                            </div>
                            <div class="text">
                                <label for="dob">Date of Birth:</label>
                                <input type="date" name="dob" id="dob" value="<?= htmlspecialchars($user['dateob'] ?? ''); ?>" disabled>
                            </div>
                            <div class="text">
                                <label for="gender">Gender:</label>
                                <select name="gender" id="gender" disabled>
                                    <option value="male" <?= ($user['gender'] ?? '') == 'male' ? 'selected' : ''; ?>>Nam</option>
                                    <option value="female" <?= ($user['gender'] ?? '') == 'female' ? 'selected' : ''; ?>>Nữ</option>
                                    <option value="other" <?= ($user['gender'] ?? '') == 'other' ? 'selected' : ''; ?>>Khác</option>
                                </select>
                            </div>

                        </div>
                    </form>
                <?php
                }
                ?>
            </div>

            <div id="content2" class="main-infor">
                <table border="1" cellspacing="0" cellpadding="10">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Name products</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($orders) > 0): ?>
                            <?php $stt = 1; // Biến đếm số thứ tự 
                            ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?= $stt; ?></td> <!-- Hiển thị số thứ tự -->
                                    <td><?= $order['product_name']; ?></td>
                                    <td><?= $order['qty']; ?></td>
                                    <td>$<?= $order['price']; ?></td>
                                    <td><?= date('d M Y, H:i', strtotime($order['date'])); ?></td>
                                    <td><?= $order['status']; ?></td>

                                </tr>
                                <?php $stt++; // Tăng số thứ tự lên 1 
                                ?>
                            <?php endforeach; ?>


                        <?php else: ?>
                            <tr>
                                <td colspan="6">No purchase history found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>

                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="javascript:void(0)" onclick="loadPage(<?= $page - 1; ?>)">&laquo; Prev</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="javascript:void(0)" onclick="loadPage(<?= $i; ?>)" class="<?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="javascript:void(0)" onclick="loadPage(<?= $page + 1; ?>)">Next &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>

            <div id="content3" class="main-infor">
                <table border="1" cellspacing="0" cellpadding="10">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Name products</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($cancelorders) > 0): ?>
                            <?php $stt = 1; // Biến đếm số thứ tự 
                            ?>
                            <?php foreach ($cancelorders as $order): ?>
                                <tr>
                                    <td><?= $stt; ?></td> <!-- Hiển thị số thứ tự -->
                                    <td><?= $order['product_name']; ?></td>
                                    <td><?= $order['qty']; ?></td>
                                    <td>$<?= $order['price']; ?></td>
                                    <td><?= date('d M Y, H:i', strtotime($order['date'])); ?></td>
                                    <td><?= $order['status']; ?></td>

                                </tr>
                                <?php $stt++; // Tăng số thứ tự lên 1 
                                ?>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="6">No purchase history found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="javascript:void(0)" onclick="loadPage(<?= $page - 1; ?>)">&laquo; Prev</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="javascript:void(0)" onclick="loadPage(<?= $i; ?>)" class="<?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="javascript:void(0)" onclick="loadPage(<?= $page + 1; ?>)">Next &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>

            <div id="content4" class="main-infor">
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Subject</th>
                            <th>Content</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($messages) > 0): ?>
                            <?php $stt = 1; // Biến đếm số thứ tự 
                            ?>
                            <?php foreach ($messages as $mess): ?>
                                <tr>
                                    <td><?= $stt; ?></td> <!-- Hiển thị số thứ tự -->
                                    <td><?= $mess['subject']; ?></td>
                                    <td><?= $mess['message']; ?></td>
                                    <td><?= $mess['name']; ?></td>
                                    <td><?= $mess['email']; ?></td>

                                </tr>
                                <?php $stt++; // Tăng số thứ tự lên 1 
                                ?>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="6">No purchase history found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="javascript:void(0)" onclick="loadPage(<?= $page - 1; ?>)">&laquo; Prev</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="javascript:void(0)" onclick="loadPage(<?= $i; ?>)" class="<?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="javascript:void(0)" onclick="loadPage(<?= $page + 1; ?>)">Next &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>





    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>