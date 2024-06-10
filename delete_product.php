<?php //PHP code
include '../config.php';
include 'sidebar.php';


if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);


    if ($stmt->execute()) {
        
        echo "<div class='message success'>Product was deleted successfully.</div>";
        header("Location: products.php");
        exit;
    } else {
        
        echo "<div class='message error'>Error while deleting product: " . $conn->error . "</div>";
    }
} else {
    
    echo "<div class='message error'> Product ID invalid.</div>";
}
?>
