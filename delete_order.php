<?php //PHP code
include '../config.php';
include 'sidebar.php';


if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

   
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);

    
    if ($stmt->execute()) {
        echo "The order is deleted";
    } else {
        echo "Error:No order is deleted " . $conn->error;
    }

    header("Location: home.php");
    exit;
} else {
    echo "Invalid ID for order.";
}
?>
