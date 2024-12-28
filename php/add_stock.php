<?php
include("../config/db.php"); // Include the database connection

// Handle form submission for adding stock
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    // Validate input
    if (empty($item_name) || $quantity <= 0 || $total_price <= 0) {
        echo "Please provide valid inputs for all fields.";
        exit;
    }

    // Get the current timestamp for when the stock was added
    $timestamp = date('Y-m-d H:i:s');

    // Prepare the SQL INSERT statement to add a new stock entry
    $stmt = $conn->prepare("INSERT INTO stok (item_name, quantity, total_price, Added) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis", $item_name, $quantity, $total_price, $timestamp);

    if ($stmt->execute()) {
        // Redirect to the item list page after successful insert
        header("Location: stokList.php");
        exit;
    } else {
        echo "Error: " . $stmt->error; // Display any errors from the query execution
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="./assets/favicon.ico">
    <title>Add Stock</title>
</head>
<body>
    <header>
        <?php include("../layout/navbar/navbar.html") ?>
    </header>
    <main class="flex flex-row">
        <section class="border border-black mt-[65px]">
            <?php include("../layout/sidebar/sidebarAdmin.html") ?>
        </section>
        <section class="w-full h-full flex justify-center items-center min-h-screen mt-[65px]">
            <form action="" method="POST" class="w-full max-w-lg p-6   rounded-md">
                <h2 class="text-xl font-semibold mb-4">Add Stock</h2>

                <div class="mb-4">
                    <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
                    <input type="text" id="item_name" name="item_name" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="total_price" class="block text-sm font-medium text-gray-700">Total Price</label>
                    <input type="number" id="total_price" name="total_price" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <button type="submit" class="w-full py-2 bg-[#982B1C] text-white rounded-md hover:bg-blue-600">Add Stock</button>
            </form>
        </section>
    </main>
</body>
</html>
