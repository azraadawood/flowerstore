<?php
session_start();
require 'config.php';

// Add products to the cart
if (isset($_POST['pid'])) {
    $pid = filter_input(INPUT_POST, 'pid');
    $pname = filter_input(INPUT_POST, 'pname');
    $pprice = filter_input(INPUT_POST, 'pprice');
    $pimage = filter_input(INPUT_POST, 'pimage');
    $pcode = filter_input(INPUT_POST, 'pcode');
    $pqty = filter_input(INPUT_POST, 'pqty');

    $pprice = floatval($pprice); // Ensure price is a float
    $pqty = intval($pqty); // Ensure quantity is an integer
    $total_price = $pprice * $pqty; // Calculate total price

    // Check if product already exists in the cart
    $stmt = $conn->prepare('SELECT qty FROM cart WHERE product_code=?');
    $stmt->bind_param('s', $pcode);
    $stmt->execute();
    $res = $stmt->get_result();
    $r = $res->fetch_assoc();

    if ($r) {
        // Update quantity and total price if product exists in the cart
        $existing_qty = intval($r['qty']);
        $new_qty = $existing_qty + $pqty;
        $new_total_price = $new_qty * $pprice;

        $stmt = $conn->prepare('UPDATE cart SET qty=?, total_price=? WHERE product_code=?');
        $stmt->bind_param('ids', $new_qty, $new_total_price, $pcode);
        $stmt->execute();

        echo '<div class="alert alert-success alert-dismissible mt-2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Item quantity updated in your cart!</strong>
              </div>';
    } else {
        // Insert new product into the cart
        $query = $conn->prepare('INSERT INTO cart (product_name, product_price, product_image, qty, total_price, product_code) VALUES (?, ?, ?, ?, ?, ?)');
        $query->bind_param('sssdss', $pname, $pprice, $pimage, $pqty, $total_price, $pcode);
        $query->execute();

        echo '<div class="alert alert-success alert-dismissible mt-3">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Item added to your cart!</strong>
              </div>';
    }
}

// Get number of items in the cart
if (isset($_GET['cartItem']) && $_GET['cartItem'] == 'cart_item') {
    $stmt = $conn->prepare('SELECT * FROM cart');
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    echo $rows;
}

// Remove a single item from the cart
if (isset($_GET['remove'])) {
    $id = filter_input(INPUT_GET, 'remove');
    $stmt = $conn->prepare('DELETE FROM cart WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'Item removed from cart!';
    header('location:cart.php');
}

// Remove all items from the cart
if (isset($_GET['clear'])) {
    $stmt = $conn->prepare('DELETE FROM cart');
    $stmt->execute();

    $_SESSION['message'] = 'All items are removed from cart!';
    header('location:cart.php');
}

// Update total price of the product in the cart table
if (isset($_POST['qty'])) {
    $qty = filter_input(INPUT_POST, 'qty', FILTER_SANITIZE_NUMBER_INT);
    $pid = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT);
    $pprice = filter_input(INPUT_POST, 'pprice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Ensure the price and quantity are cast to float and integer
    $qty = intval($qty);
    $pprice = floatval($pprice);
    $tprice = $qty * $pprice;

    $stmt = $conn->prepare('UPDATE cart SET qty=?, total_price=? WHERE id=?');
    $stmt->bind_param('isi', $qty, $tprice, $pid);
    $stmt->execute();
}

// Checkout and save customer info in the orders table
if (isset($_POST['action']) && $_POST['action'] == 'order') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone');
    $products = filter_input(INPUT_POST, 'products');
    $grand_total = filter_input(INPUT_POST, 'grand_total', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $address = filter_input(INPUT_POST, 'address');
    $pmode = filter_input(INPUT_POST, 'pmode');

    $data = '';

    // Insert order details into orders table
    $stmt = $conn->prepare('INSERT INTO orders (name, email, phone, address, pmode, products, amount_paid) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('sssssss', $name, $email, $phone, $address, $pmode, $products, $grand_total);
    $stmt->execute();

    // Clear the cart after order is placed
    $stmt2 = $conn->prepare('DELETE FROM cart');
    $stmt2->execute();

    // Display order confirmation
    $data .= '<div class="text-center">
                <h1 class="display-4 mt-2 text-danger">Thank You!</h1>
                <h2 class="text-success">Your Order Placed Successfully!</h2>
                <h2 class="text-success">Delivery between 3-5 working days!</h2>
                <h4 class="bg-danger text-light rounded p-2">Items Purchased : ' . htmlspecialchars($products) . '</h4>
                <h4>Your Name : ' . htmlspecialchars($name) . '</h4>
                <h4>Your E-mail : ' . htmlspecialchars($email) . '</h4>
                <h4>Your Phone : ' . htmlspecialchars($phone) . '</h4>
                <h4>Total Amount Paid : ' . number_format($grand_total, 2) . '</h4>
                <h4>Payment Mode : ' . htmlspecialchars($pmode) . '</h4>
              </div>';
    echo $data;
}
?>
