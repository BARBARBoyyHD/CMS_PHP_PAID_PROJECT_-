<?php
include("../config/db.php");

// Check if the ID is provided
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = $_GET['id'];

// Prepare and execute the DELETE statement
$stmt = $conn->prepare("DELETE FROM stok WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: stokList.php");
    exit;
} else {
    die("Error: " . $stmt->error);
}
?>
