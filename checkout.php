<?php
require 'config.php'; // Include your database connection 

session_start();

// Go to sign-in page if user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php"); // Redirect to sign-in page
    exit();
}

$grand_total = 0;
$allItems = '';
$items = [];

// Retrieve items and calculate grand total from the cart table
$sql = "SELECT CONCAT(product_name, ' (', qty, ')') AS ItemQty, total_price FROM cart";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Iterate through cart items and calculate total
while ($row = $result->fetch_assoc()) {
    $grand_total += $row['total_price'];
    $items[] = $row['ItemQty'];
}
$allItems = implode(', ', $items); // Create a comma-separated list of items
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amour Florist</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your custom CSS file -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
</head>
<body>
<header>
    <div class="top-color">
        <div class="logo">
            <img id="logo" src="logo.png" alt="Amour-florist">
        </div>
        <div class="A">
            <p>Amour-florist</p>
            <p>"Bloom together, Grow together"</p>
        </div>
    </div>
</header>

<nav class="navbar navbar-expand-md">
    <a class="navbar-brand" href="index.php"> <i class="fas fa-seedling"></i> Amour Florist</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon">&#9776;</span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link active" href="index.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="about.html">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="contact.html">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="sign_in.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="admin/alogin.php">Admin</a>
            </li>
            <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
                <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search for flowers..." aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 px-4 pb-4" id="order">
            <h4 class="text-center text-info p-2">Complete your order!</h4>
            <div class="p-3 mb-2 text-center">
                <h6 class="lead"><b>Product(s) : </b><?= $allItems; ?></h6>
                <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
                <h5><b>Total Amount Payable: </b>&#82;<?= number_format($grand_total, 2) ?></h5>
            </div>
            <form action="action.php" method="post" id="placeOrder">
                <input type="hidden" name="products" value="<?= $allItems; ?>">
                <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
                </div>
                <div class="form-group">
                    <textarea name="address" class="form-control" rows="2" placeholder="Enter Delivery Address" required></textarea>
                </div>
                <div class="form-group">
                    <h6 class="text-center lead">Select Payment Mode</h6>
                    <select name="pmode" class="form-control">
                        <option value="" selected disabled>-Select Payment Mode-</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Debit Card">Debit Card</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="card_number" class="form-control" placeholder="Enter Card number" required>
                </div>
                <div class="form-group">
                    <input type="text" name="CVV" class="form-control" placeholder="Enter CVV" required>
                </div>
                <div class="form-group">
                    <input type="text" name="expiry_date" class="form-control" placeholder="Enter Expiry date of card" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
                </div>
            </form>
        </div>
    </div>
</div>

<footer>
    <p>© 2024 | Amour-florist | All Rights Reserved</p>
    <a href="privacy.html">Privacy</a>
    <a href="termsandconditions.html">Terms and Conditions</a>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    // Handle form submission using Ajax
    $("#placeOrder").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'action.php',
            method: 'post',
            data: $('form').serialize() + "&action=order",
            success: function(response) {
                $("#order").html(response); // Replace form with response (e.g., success message)
            }
        });
    });
    
    // Function to load and update cart item count
    load_cart_item_number();

    function load_cart_item_number() {
        $.ajax({
            url: 'action.php',
            method: 'get',
            data: {
                cartItem: "cart_item"
            },
            success: function(response) {
                $("#cart-item").html(response); // Update cart item count
            }
        });
    }
});
</script>

</body>
</html>
