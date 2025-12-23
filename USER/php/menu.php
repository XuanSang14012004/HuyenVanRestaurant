<?php
require_once "../../config/connect.php";
$sql = "SELECT * FROM menu_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../images/logo-nha-hang-sang-trong.jpg" type="image/jpg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>HuyenVan Restaurant</title>
</head>

<body>
    <header>
        <div class="header">
            <div class="logo">
                <img src="../../images/logo-nha-hang-sang-trong.jpg" alt="HuyenVan Restaurant Logo">
            </div>
            <nav class="navigation">
                <ul>
                    <li><a href="../html/index.html">Trang chủ</a></li>
                    <li><a href="../php/menu.php">Menu</a></li>
                    <li><a href="../html/about.html">Về chúng tôi</a></li>
                    <li><a href="../html/contact.html">Liên hệ</a></li>
                    <li><a href="../php/history.php">&#xF292;Lịch Sử</a></li>
                    <li><a href="../login.html">Đăng nhập</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="search">
        <input type="text" id="searchBar" onkeyup="searchMenu()" placeholder="Tìm kiếm món ăn...">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    <div class="filter">
        <ul>
            <li><a href="#" onclick="filterMenu('all')">Tất cả</a></li>
            <li><a href="#" onclick="filterMenu('appetizers')">Khai vị</a></li>
            <li><a href="#" onclick="filterMenu('main-courses')">Món chính</a></li>
            <li><a href="#" onclick="filterMenu('desserts')">Tráng miệng</a></li>
            <li><a href="#" onclick="filterMenu('beverages')">Đồ uống</a></li>
            <li><a href="../php/combo.php" onclick="filterMenu('combo')">Combo</a></li>
        </ul>
    </div>

    <form action="order_process.php" method="POST">

        <div class="menu-container">
            <div class="menu-list">

                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="menu-item" data-category="<?= $row['category'] ?>">
                            <input type="checkbox" name="items[<?= $row['id'] ?>][checked]">

                            <img src="../images/<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['name']) ?>">

                            <h3><?= htmlspecialchars($row['name']) ?></h3>

                            <p>Loại món: <strong><?= $row['category'] ?></strong></p>

                            <p><?= htmlspecialchars($row['description']) ?></p>

                            <span class="price"><?= number_format($row['price']) ?>đ</span>

                            <!-- dữ liệu gửi đi -->
                            <input type="hidden" name="items[<?= $row['id'] ?>][name]" value="<?= $row['name'] ?>">
                            <input type="hidden" name="items[<?= $row['id'] ?>][price]" value="<?= $row['price'] ?>">

                            <label>Số lượng:
                                <input type="number" name="items[<?= $row['id'] ?>][qty]" value="1" min="1">
                            </label>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align:center">Chưa có món ăn</p>
                <?php endif; ?>

            </div>

            <!-- Nút đặt tất cả -->
            <div class="order-all">
                <a href="order.html"><button id="orderAllBtn"> Đặt món</button></a>
            </div>
        </div>
    </form>
    <hr>

    <footer>
        <div class="footer">

            <div class="social-media">
                <a href="#">Facebook</a> |
                <a href="#">Twitter</a> |
                <a href="#">Instagram</a>
            </div>
            <p>&copy; 2025 NXS04. All rights reserved.</p>
        </div>

    </footer>
    <script src="script.js"></script>
</body>

</html>