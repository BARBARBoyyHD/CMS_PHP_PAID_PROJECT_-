<?php
// Fetch order items for the report
$sql_report = "SELECT oi.order_id, oi.product_name, oi.quantity, oi.price_per_item, oi.total_price, oi.payment_method, o.order_date
               FROM order_items oi
               JOIN orders o ON oi.order_id = o.id
               ORDER BY o.order_date DESC"; // You can adjust the ordering based on your requirement

$result_report = $conn->query($sql_report);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="../assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Orders Report</title>
</head>
<body class="bg-gray-100">
    <header>
        <?php include("../layout/navbar/navbar.html")?>
    </header>
    <main class="flex flex-row">
        <section class="w-full h-full flex justify-center items-center border ">
            <div class="p-8 w-full">
                <h1 class="text-3xl font-bold mb-6">Orders Report</h1>
                <table class="min-w-full bg-white ">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b">Order ID</th>
                            <th class="px-4 py-2 border-b">Product Name</th>
                            <th class="px-4 py-2 border-b">Quantity</th>
                            <th class="px-4 py-2 border-b">Price</th>
                            <th class="px-4 py-2 border-b">Total Price</th>
                            <th class="px-4 py-2 border-b">Payment Method</th>
                            <th class="px-4 py-2 border-b">Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_report->fetch_assoc()): ?>
                            <tr>
                                <td class="px-4 py-2 border-b"><?= $row['order_id'] ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['product_name']) ?></td>
                                <td class="px-4 py-2 border-b"><?= $row['quantity'] ?></td>
                                <td class="px-4 py-2 border-b">Rp <?= number_format($row['price_per_item'], 0, ',', '.') ?></td>
                                <td class="px-4 py-2 border-b">Rp <?= number_format($row['total_price'], 0, ',', '.') ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['payment_method']) ?></td>
                                <td class="px-4 py-2 border-b"><?= $row['order_date'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
