<?php
include '../config.php';//PHP code
include 'sidebar.php';

$errorMsg = "";

$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html><!--  HTML code -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="admin_style.css"> <!--  CSS code -->
</head>
<body>
<div class="content">
    <h2>Users List</h2>

    <?php
    if (!empty($errorMsg)) {
        echo "<div class='error'>$errorMsg</div>";
    }
    ?>

    <table >
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($user = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['firstName']); ?></td>
                <td><?php echo htmlspecialchars($user['lastName']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                
    <td><a class="btn btn-primary" href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
<a class="btn btn-danger" href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a></td>
            </tr>

           






            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
