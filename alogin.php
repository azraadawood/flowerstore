<?php //PHP code
session_start();
require '../config.php';  


$error = '';

if (isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = md5($_POST['password']); 

       
        $sql = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            
            $_SESSION['admins'] = $email;
            header("Location: home.php");
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    
}
}
?>
<!DOCTYPE html><!-- HTML code -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amour Florist</title>
    <link rel="stylesheet" href="../style.css"><!-- CSS code -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
</head>
<body>


<nav class="navbar navbar-expand-md">
    <a class="navbar-brand" href="index.php"> <i class="fas fa-seedling"></i> Amour Florist</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon">&#9776;</span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link active" href="../index.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../about.php">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../contact.php">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../sign_in.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="alogin.php">Admin</a>
            </li>
            <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
                <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search for flowers..." aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </ul>
    </div>
</nav>

 


  <header> <!-- HTML code -->
   
   <div class="B">
     <p>This is for admins ONLY, please 
       click 'Amour-florist'
        to direct back to products</p>
     <p>Thank you</p>
   </div>
 
</header>



<!-- HTML and PHP code -->
<div class="login-container"> 
    <h3 class="text-center">Admin Login</h3>
    <?php if (!empty($error)): ?> 
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="alogin.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Login</button>
    </form>
</div>
<br><br><br><br>
<footer>
    <h10>  ©2024 | Amour-florist| All Rights Reserved </h10>
    
            <a href="../privacy.php" >Privacy</a>
            <a href="../termsandconditions.php">Terms and Conditions</a>

</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
