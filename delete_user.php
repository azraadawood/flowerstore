<?php
// Include configuration and sidebar files
include '../config.php';
include 'sidebar.php';

// Check if user ID is provided in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare SQL statement to delete user with specified ID
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    // Execute the deletion query
    if ($stmt->execute()) {
        echo "User was deleted successfully.";
    } else {
        echo "Error while deleting user: " . $conn->error;
    }

    // Redirect to display_accounts.php after deletion
    header("Location: display_accounts.php");
    exit;
} else {
    echo "User ID invalid.";
}
?>
