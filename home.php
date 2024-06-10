<?php
//Php code
include '../config.php';
include 'sidebar.php';
?>
<!DOCTYPE html> 
<!-- Html code -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="admin_style.css"> <!-- CSS code -->

</head>
<body>

<div class="content">
    <h2>Dashboard</h2>
    <h2>Orders</h2>
    <?php //php code
    $result = $conn->query("SELECT * FROM orders");

   
    if ($result) {
        $orders = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $orders = [];
    }

    // Error check
    if ($conn->error) {
        echo "Error: " . $conn->error;
        $orders = [];
    }

    if (!empty($orders)): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Pmode</th>
                    <th>Products</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['phone']); ?></td>
                        <td><?php echo htmlspecialchars($order['address']); ?></td>
                        <td><?php echo htmlspecialchars($order['pmode']); ?></td>
                        <td><?php echo htmlspecialchars($order['products']); ?></td>
                        <td><a class="btn btn-primary" href="edit_order.php?id=<?php echo $order['id']; ?>">Edit</a></td>
                        <td><a class="btn btn-danger" href="delete_order.php?id=<?php echo $order['id']; ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?> 
</div>

</body> <!-- Html code -->
</html>
