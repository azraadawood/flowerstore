<?php
session_start(); // Start PHP session to manage user session data
require '../config.php'; // Include your database connection file

$error = ''; // Initialize an empty error message variable

if (isset($_POST['login'])) { // Check if login form is submitted
    if (!empty($_POST['email']) && !empty($_POST['password'])) { // Check if email and password are not empty
        $email = $_POST['email']; // Get email from POST data
        $password = md5($_POST['password']); // Hash password using MD5 (not recommended for security)

        // SQL query to select admin with provided email and password
        $sql = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { // If query returns at least one row (valid admin)
            $_SESSION['admins'] = $email; // Set session variable for admin's email
            header("Location: home.php"); // Redirect to admin home page
            exit(); // Exit to prevent further execution
        } else {
            $error = "Invalid email or password!"; // Set error message if credentials are invalid
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amour Florist</title>
    <link rel="stylesheet" href="../style.css"> <!-- Link to custom CSS file -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"> <!-- Link to Font Awesome for icons -->
</head>
<body>
<nav class="navbar navbar-expand-md">
    <!-- Bootstrap navbar with links -->
</nav>

<header>
    <!-- Header section with welcome message for admins -->
</header>

<div class="login-container">
    <!-- Admin login form -->
    <h3 class="text-center">Admin Login</h3>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div> <!-- Display error message if login fails -->
    <?php endif; ?>
    <form action="alogin.php" method="post"> <!-- Form action points to current page for login processing -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" required> <!-- Email input field -->
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required> <!-- Password input field -->
        </div>
        <button type="submit" class="btn btn-primary" name="login">Login</button> <!-- Submit button for login -->
    </form>
</div>

<footer>
    <!-- Footer section with copyright and links -->
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
