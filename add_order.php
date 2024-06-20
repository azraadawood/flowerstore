<?php
// Include necessary files for database connection and sidebar
include '../config.php';
include 'sidebar.php';

// Initialize message variable for feedback
$message = "";

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $pmode = $_POST['pmode'];
    $products = $_POST['products'];

    // Prepare an SQL statement to insert the order into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (name, email, phone, address, pmode, products) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $address, $pmode, $products);

    // Execute the statement and set the message based on the result
    if ($stmt->execute()) {
        $message = "Order added successfully.";
    } else {
        $message = "Error adding order: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
    <link rel="stylesheet" href="admin_style.css"> <!-- Link to external CSS for styling -->
</head>
<body>
<!-- Main content section -->
<div class="content">
    <h2>Add Order</h2>

    <!-- Display the message if it's not empty -->
    <?php if (!empty($message)): ?>
        <div><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Order submission form -->
    <form method="post">
        <label for="name">Customer Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="pmode">Payment Mode:</label>
        <select id="pmode" name="pmode" required>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
        </select>

        <label for="products">Products:</label>
        <textarea id="products" name="products" rows="4" required></textarea>

        <input type="submit" value="Add Order">
    </form>
</div>
</body>
</html>

