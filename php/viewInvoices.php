<?php
// Include your database connection
include("../config/db.php");

// Check if `id` is passed in the URL
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Query to get the order details and items
    $stmt = $conn->prepare("
        SELECT 
            oi.product_name, 
            oi.product_category, 
            oi.quantity, 
            oi.price_per_item, 
            oi.total_price
        FROM order_items oi
        WHERE oi.order_id = ?
    ");

    // Bind the parameter and execute the query
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize grand total
    $grand_total = 0;

    // Check if there are results
    if ($result->num_rows === 0) {
        echo "<div class='text-center text-gray-500 mt-10'>No order items found for this order.</div>";
        exit;
    }
} else {
    echo "<div class='text-center text-red-500 mt-10'>Order ID not provided.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="../assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>View Invoice</title>
</head>
<body class="bg-gray-100">
    <header class="bg-[#982B1C] text-white p-4 shadow-lg">
        <h1 class="text-2xl font-bold">Invoice Details</h1>
    </header>

    <main class="max-w-4xl mx-auto mt-8 p-4 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Order ID: <?= htmlspecialchars($order_id) ?></h2>
        
        <table class="w-full border-collapse border border-gray-300 text-sm text-gray-800">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Product Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Category</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">Quantity</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">Price/Item</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['product_name']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['product_category']) ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-right"><?= htmlspecialchars($row['quantity']) ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-right">Rp <?= number_format($row['price_per_item'], 2) ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-right">Rp <?= number_format($row['total_price'], 2) ?></td>
                    </tr>
                    <?php
                        // Accumulate the total price for grand total
                        $grand_total += $row['total_price'];
                    ?>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="mt-4">
            <div class="flex justify-between font-bold text-lg">
                <span class="text-gray-800">Grand Total</span>
                <span class="text-gray-800">Rp <?= number_format($grand_total, 2) ?></span>
            </div>
        </div>

        <div class="mt-4">
            <a href="/seblaktasti/php/invoiceList.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to Invoices List</a>
        </div>
    </main>
</body>
</html>
