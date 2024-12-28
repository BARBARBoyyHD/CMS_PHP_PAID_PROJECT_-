<?php
// Include your database connection
include("../config/db.php");

// Fetch all orders from the orders table
$sql_orders = "SELECT * FROM orders";
$result_orders = $conn->query($sql_orders);

// Check if any orders exist
if ($result_orders->num_rows > 0):
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="../assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Orders List</title>
</head>
<body class="bg-gray-100">
    <header>
        <?php include("../layout/navbar/navbar.html") ?>
    </header>
    <main class="flex flex-row">
        <section class=" mt-[65px] w-1/4">
            <?php include("../layout/sidebar/sidebarAdmin.html")?>
        </section>
        <section class="w-full h-full flex justify-center items-center  mt-[65px]">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-md shadow-md mt-[70px]">
        <h1 class="text-3xl font-bold mb-6">Orders List</h1>
     
        <table class="w-full table-auto mb-6">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b">Order ID</th>
                    <th class="px-4 py-2 text-left border-b">Order Date</th>
                    <th class="px-4 py-2 text-left border-b">Total Price</th>
                    <th class="px-4 py-2 text-left border-b">Payment Method</th>
                    <th class="px-4 py-2 text-left border-b">View Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result_orders->fetch_assoc()): ?>
                    <tr>
                        <td class="px-4 py-2 border-b"><?= $order['id'] ?></td>
                        <td class="px-4 py-2 border-b"><?= $order['order_date'] ?></td>
                        <td class="px-4 py-2 border-b">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                        <td class="px-4 py-2 border-b"><?= htmlspecialchars($order['payment_method']) ?></td>
                        <td class="px-4 py-2 border-b">
                        <a href="viewInvoices.php?id=<?= $order['id'] ?>" class="text-blue-500 hover:underline">View Invoice</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
        </section>
    </main>
    
   
</body>
</html>

<?php
else:
    echo "<p>No orders found.</p>";
endif;
?>
