<?php // PHP code
include '../config.php'; // Include configuration file
include 'sidebar.php'; // Include sidebar for admin panel
?>

<!DOCTYPE html> <!-- HTML code -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="admin_style.css"> <!-- CSS code -->
</head>
<body>
<div class="content">
    <h2>Admin Panel</h2>
    <h2>Products</h2>
    <?php // PHP code for fetching and displaying products
    $result = $conn->query("SELECT * FROM product"); // Query to select all products from database

    if ($result) {
        $products = $result->fetch_all(MYSQLI_ASSOC); // Fetch all products as associative array
    } else {
        $products = []; // Initialize empty array if no products found
    }

    if ($conn->error) {
        echo "Error: " . $conn->error; // Display error message if query fails
        $products = []; // Set products array to empty if error occurs
    }

    if (!empty($products)): ?> <!-- Check if there are products to display -->
        <table>
            <thead>
                <tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Image</th>
                    <th>Product Code</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                        <td><?php echo "R" . htmlspecialchars($product['product_price']); ?></td>
                        <td><img src="<?php echo "../image/" . htmlspecialchars($product['product_image']); ?>" style="width:70px; height:70px;" /></td>
                        <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                        <td><a class="btn btn-primary" href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a></td>
                        <td><a class="btn btn-danger" href="delete_product.php?id=<?php echo $product['id']; ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No product found.</p> <!-- Display message if no products found -->
    <?php endif; ?>
</div>
</body>
</html>
