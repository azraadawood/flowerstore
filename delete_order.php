<?php
// Include configuration and sidebar files
include '../config.php';
include 'sidebar.php';

// Check if order ID is provided in the URL
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Prepare SQL statement to delete order with specified ID
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);

    // Execute the deletion query
    if ($stmt->execute()) {
        // If deletion is successful, print success message
        echo "The order is deleted";
    } else {
        // If deletion fails, print error message
        echo "Error: No order is deleted " . $conn->error;
    }

    // Redirect to home.php after deletion
    header("Location: home.php");
    exit;
} else {
    // If no order ID is provided in the URL, print error message
    echo "Invalid ID for order.";
}
?>
