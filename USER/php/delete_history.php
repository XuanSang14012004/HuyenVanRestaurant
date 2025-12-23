
<?php
require_once "../../config/connect.php";

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM order_history WHERE id = ?");
$stmt->bind_param("i", $id); // i = integer
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Xóa thành công";
} else {
    echo "Không tìm thấy dữ liệu";
}
