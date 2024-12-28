<?php
include("../config/db.php");  // Include the database connection

// Check if product id is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product data from the database
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo "Product not found.";
        exit;
    }

    $stmt->close();
} else {
    echo "Invalid product ID.";
    exit;
}

// Handle form submission for updating product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $product_description = trim($_POST['product_description']);
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];

    // Handle image upload
    $image_url = $product['image_url']; // Keep the existing image if no new image is uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../upload/';
        $image_url = time() . '-' . basename($_FILES['product_image']['name']);
        $image_path = $upload_dir . $image_url;

        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path)) {
            // Image uploaded successfully
        } else {
            echo "Error uploading image.";
            exit;
        }
    }

    // Prepare the SQL UPDATE statement
    // Change product_price to d for double type and ensure correct binding
    $stmt = $conn->prepare("UPDATE product SET product_name = ?, product_description = ?, product_price = ?, product_category = ?, image_url = ? WHERE product_id = ?");
    $stmt->bind_param("ssdssi", $product_name, $product_description, $product_price, $product_category, $image_url, $product_id);

    if ($stmt->execute()) {
        // Redirect to the product list page after successful update
        header("Location: productList.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;  // Display any errors from the query execution
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="../assets/favicon.ico">
    <title>Edit Product</title>
</head>
<body>
    <header>
        <?php include("../layout/navbar/navbar.html") ?>
    </header>
    <main class="flex flex-row">
        <section class="border border-black mt-[65px]">
            <?php include("../layout/sidebar/sidebarAdmin.html") ?>
        </section>
        <section class="w-full h-full flex justify-center items-center border border-black mt-[65px]">
            <form action="" method="POST" enctype="multipart/form-data" class="w-full max-w-lg p-6 bg-white shadow-md rounded-md">
                <h2 class="text-xl font-semibold mb-4">Edit Product</h2>

                <div class="mb-4">
                    <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="product_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="product_description" name="product_description" class="w-full px-4 py-2 border border-gray-300 rounded-md"><?= htmlspecialchars($product['product_description']) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="product_price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" id="product_price" name="product_price" value="<?= htmlspecialchars($product['product_price']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="product_category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" id="product_category" name="product_category" value="<?= htmlspecialchars($product['product_category']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="product_image" class="block text-sm font-medium text-gray-700">Product Image</label>
                    <input type="file" id="product_image" name="product_image" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    <img src="../upload/<?= $product['image_url'] ?>" alt="Current Image" class="mt-2 w-32 h-32 object-cover">
                </div>

                <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Update Product</button>
            </form>
        </section>
    </main>
</body>
</html>
