<?php
require_once "../../config/connect.php";

$sql = "SELECT * FROM order_history ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="icon" href="../images/logo-nha-hang-sang-trong.jpg" type="image/jpg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Lịch sử đặt món</title>
    
</head>
<body>
     <header>
        <div class ="header">
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
                    <li><a href="login.html">Đăng nhập</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <header>
        <h2 style="text-align:center; margin-top:20px;">Lịch Sử Đặt Món</h2>
    </header>

    <div class="history-container">
        <table id="historyTable">
            <thead>
                <tr>
                    <th>Tên món</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Ngày đặt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['food_name']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= number_format($row['price']) ?>đ</td>
            <td><?= $row['order_date'] ?></td>
            <td>
                <a href="delete_history.php?id=<?= $row['id'] ?>"
                   onclick="return confirm('Xóa món này?')">
                   Hủy
                </a>
            </td> 
    </tr>
      <?php endwhile; ?>
      <?php else: ?>
         <tr>
            <td colspan="5" style="text-align:center;">Chưa có lịch sử đặt món</td>
        </tr>
    <?php endif; ?>
        </tbody>
        </table>
<br>

<a href="clear_history.php"
   onclick="return confirm('Xóa toàn bộ lịch sử?')"
   class="btn-clear">
   Xóa toàn bộ lịch sử
</a>

</div>
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
</body>
</html>
