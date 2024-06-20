<?php
session_start(); //  PHP code
require 'config.php'; // Include your database connection file
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Azraa Dawood">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Shopping Cart System</title>
  <link rel="stylesheet" href="style.css"> <!-- Link to CSS file -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Link to Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"> <!-- Link to Font Awesome for icons -->
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
          <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search..." label="Search">
          <button class="btn btn-outline-success my-3 my-sm-1" type="submit">Search</button>
        </form>
      </ul>
    </div>
  </nav>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <!-- Display success or alert message based on session data -->
        <div style="display:<?php if (isset($_SESSION['showAlert'])) {
                                echo $_SESSION['showAlert'];
                              } else {
                                echo 'none';
                              }
                              unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php if (isset($_SESSION['message'])) {
                      echo $_SESSION['message'];
                    }
                    unset($_SESSION['message']); ?></strong>
        </div>
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-striped text-center">
            <thead>
              <tr>
                <td colspan="7">
                  <h4 class="text-center text-info m-1">Products in your cart!</h4>
                </td>
              </tr>
              <tr>
                <!-- Table headers for cart items -->
                <th>ID</th>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>
                  <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Fetch cart items from database
              $stmt = $conn->prepare('SELECT * FROM cart');
              $stmt->execute();
              $result = $stmt->get_result();
              $grand_total = 0;
              while ($row = $result->fetch_assoc()) :
              ?>
                <tr>
                  <!-- Display each cart item with ID, image, name, price, quantity, total price, and delete option -->
                  <td><?= $row['id'] ?></td>
                  <td><img src="image/<?= $row['product_image'] ?>" width="50"></td>
                  <td><?= $row['product_name'] ?></td>
                  <td>&#82;&nbsp;&nbsp;<?= number_format($row['product_price'], 2); ?></td>
                  <td><?= $row['qty'] ?></td>
                  <td>&#82;&nbsp;&nbsp;<?= number_format($row['total_price'], 2); ?></td>
                  <td>
                    <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');">Delete</i></a>
                  </td>
                </tr>
                <?php $grand_total += $row['total_price']; ?>
              <?php endwhile; ?>
              <tr>
                <!-- Table row for continue shopping, grand total, and checkout -->
                <td colspan="3">
                  <a href="index.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>Continue Shopping</a>
                </td>
                <td colspan="2"><b>Grand Total</b></td>
                <td><b>&#82;&nbsp;&nbsp;<?= number_format($grand_total, 2); ?></b></td>
                <td>
                  <a href="sign_in.php" class="btn btn-info <?= ($grand_total > 0) ? '' : 'disabled'; ?>"><i class="far fa-credit-card"></i>Checkout</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="script.js"></script>

  <footer>
    <!-- Footer  -->
    <p>© 2024 | Amour-florist | All Rights Reserved</p>
    <a href="privacy.php">Privacy</a>
    <a href="termsandconditions.php">Terms and Conditions</a>
  </footer>

</body>

</html>
