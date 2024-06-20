<?php
// Include configuration and sidebar files
include '../config.php';
include 'sidebar.php';

// Check if product ID is provided in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare SQL statement to delete product with specified ID
    $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    // Execute the deletion query
    if ($stmt->execute()) {
        // If deletion is successful, print success message and redirect
        echo "<div class='message success'>Product was deleted successfully.</div>";
        header("Location: products.php"); // Redirect to products.php after deletion
        exit;
    } else {
        // If deletion fails, print error message
        echo "<div class='message error'>Error while deleting product: " . $conn->error . "</div>";
    }
} else {
    // If no product ID is provided in the URL, print error message
    echo "<div class='message error'>Product ID invalid.</div>";
}
?>
