<?php
include("../config/db.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $product_description = trim($_POST['product_description']);
    $product_price = $_POST['product_price'];
    $product_category = trim($_POST['product_category']);
    $image = $_FILES['image'];

    if ($image['error'] === 0) {
        $target_dir = "../upload/";
        $image_name = uniqid() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($image['name']));
        $target_file = $target_dir . $image_name;

        if (!is_dir($target_dir)) {
            echo "Error: Target directory does not exist.";
            exit;
        }

        if (move_uploaded_file($image['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO product (product_name, product_description, product_price, product_category, image_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdss", $product_name, $product_description, $product_price, $product_category, $image_name);

            if ($stmt->execute()) {
                header("Location: ../php/productList.php");
                exit;
            } else {
                echo "Database Error: " . $stmt->error;
            }
        } else {
            echo "Error: Failed to upload the image. Check directory permissions.";
        }
    } else {
        echo "Error: Invalid image file. Error code: " . $image['error'];
    }
} else {
    echo "Invalid request method.";
}
?>
