<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="icon" href="../images/logo-nha-hang-sang-trong.jpg" type="image/jpg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Đặt hàng - HuyenVan Restaurant</title>

</head>
<body>

    <header>
        <h1>🧾 Xác nhận đơn hàng</h1>
    </header>

    <div id="orderSummary"></div>

    <div style="text-align:center; margin-top:20px;">
        <a href="menu.php" class="btn">← Quay lại Menu</a>
    </div>

    <script>
const orderSummary = document.getElementById('orderSummary');
const items = JSON.parse(localStorage.getItem('selectedItems')) || [];

if (items.length === 0) {
    orderSummary.innerHTML = '<p>⚠️ Bạn chưa chọn món nào. <a href="menu.html">Quay lại Menu</a></p>';
} else {
    let total = 0;
    let html = `
        <table border="1" cellpadding="10" cellspacing="0" style="margin:auto;">
            <tr>
                <th>Tên món</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tạm tính</th>
            </tr>
    `;

    items.forEach(item => {
        const price = Number(item.price);
        const qty = Number(item.quantity);
        const subtotal = price * qty;

        html += `
            <tr>
                <td>${item.name}</td>
                <td>${price.toLocaleString()}đ</td>
                <td>${qty}</td>
                <td>${subtotal.toLocaleString()}đ</td>
            </tr>
        `;

        total += subtotal;
    });

    html += `
        <tr>
            <th colspan="3">Tổng cộng</th>
            <th>${total.toLocaleString()}đ</th>
        </tr>
        </table>

        <br>
        <button onclick="confirmOrder()" class="btn-confirm">Xác nhận đặt hàng</button>
    `;

    orderSummary.innerHTML = html;
}

function confirmOrder() {
    alert('Đặt hàng thành công! 🎉');
    localStorage.removeItem('selectedItems');
    window.location.href = 'menu.php';
}
</script>


</body>
</html>
