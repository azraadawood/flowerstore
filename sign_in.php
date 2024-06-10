<?php //PHP code
session_start();
include("config.php");

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: checkout.php");
        exit();
    } else {
        $signInMessage = "Incorrect Email or Password";
    }
}
?>
<!DOCTYPE html><!-- HTML code -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amour Florist</title>
    <link rel="stylesheet" href="styles.css"><!-- CSS code link -->
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
                <a class="nav-link active" href="about.php">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="contact.php">Contact Us</a>
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





 

 <div class="container" id="signIn">
    <h1 class="form-title">Sign In</h1>
    <form method="post" action="sign_in.php">
    <br>
        <div class="input-group">
       
            <i class="fas fa-envelope"></i>
           
            <label for="">Email</label>
           
            <input type="email" name="email" id="email" placeholder="Email" required>
           
        </div>

        <br><br>
        <br>
     
        <div class="input-group">
        
            <i class="fas fa-lock"></i>
            
            <label for="password">Password</label>
            
            <input type="password" name="password" id="password" placeholder="Password" required>
            
        </div>
        <input type="submit" class="btn" value="Sign In" name="signIn">
    </form>
</div>

    <?php
    if (isset($signInMessage)) {
        echo '<div class="alert alert-danger mt-2">' . $signInMessage . '</div>';
    }
    ?>
    <div class="links">
      <p>Don't have an account yet?</p>
      <a href="sign_up.php">Sign Up</a>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>