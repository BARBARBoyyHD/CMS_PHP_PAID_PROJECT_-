<?php
include("../config/db.php"); // Include the database connection

// Initialize search query
$searchQuery = '';

// Check if the search form has been submitted
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    // Fetch stock items based on the search query
    $stmt = $conn->prepare("SELECT * FROM stok WHERE item_name LIKE ?");
    $searchTerm = "%" . $searchQuery . "%"; // Add wildcards for partial matching
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Fetch all stock items if no search term is entered
    $result = $conn->query("SELECT * FROM stok");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="../assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Stock List</title>
</head>
<body>
    <header>
        <?php include("../layout/navbar/navbar.html") ?>
    </header>
    <main class="flex flex-row">
        <section class=" mt-[65px] w-1/4">
            <?php include("../layout/sidebar/sidebarAdmin.html")?>
        </section>
        <section class="w-full h-full p-4 mt-[65px]">
            <h1 class="text-2xl font-bold mb-4">Stock List</h1>

            <!-- Search Form -->
            <div class="mb-4">
               
            </div>

            <div class="mb-4 flex flex-row justify-between">
                <a href="/seblaktasti/php/add_stock.php" class="mt-4 inline-block bg-[#982B1C] text-white px-4 py-2 rounded-md hover:bg-blue-600">Add Stock</a>
                <form action="" method="get" class="flex items-center gap-2">
                    <input type="text" name="search" value="<?= htmlspecialchars($searchQuery) ?>" class="px-4 py-2 border border-gray-300 rounded-md" placeholder="Search by item name" />
                    <button type="submit" class="bg-[#982B1C] text-white px-4 py-2 rounded-md hover:bg-blue-600">Search</button>
                </form>
            </div>

            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Item Name</th>
                        <th class="border border-gray-300 px-4 py-2">Quantity</th>
                        <th class="border border-gray-300 px-4 py-2">Total Price</th>
                        <th class="border border-gray-300 px-4 py-2">Added</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['item_name']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['quantity']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['total_price']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['Added']) ?></td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="edit_stock.php?id=<?= $row['id'] ?>" class="text-blue-500 hover:underline">Edit</a>
                                    |
                                    <a href="delete_stock.php?id=<?= $row['id'] ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center px-4 py-2 text-gray-500">No items found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
