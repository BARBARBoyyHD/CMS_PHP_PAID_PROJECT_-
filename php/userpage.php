<?php
// Include your database connection
include("../config/db.php");

// Initialize filter variables
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : 'all';

// Base SQL query
$sql = "SELECT * FROM product";

// Apply search and category filters to the query
$whereConditions = [];
if (!empty($searchQuery)) {
    $whereConditions[] = "LOWER(product_name) LIKE '%" . $conn->real_escape_string(strtolower($searchQuery)) . "%'";
}
if ($categoryFilter != 'all') {
    $whereConditions[] = "LOWER(product_category) = '" . $conn->real_escape_string(strtolower($categoryFilter)) . "'";
}

if (count($whereConditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $whereConditions);
}

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}

// Extract unique categories for the dropdown
$categories = array_unique(array_column($products, 'product_category'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="../assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Menu</title>
</head>
<body class="bg-gray-50 font-sans">

    <header>
        <?php include("../layout/navbar/navbar.html") ?>
    </header>

    <main class="flex flex-row mt-[65px] bg-gray-100 p-8">
        <section class="w-full md:w-3/4 p-6 bg-white rounded-lg shadow-lg mx-auto">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Menu</h1>

            <!-- Search and Category Filter -->
            <div class="flex flex-col md:flex-row gap-6 mb-8">
                <form method="GET" id="filter-form" class="flex gap-4 w-full">
                    <input type="search" name="search" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Search products" 
                           class="p-3 border border-gray-300 rounded-lg w-full md:w-2/3 focus:outline-none focus:ring-2 focus:ring-[#982B1C]" 
                           oninput="document.getElementById('filter-form').submit()">
                    <select name="category" id="categoryFilter" class="p-3 border border-gray-300 rounded-lg w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-[#982B1C]" 
                            onchange="document.getElementById('filter-form').submit()">
                        <option value="all">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= strtolower($category) ?>" <?= $categoryFilter == strtolower($category) ? 'selected' : '' ?>><?= htmlspecialchars($category) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <!-- Product List -->
            <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach ($products as $product): ?>
                    <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col justify-between items-center hover:shadow-xl transition-shadow duration-300">
                        <img src="/seblaktasti/upload/<?= $product['image_url'] ?>" 
                             alt="<?= htmlspecialchars($product['product_name']) ?>" 
                             class="w-36 h-36 object-cover mb-4 rounded-md">
                        <div class="text-center">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($product['product_name']) ?></h2>
                            <p class="text-gray-600 text-sm mb-2"><?= htmlspecialchars($product['product_description']) ?></p>
                            <p class="text-gray-500 text-sm mb-4"><?= htmlspecialchars($product['product_category']) ?></p>
                            <p class="text-xl font-semibold text-gray-900">Rp <?= number_format($product['product_price'], 0, ',', '.') ?></p>
                        </div>
                        <button 
                            onclick="addToCart(
                                <?= $product['product_id'] ?>, 
                                '<?= htmlspecialchars($product['product_name']) ?>', 
                                <?= $product['product_price'] ?>, 
                                '<?= htmlspecialchars($product['product_category']) ?>'
                            )" 
                            class="mt-4 bg-[#982B1C] text-white px-6 py-2 rounded-[5px] hover:bg-[#7b2014] focus:outline-none">
                            Add to Cart
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

        </section>
    </main>

    <script type="text/javascript">
        const saveCartToLocalStorage = () => {
            localStorage.setItem('cart', JSON.stringify(cart));
        };

        const addToCart = (id, name, price, category) => {
            const item = cart.find(product => product.id === id);
            if (item) {
                item.quantity++;
            } else {
                cart.push({ id, name, price, category, quantity: 1 });
            }
            saveCartToLocalStorage(); // Save to localStorage
        };
    </script>

</body>
</html>
