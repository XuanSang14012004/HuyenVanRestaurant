<?php
header('Content-Type: application/json');

// Kết nối database
$conn = new mysqli("localhost", "root", "", "db_hvrestaurant");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Lỗi kết nối DB"]));
}

// Nhận dữ liệu JSON từ JS
$data = json_decode(file_get_contents("php://input"), true);
$items = $data['items'];
$total = $data['total'];

// Lưu vào bảng orders
$sql = "INSERT INTO orders (total_price) VALUES ($total)";
$conn->query($sql);

// Lấy ID đơn hàng vừa tạo
$order_id = $conn->insert_id;

// Lưu từng món vào order_items
foreach ($items as $item) {
    $name = $conn->real_escape_string($item['name']);
    $price = $item['price'];
    $qty = $item['quantity'];
    $subtotal = $price * $qty;

    $conn->query("
        INSERT INTO order_items (order_id, item_name, price, quantity, subtotal)
        VALUES ($order_id, '$name', $price, $qty, $subtotal)
    ");
}

// Trả về phản hồi
echo json_encode([
    "status" => "success",
    "order_id" => $order_id
]);
?>
