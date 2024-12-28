<?php
include("../config/db.php");  // Include the database connection

// Check if product id is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare the SQL DELETE statement
    $stmt = $conn->prepare("DELETE FROM product WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        // Redirect back to the product list page after successful deletion
        header("Location: productList.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;  // Display any errors from the query execution
    }

    $stmt->close();
} else {
    echo "Invalid product ID.";
}
?>
