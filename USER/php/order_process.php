<?php
require_once "../../config/connect.php";

if (!isset($_POST['items'])) {
    header("Location: menu.php");
    exit;
}

foreach ($_POST['items'] as $item) {
    if (isset($item['checked'])) {

        $name = $item['name'];
        $price = $item['price'];
        $qty = $item['qty'];
        $date = date("Y-m-d H:i:s");

        $stmt = $conn->prepare(
            "INSERT INTO order_history (food_name, quantity, price, order_date)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("siis", $name, $qty, $price, $date);
        $stmt->execute();
    }
}

header("Location: history.php");
exit;
