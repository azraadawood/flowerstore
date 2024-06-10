<?php //PHP code
include '../config.php';
include 'sidebar.php';

$message = "";
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        $message = "<div class='message error'>Product not found.</div>";
        exit;
    }
} else {
    $message = "<div class='message error'>Invalid product ID.</div>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_code = $_POST['product_code'];

    if (isset($_FILES['product_image']) && $_FILES['product_image']['size'] > 0) {
        $product_image = $_FILES['product_image']['name'];

        $stmt = $conn->prepare("UPDATE product SET product_name = ?, product_price = ?, product_code = ?, product_image = ? WHERE id = ?");
        $stmt->bind_param("sdssi", $product_name, $product_price, $product_code, $product_image, $product_id);

        if ($stmt->execute()) {
            $target_dir = "../image/";
            $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $message = "<div class='message success'>Product updated successfully.</div>";
                $product['product_image'] = $product_image; // Update product image in case of successful upload
            } else {
                $message = "<div class='message error'>Error uploading product image.</div>";
            }
        } else {
            $message = "<div class='message error'>Error updating product: " . $conn->error . "</div>";
        }
    } else {
        $stmt = $conn->prepare("UPDATE product SET product_name = ?, product_price = ?, product_code = ? WHERE id = ?");
        $stmt->bind_param("sdsi", $product_name, $product_price, $product_code, $product_id);

        if ($stmt->execute()) {
            $message = "<div class='message success'>Product updated successfully.</div>";
        } else {
            $message = "<div class='message error'>Error updating product: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>  <!--  HTML code -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="admin_style.css"> <!--  CSS code -->
</head>
<body>
    <header><h2>Edit Product</h2></header>

    <div class="content">
    <h2>Edit Product</h2>
        <?php echo $message; ?>

        <form method="post" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required><br>

            <label for="product_price">Product Price:</label>
            <input type="number" step="0.01" id="product_price" name="product_price" value="<?php echo htmlspecialchars($product['product_price']); ?>" required><br>

            <label for="product_code">Product Code:</label>
            <input type="text" id="product_code" name="product_code" value="<?php echo htmlspecialchars($product['product_code']); ?>" required><br>

            <label for="product_image">Product Image:</label>
            <img src="../image/<?php echo $product['product_image']; ?>" alt="Product Image" style="max-width: 200px; margin-bottom: 10px;"><br>
            <input type="file" id="product_image" name="product_image" accept="image/"><br>

            <input type="submit" value="Update Product">
        </form>
    </div>

</body>
</html>
