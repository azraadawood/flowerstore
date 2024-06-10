<?php // PHP code
include '../config.php';
include 'sidebar.php';


$message = "";

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $order = $result->fetch_assoc();
    } else {
        echo "Order not found.";
        exit;
    }
} else {
    echo "Invalid order ID.";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $pmode = $_POST['pmode'];
    $products = $_POST['products'];

   
    $stmt = $conn->prepare("UPDATE orders SET name=?, email=?, phone=?, address=?, pmode=?, products=? WHERE id=?");
    $stmt->bind_param("ssssssi", $name, $email, $phone, $address, $pmode, $products, $order_id);

    
    if ($stmt->execute()) {
        $message = "Order updated successfully.";
    } else {
        $message = "Error updating order: " . $conn->error;
    }
}
?>

<!DOCTYPE html> <!-- HTML code -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="admin_style.css"> <!-- CSS code -->
   
</head>
<body>

<div class="content"> <!-- HTML AND PHP code -->
    <h2>Edit Order</h2>

    
    <?php if (!empty($message)): ?>
        <div><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post"> 
        <label for="name">Customer Name:</label> 
        <input type="text" id="name" name="name" value="<?php  echo htmlspecialchars($order['name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($order['email']); ?>" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($order['phone']); ?>" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($order['address']); ?>" required>

        <label for="pmode">Payment Mode:</label>
        <select id="pmode" name="pmode" required>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
        </select>

        <label for="products">Products:</label>
        <textarea id="products" name="products" rows="4" required><?php echo htmlspecialchars($order['products']); ?></textarea>

        <input type="submit" value="Update Order">
    </form>
</div>

</body>
</html>
