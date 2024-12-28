<?php
include("../config/db.php");

// Check if the ID is provided
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = $_GET['id'];

// Fetch the item to edit
$stmt = $conn->prepare("SELECT * FROM stok WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    die("Item not found.");
}

$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    if (empty($item_name) || $quantity <= 0 || $total_price <= 0) {
        die("Please provide valid inputs.");
    }

    $stmt = $conn->prepare("UPDATE stok SET item_name = ?, quantity = ?, total_price = ? WHERE id = ?");
    $stmt->bind_param("siis", $item_name, $quantity, $total_price, $id);

    if ($stmt->execute()) {
        header("Location: stokList.php");
        exit;
    } else {
        die("Error: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="./assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Stock</title>
</head>
<body class="bg-gray-100">
    <header>
        <?php include("../layout/navbar/navbar.html") ?>
    </header>
    <main class="flex flex-row">
         <section class="border border-black mt-[65px]">
            <?php include("../layout/sidebar/sidebarAdmin.html") ?>
        </section>
        <section class="w-full h-full flex justify-center items-center min-h-screen mt-[65px] bg-white">
            <form action="" method="POST" class="w-full max-w-lg p-6 rounded-md space-y-6">
                <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Edit Stock</h2>

                <div class="mb-4">
                    <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
                    <input type="text" id="item_name" name="item_name" value="<?= htmlspecialchars($item['item_name']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="total_price" class="block text-sm font-medium text-gray-700">Total Price</label>
                    <input type="number" id="total_price" name="total_price" value="<?= htmlspecialchars($item['total_price']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <button type="submit" class="w-full py-2 bg-[#982B1C] text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Update Stock</button>
            </form>
        </section>
    </main>  
</body>
</html>
