<?php
// Include your database connection
include("../config/db.php");

// Fetch total items sold
$sql_items_sold = "SELECT SUM(quantity) AS total_items_sold FROM order_items";
$result_items_sold = $conn->query($sql_items_sold);
$total_items_sold = 0;
if ($result_items_sold->num_rows > 0) {
    $row = $result_items_sold->fetch_assoc();
    $total_items_sold = $row['total_items_sold'];
}

// Fetch total revenue
$sql_revenue = "SELECT SUM(total_price) AS total_revenue FROM order_items";
$result_revenue = $conn->query($sql_revenue);
$total_revenue = 0;
if ($result_revenue->num_rows > 0) {
    $row = $result_revenue->fetch_assoc();
    $total_revenue = $row['total_revenue'];
}

// Fetch number of orders
$sql_orders_count = "SELECT COUNT(DISTINCT order_id) AS total_orders FROM order_items";
$result_orders_count = $conn->query($sql_orders_count);
$total_orders = 0;
if ($result_orders_count->num_rows > 0) {
    $row = $result_orders_count->fetch_assoc();
    $total_orders = $row['total_orders'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="./assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard</title>
</head>
<body class="bg-gray-100">
    <header>
        <?php include("../layout/navbar/navbar.html")?>
    </header>
    <main class="flex flex-row">
        <section class="hidden md:block mt-[65px] w-1/4">
            <?php include("../layout/sidebar/sidebarAdmin.html")?>
        </section>
        <div class="flex flex-col">
        <section class="w-full h-full flex flex-wrap justify-center items-center  mt-[65px]">
            <div class="p-8 flex-wrap">
                <h1 class="text-3xl font-bold mb-4">Dashboard</h1>
                <div class="grid grid-cols-3 gap-8 flex-wrap">
                    <div class="bg-white p-6 rounded-md shadow-md">
                        <h2 class="text-xl font-semibold mb-2">Total Items Sold</h2>
                        <p class="text-2xl"><?= $total_items_sold ?></p>
                    </div>
                    <div class="bg-white p-6 rounded-md shadow-md">
                        <h2 class="text-xl font-semibold mb-2">Total Revenue</h2>
                        <p class="text-2xl">Rp <?= number_format($total_revenue, 0, ',', '.') ?></p>
                    </div>
                    <div class="bg-white p-6 rounded-md shadow-md">
                        <h2 class="text-xl font-semibold mb-2">Total Orders</h2>
                        <p class="text-2xl"><?= $total_orders ?></p>
                    </div>
                </div>
            </div>
        </section>
        <section class=" flex justify-center items-center">
            <?php include("../php/orderReport.php")?>
        </section>
        </div>
        
    </main>
</body>
</html>
