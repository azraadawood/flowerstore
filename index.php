<!DOCTYPE html> <!-- Html code -->
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Azraa Dawood">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Shopping Cart System</title>
  <link rel="stylesheet" href="style.css"> <!-- Link to CSS stylesheet -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' /> <!-- Bootstrap CSS -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' /> <!-- Font Awesome CSS -->
</head>

<body>
  <header>
    <!-- Header section with logo and site name -->
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

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-md">
    <a class="navbar-brand" href="index.php"> <i class="fas fa-seedling"></i> Amour Florist</a>
    <!-- Toggler button for collapsing navbar on small screens -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon">&#9776;</span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <!-- Navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="about.html">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item"
              class="badge badge-danger"></span></a>
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
        <!-- Search form in navbar -->
        <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
          <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search..." label="Search">
          <button class="btn btn-outline-success my-3 my-sm-1" type="submit">Search</button>
        </form>
      </ul>
    </div>
  </nav>

  <!-- Display Products Section -->
  <div class="container">
    <div id="message"></div>
    <div class="row mt-2 pb-3">
      <?php
        include 'config.php'; // Include configuration file for database connection
        $stmt = $conn->prepare('SELECT * FROM product'); // Prepare SQL statement to select all products
        $stmt->execute(); // Execute the prepared statement
        $result = $stmt->get_result(); // Get result set from executed statement
        while ($row = $result->fetch_assoc()): // Loop through each product retrieved
      ?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
        <div class="card-deck">
          <div class="card p-2 border-secondary mb-2">
            <img src="image/<?= $row['product_image'] ?>" class="card-img-top" height="250"> <!-- Product image -->
            <div class="card-body p-1">
              <h4 class="card-title text-center text-info"><?= $row['product_name'] ?></h4> <!-- Product name -->
              <h5 class="card-text text-center text-danger">&#82;<?= number_format($row['product_price'], 2) ?></h5> <!-- Product price -->
              
            </div>
            <div class="card-footer p-1">
              <form action="" class="form-submit">
                <div class="row p-2">
                  <div class="col-md-6 py-1 pl-4">
                    <b>Quantity : </b> <!-- Quantity input label -->
                  </div>
                  <div class="col-md-6">
                    <input type="number" class="form-control pqty" value="1" min="1"> <!-- Quantity input field -->
                  </div>
                </div>
                <!-- Hidden input fields to store product details -->
                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to
                  cart</button> <!-- Add to cart button -->
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- JavaScript libraries -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script> <!-- jQuery -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script> <!-- Bootstrap JS -->

  <script type="text/javascript">
    $(document).ready(function() {
      $(".addItemBtn").click(function(e) {
        e.preventDefault();
        var $form = $(this).closest(".form-submit");
        var pid = $form.find(".pid").val();
        var pname = $form.find(".pname").val();
        var pprice = $form.find(".pprice").val();
        var pimage = $form.find(".pimage").val();
        var pcode = $form.find(".pcode").val();
        var pqty = $form.find(".pqty").val();

        $.ajax({
          url: 'action.php',
          method: 'post',
          data: {
            pid: pid,
            pname: pname,
            pprice: pprice,
            pqty: pqty,
            pimage: pimage,
            pcode: pcode
          },
          success: function(response) {
            $("#message").html(response); // Display response message
            window.scrollTo(0, 0); // Scroll to top of page
            load_cart_item_number(); // Load updated cart item count
          }
        });
      });

      load_cart_item_number(); //  load cart item count

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

  <!-- Footer Section -->
  <footer>
    <h10>©2024 | Amour-florist| All Rights Reserved</h10> <!-- Copyright notice -->
    <a href="privacy.php">Privacy</a> <!-- Privacy policy link -->
    <a href="termsandconditions.php">Terms and Conditions</a> <!-- Terms and conditions link -->
  </footer>
</body>

</html>
