<?php
require_once "../../config/connect.php";

if (!isset($_POST['combo'])) {
    header("Location: combo.php");
    exit;
}

foreach ($_POST['combo'] as $comboId => $data) {

    $people = $data['people'];
    $qty = $data['qty'];
    $extras = $data['extra'] ?? [];

    // lấy giá combo
    $priceRs = $conn->query(
        "SELECT price FROM combo_price
         WHERE combo_id=$comboId AND people=$people"
    );
    $priceRow = $priceRs->fetch_assoc();
    $basePrice = $priceRow['price'];

    $extraPrice = 0;
    $extraNames = [];

    foreach ($extras as $ex) {
        [$name, $price] = explode('|', $ex);
        $extraPrice += $price;
        $extraNames[] = $name;
    }

    $total = ($basePrice + $extraPrice) * $qty;
    $foodName = "Combo $people người";
    if ($extraNames) {
        $foodName .= " (Thêm: " . implode(', ', $extraNames) . ")";
    }

    $stmt = $conn->prepare(
        "INSERT INTO order_history (food_name, quantity, price, order_date)
         VALUES (?, ?, ?, NOW())"
    );
    $stmt->bind_param("sii", $foodName, $qty, $total);
    $stmt->execute();
}

header("Location: history.php");
exit;
