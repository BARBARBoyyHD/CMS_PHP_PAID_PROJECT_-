<?php
// Include your database connection
include("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get cart details and payment method from the form
    $cart = json_decode($_POST['cart'], true);
    $payment_method = $_POST['payment_method'];

    if (empty($cart)) {
        echo "Cart is empty!";
        exit;
    }

    // Insert order details into the orders table
    $order_date = date('Y-m-d H:i:s');
    $total_price = array_reduce($cart, function ($sum, $item) {
        return $sum + ($item['price'] * $item['quantity']);
    }, 0);

    $stmt = $conn->prepare("INSERT INTO orders (order_date, total_price, payment_method) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $order_date, $total_price, $payment_method);
    $stmt->execute();
    $order_id = $conn->insert_id; // Get the generated order_id

    // Insert items into order_items table
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_category, quantity, price_per_item, total_price, payment_method) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($cart as $item) {
        $total_item_price = $item['price'] * $item['quantity'];
        $stmt->bind_param(
            "iissidds",
            $order_id,
            $item['id'],
            $item['name'],
            $item['category'],
            $item['quantity'],
            $item['price'],
            $total_item_price,
            $payment_method
        );
        $stmt->execute();
    }

    // Return the order_id
    echo $order_id;
}
?>
