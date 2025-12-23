<?php
require_once "../../config/connect.php";

$conn->exec("DELETE FROM order_history");

header("Location: history.php");
exit;
