<?php //php code
include '../config.php'; // Include your database connection file
include 'sidebar.php'; // Include sidebar.php for admin panel layout

error_reporting(E_ALL); // Enable error reporting for debugging
ini_set('display_errors', 1); // Display errors 

$errorMsg = ""; // Initialize error message variable
$successMsg = ""; // Initialize success message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if form is submitted via POST method

    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to insert data into database
    $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $password); // Bind parameters for security

    if ($stmt->execute()) { // Execute SQL statement
        $successMsg = "User was successfully added."; // Set success message if insertion is successful
    } else {
        $errorMsg = "Error: " . $conn->error; // Set error message if insertion fails
    }
}
?>
<!DOCTYPE html> <!-- HTML CODE -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="admin_style.css"> <!-- Link to CSS file -->
</head>
<body>

<div class="content">
    <h2>Add user</h2>

    <?php // PHP code to display success or error messages
    if (!empty($errorMsg)) {
        echo "<div class='error'>$errorMsg</div>"; // Display error message if not empty
    }

    if (!empty($successMsg)) {
        echo "<div class='success'>$successMsg</div>"; // Display success message if not empty
    }
    ?>

    <form method="post">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Add new user"> <!-- Submit button for form -->
    </form>
</div>

</body>
</html>
