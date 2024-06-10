<?php //PHP code
include '../config.php';
include 'sidebar.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$errorMsg = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

    if ($stmt->execute()) {
        $successMsg = "User was successfully added.";
    } else {
        $errorMsg = "Error  " . $conn->error;
    }
}
?>
<!-- HTML code -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="admin_style.css"> <!-- CSS code link -->
    
    
</head>
<body>

<div class="content">
    <h2>Add user</h2>

    <?php // PHP code
    
    if (!empty($errorMsg)) {
        echo "<div class='error'>$errorMsg</div>";
    }

    if (!empty($successMsg)) {
        echo "<div class='success'>$successMsg</div>";
    }
    ?>
<!-- HTML code -->

    <form method="post">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Add new user">
    </form>
</div>

</body>
</html>
