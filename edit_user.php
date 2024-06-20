<?php
// Include configuration and sidebar file
include '../config.php';
include 'sidebar.php';

// Initialize error and success messages
$errorMsg = "";
$successMsg = "";

// Check if 'id' parameter is set in URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare and execute SQL query to fetch user data by ID
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc(); // Fetch user data
    } else {
        $errorMsg = "User not found.";
    }
} else {
    $errorMsg = "Invalid user ID.";
}

// Process form submission (POST method)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];

    // Prepare and execute SQL query to update user data
    $stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, email=? WHERE id=?");
    $stmt->bind_param("sssi", $firstName, $lastName, $email, $user_id);

    // Execute query and check for success
    if ($stmt->execute()) {
        $successMsg = "User updated successfully.";
    } else {
        $errorMsg = "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="admin_style.css"> <!-- Link to CSS stylesheet -->
</head>
<body>

<div class="content">
    <h2>Edit User</h2>

    <?php
    // Display error or success messages if they exist
    if (!empty($errorMsg)) {
        echo "<div class='error'>$errorMsg</div>";
    }

    if (!empty($successMsg)) {
        echo "<div class='success'>$successMsg</div>";
    }
    ?>

    <form method="post"> <!-- User update form -->
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['firstName']); ?>" required>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user['lastName']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <input type="submit" value="Update User">
    </form>
</div>

</body>
</html>
