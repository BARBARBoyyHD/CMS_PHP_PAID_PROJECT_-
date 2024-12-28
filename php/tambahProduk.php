<?php
include("../config/db.php");  // Ensure the database connection is correctly set up
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="../assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add Product</title>
</head>
<body>
<header>
    <?php include("../layout/navbar/navbar.html")?>
</header>
<main class="flex flex-row">
    <section class=" mt-[65px]">
        <?php include("../layout/sidebar/sidebarAdmin.html")?>
    </section>
    <section class="w-full h-full flex justify-center items-center mt-[80px]">
        <form action="processAddProduct.php" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
            <h1 class="text-2xl font-bold">Add Product</h1>
            <div>
                <label for="product_name" class="block text-sm font-medium">Product Name</label>
                <input type="text" id="product_name" name="product_name" required class="border p-2 rounded w-full">
            </div>
            <div>
                <label for="product_description" class="block text-sm font-medium">Description</label>
                <textarea id="product_description" name="product_description" class="border p-2 rounded w-full"></textarea>
            </div>
            <div>
                <label for="product_price" class="block text-sm font-medium">Price</label>
                <input type="number" step="0.01" id="product_price" name="product_price" required class="border p-2 rounded w-full">
            </div>
            <div>
                <label for="product_category" class="block text-sm font-medium">Category</label>
                <input type="text" id="product_category" name="product_category" class="border p-2 rounded w-full">
            </div>
            <div>
                <label for="image" class="block text-sm font-medium">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*" required class="border p-2 rounded w-full">
            </div>
            <button type="submit" class="bg-[#982B1C] text-white p-2 rounded">Add Product</button>
        </form>
    </section>
</main>
</body>
</html>
