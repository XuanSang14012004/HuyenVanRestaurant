<?php
require_once "../../config/connect.php";

/* LẤY COMBO */
$comboSql = "SELECT * FROM combo";
$comboResult = $conn->query($comboSql);
if (!$comboResult) {
    die("Lỗi bảng combo: " . $conn->error);
}

/* LẤY MENU */
$menuResult = $conn->query("SELECT id, name, price FROM menu_items");
if (!$menuResult) {
    die("Lỗi bảng menu: " . $conn->error);
}

$menuItems = [];
while ($m = $menuResult->fetch_assoc()) {
    $menuItems[] = $m;
}
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
    <title>Combo HuyenVan Restaurant</title>
</head>

<body>
    <style>
        /*-------------- xem thêm món======= */
        .menu-selection.hidden {
            display: none;
        }

        .toggle-extra {
            margin: 8px 0;
            padding: 6px 12px;
            background: #ff9800;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .toggle-extra:hover {
            background: #e68900;
        }
    </style>
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
                    <li><a href="login.html">Đăng nhập</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <header>
        <h1>Đặt Combo Theo Mâm</h1>


        <form action="combo_process.php" method="POST">
            <div class="combo-container">

                <?php while ($combo = $comboResult->fetch_assoc()): ?>
                    <div class="combo-item">
                        <h3><?= htmlspecialchars($combo['name']) ?></h3>

                        <!-- loại mâm -->
                        <label>Loại mâm:
                            <select name="combo[<?= $combo['id'] ?>][people]">
                                <?php
                                $priceSql = "SELECT * FROM combo_price WHERE combo_id=" . $combo['id'];
                                $priceRs = $conn->query($priceSql);

                                if (!$priceRs) {
                                    die("Lỗi combo_price: " . $conn->error);
                                }

                                while ($p = $priceRs->fetch_assoc()):
                                ?>
                                    <option value="<?= $p['people'] ?>" data-price="<?= $p['price'] ?>">
                                        <?= $p['people'] ?> người - <?= number_format($p['price']) ?>đ
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </label>
                        <!-- Gói giá -->
                        <label>
                            Gói giá:
                            <select class="price-type">
                                <option value="600000" data-price="600000">600.000đ</option>
                                <option value="800000" data-price="800000">800.000đ</option>
                                <option value="1000000" data-price="1000000">1.000.000đ</option>
                                <option value="1200000" data-price="1200000"> 1.200.000đ</option>
                                <option value="1500000" data-price="1500000"> 1.500.000đ</option>
                            </select>
                        </label>

                        <!-- số lượng -->
                        <label>Số lượng mâm:
                            <input type="number" name="combo[<?= $combo['id'] ?>][qty]" value="1" min="1">
                        </label>


                        <!-- nút xem thêm -->
                        <button type="button" class="toggle-extra">
                            Xem món thêm
                        </button>

                        <!-- món thêm (ẩn) -->
                        <div class="menu-selection hidden">
                            <?php foreach ($menuItems as $menu): ?>
                                <label>
                                    <input type="checkbox"
                                        data-price="<?= $menu['price'] ?>"
                                        name="combo[<?= $combo['id'] ?>][extra][]"
                                        value="<?= $menu['name'] ?>|<?= $menu['price'] ?>">
                                    <?= htmlspecialchars($menu['name']) ?>
                                    (<?= number_format($menu['price']) ?>đ)
                                </label><br>
                            <?php endforeach; ?>
                        </div>

                        <!-- Hiển thị giá tạm tính -->
                        <p>Giá tạm tính: <span class="combo-price-display">0đ</span></p>
                    </div>
                <?php endwhile; ?>
                <!-- Nút đặt combo -->
                <div class="order-btn">
                    <button id="orderBtn">Đặt Combo</button>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {

                    const comboItems = document.querySelectorAll('.combo-item');
                    const orderBtn = document.getElementById('orderBtn');


                    function formatPrice(price) {
                        return price.toLocaleString('vi-VN') + 'đ';
                    }


                    comboItems.forEach(item => {

                        const quantityInput = item.querySelector('input[type="number"]');
                        const priceSelect = item.querySelector('select');
                        const menuCheckboxes = item.querySelectorAll('input[type="checkbox"]');
                        const priceDisplay = item.querySelector('.combo-price-display');

                        function updatePrice() {
                            const qty = parseInt(quantityInput.value) || 1;

                            // Giá combo
                            const basePrice = parseInt(
                                priceSelect.selectedOptions[0].getAttribute('data-price')
                            ) || 0;

                            // Giá món thêm
                            let extra = 0;
                            menuCheckboxes.forEach(chk => {
                                if (chk.checked) {
                                    extra += parseInt(chk.getAttribute('data-price')) || 0;
                                }
                            });

                            const total = (basePrice + extra) * qty;
                            priceDisplay.innerText = formatPrice(total);

                        }

                        quantityInput.addEventListener('input', updatePrice);
                        priceSelect.addEventListener('change', updatePrice);
                        menuCheckboxes.forEach(chk => chk.addEventListener('change', updatePrice));

                        updatePrice();
                    });

                    // Ngăn submit form khi click đặt combo
                    orderBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        alert("✅ Đặt combo thành công!");
                    });

                    document.querySelectorAll('.toggle-extra').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const comboItem = this.closest('.combo-item');
                            const extraBox = comboItem.querySelector('.menu-selection');

                            if (extraBox.classList.contains('hidden')) {
                                extraBox.classList.remove('hidden');
                                this.innerText = 'Ẩn món thêm';
                            } else {
                                extraBox.classList.add('hidden');
                                this.innerText = 'Xem món thêm';
                            }
                        });
                    });



                });
            </script>

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
</body>

</html>