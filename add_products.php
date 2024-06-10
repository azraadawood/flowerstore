<!-- PHP code -->
<?php 
include '../config.php';
include 'sidebar.php';

//Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
$message = "";

//Posting to database.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = htmlspecialchars($_POST['product_name']);
    $product_price = htmlspecialchars($_POST['product_price']);
    $product_code = htmlspecialchars($_POST['product_code']);

    $target_dir = "../image/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    //Checks if its an image, throws error if its not.
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if ($check === false) {
        $message .= "<div class='message error'>File is not an image.</div>";
        $uploadOk = 0;
    }

    //It checks if the file exceeds maximum size and throws error if its not. 
    if ($_FILES["product_image"]["size"] > 500000) {
        $message .= "<div class='message error'>Sorry, your file is too large.</div>";
        $uploadOk = 0;
    }

    //It checks format and throws error if its not. 
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $message .= "<div class='message error'>Only JPG, JPEG, PNG & GIF files are allowed.</div>";
        $uploadOk = 0;
    }

    //Checks if the file was uploaded and throws error if its not. 
    if ($uploadOk == 0) {
        $message .= "<div class='message error'>Your file was not uploaded, sorry.</div>";
    } else {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $product_image = basename($_FILES["product_image"]["name"]);

           
            $stmt = $conn->prepare("INSERT INTO product (product_name, product_price, product_code, product_image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdss", $product_name, $product_price, $product_code, $product_image);

            if ($stmt->execute()) {
                $message .= "<div class='message success'>Product was added successfully.</div>";
            } else {
                $message .= "<div class='message error'>Error  " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            $message .= "<div class='message error'>Error uploading file.</div>";
        }
    }
}
?>

<!-- HTML code -->
<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="admin_style.css"> <!-- Link to CSS code -->
</head>
<body>
   
    <div class="content"> 

    <!-- Form to add products -->
    <h2>Add Products</h2>
        <?php echo $message; ?>

        <form method="post" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>

            <label for="product_price">Product Price:</label>
            <input type="number" step="0.01" id="product_price" name="product_price" required>

            <label for="product_code">Product Code:</label>
            <input type="text" id="product_code" name="product_code" required>

            <label for="product_image">Product Image:</label>
            <input type="file" id="product_image" name="product_image" required>

            <input type="submit" value="Add Product">
        </form>
    </div>
</body>
</html>
