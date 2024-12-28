<?php
// Include your database connection
include("../config/db.php");

// Initialize search query
$searchQuery = '';

// Check if the search form has been submitted
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    // Prepare a query to search by product name
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_name LIKE ?");
    $searchTerm = "%" . $searchQuery . "%"; // Add wildcards for partial matching
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Fetch all products if no search term is entered
    $result = $conn->query("SELECT * FROM product");
}

if ($result->num_rows > 0) {
    // Fetch all products in an associative array
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="./assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Product List</title>
</head>
<body>
    <header>
        <?php include("../layout/navbar/navbar.html")?>
    </header>
    <main class="flex flex-row">
        <section class=" mt-[65px] w-1/4">
            <?php include("../layout/sidebar/sidebarAdmin.html")?>
        </section>
        <section class="w-full h-full border borde-black flex justify-center items-center mt-[65px]">
            <div class="w-full px-6 py-4">
                <h1 class="text-2xl font-bold mb-4">Product List</h1>
                
                <!-- Search Form -->
                <div class="mb-4">
                    <form action="" method="get" class="flex items-center space-x-2">
                        <input type="text" name="search" value="<?= htmlspecialchars($searchQuery) ?>" class="px-4 py-2 border border-gray-300 rounded-md" placeholder="Search by product name" />
                        <button type="submit" class="bg-[#982B1C] text-white px-4 py-2 rounded-md hover:bg-blue-600">Search</button>
                    </form>
                </div>

                <!-- Table to display products -->
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2 border-b">Product ID</th>
                            <th class="px-4 py-2 border-b">Product Name</th>
                            <th class="px-4 py-2 border-b">Description</th>
                            <th class="px-4 py-2 border-b">Price</th>
                            <th class="px-4 py-2 border-b">Category</th>
                            <th class="px-4 py-2 border-b">Image</th>
                            <th class="px-4 py-2 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($products) > 0): ?>
                            <?php foreach ($products as $product): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border-b"><?= $product['product_id'] ?></td>
                                    <td class="px-4 py-2 border-b"><?= $product['product_name'] ?></td>
                                    <td class="px-4 py-2 border-b"><?= $product['product_description'] ?></td>
                                    <td class="px-4 py-2 border-b">Rp <?= number_format($product['product_price'], 0, ',', '.') ?></td>
                                    <td class="px-4 py-2 border-b"><?= $product['product_category'] ?></td>
                                    <td class="px-4 py-2 border-b">
                                        <?php if (!empty($product['image_url'])): ?>
                                            <img src="../upload/<?= $product['image_url'] ?>" alt="<?= $product['product_name'] ?>" class="w-16 h-16 object-cover">
                                        <?php else: ?>
                                            <span>No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        <a href="editProduct.php?id=<?= $product['product_id'] ?>" class="text-blue-500 hover:underline">Edit</a>
                                        |
                                        <a href="deleteProduct.php?id=<?= $product['product_id'] ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-4 py-2 text-center text-gray-500">No products found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
