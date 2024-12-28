<?php
// Include your database connection
include("../config/db.php");

// Check if order_id is passed in the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Query to get the order details and items
    $stmt = $conn->prepare("SELECT oi.product_name, oi.product_category, oi.quantity, oi.price_per_item, oi.total_price
                            FROM order_items oi
                            WHERE oi.order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Order ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="./assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Invoice</title>
</head>
<body class="font-sans bg-gray-100">

<header>
    <?php include("../layout/navbar/navbar.html") ?>
</header>

<main class="flex mt-[65px]">
    <section class="w-1/4 border-r border-gray-300">
        <?php include("../layout/sidebar/sidebar.html") ?>
    </section>

    <section class="w-3/4 p-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Invoice #<?= $order_id ?></h1>

            <?php if ($result->num_rows > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-md">
                        <thead>
                            <tr class="text-left text-gray-700 bg-gray-200">
                                <th class="px-6 py-3 border-b">Product Name</th>
                                <th class="px-6 py-3 border-b">Category</th>
                                <th class="px-6 py-3 border-b">Quantity</th>
                                <th class="px-6 py-3 border-b">Price per Item</th>
                                <th class="px-6 py-3 border-b">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $grand_total = 0; // Initialize grand total
                            while ($item = $result->fetch_assoc()): 
                                $grand_total += $item['total_price']; // Accumulate total price
                            ?>
                                <tr class="text-gray-700 border-b hover:bg-gray-50">
                                    <td class="px-6 py-3"><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td class="px-6 py-3"><?= htmlspecialchars($item['product_category']) ?></td>
                                    <td class="px-6 py-3"><?= $item['quantity'] ?></td>
                                    <td class="px-6 py-3">Rp <?= number_format($item['price_per_item'], 0, ',', '.') ?></td>
                                    <td class="px-6 py-3">Rp <?= number_format($item['total_price'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Display Grand Total -->
                <div class="mt-4 text-right">
                    <p class="text-lg font-bold text-gray-700">Grand Total: Rp <?= number_format($grand_total, 0, ',', '.') ?></p>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500">No order items found for this invoice.</p>
            <?php endif; ?>

            <div class="mt-6 text-right">
                <a href="/seblaktasti/php/userpage.php" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Back to Orders</a>
            </div>
        </div>
    </section>
</main>

</body>
</html>
